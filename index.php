<?php
require_once 'dao.php'; // Inclusion du fichier DAO
$maDao = new DAO(); // Création de l'instance de la classe DAO
$maDao->connection(); // Connexion à la base de données

ob_start(); // Démarrer la temporisation de sortie

// Vérifier s'il y a une action spécifiée dans l'URL
if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "suppr":
            // Action de suppression
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]); // Conversion de l'ID en entier pour plus de sécurité
                $maDao->deleteOneMembre($id); // Suppression du membre avec l'ID spécifié
                header("Location: index.php"); // Redirection vers la page principale après suppression
                exit(); // Arrêt de l'exécution du script
            } else {
                echo "<span style='color:red'>Aucun identifiant de membre envoyé.</span>";
            }
            break;

        case "modif":
            // Action de modification
            if (isset($_GET["id"])) {
                $id = intval($_GET["id"]); // Conversion de l'ID en entier
                $stagiaire = $maDao->getMembreById($id); // Récupération des informations du stagiaire
                if (!$stagiaire) {
                    echo "<span style='color:red'>Aucun stagiaire trouvé avec cet ID.</span>";
                    break;
                }

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Traitement du formulaire de modification
                    if (isset($_POST["nom_stagiaire"]) && isset($_POST["prenom_stagiaire"])) {
                        $nom = $_POST["nom_stagiaire"];
                        $prenom = $_POST["prenom_stagiaire"];

                        // Modification du stagiaire
                        $maDao->modifierStagiaire($id, $nom, $prenom);
                        
                        ob_clean(); // Supprime le contenu tamponné pour éviter l'erreur de redirection
                        header("Location: index.php"); // Redirection vers la liste
                        exit();
                    } else {
                        echo "<span style='color:red'>Veuillez remplir tous les champs.</span>";
                    }
                } else {
                    require_once("ajoutmodif.php"); // Afficher le formulaire de modification
                }
            } else {
                echo "<span style='color:red'>Aucun ID de stagiaire spécifié.</span>";
            }
            break;

        case "ajout":
            // Action d'ajout
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Traitement du formulaire d'ajout
                if (isset($_POST["nom_stagiaire"]) && isset($_POST["prenom_stagiaire"])) {
                    $nom = $_POST["nom_stagiaire"];
                    $prenom = $_POST["prenom_stagiaire"];
                    $maDao->ajouterStagiaire($nom, $prenom); // Ajout du nouveau stagiaire
                    
                    ob_clean(); // Supprime le contenu tamponné pour éviter l'erreur de redirection
                    header("Location: index.php"); // Redirection vers la page principale après ajout
                    exit();
                } else {
                    echo "<span style='color:red'>Veuillez remplir tous les champs.</span>";
                }
            } else {
                require_once("ajoutmodif.php"); // Afficher le formulaire d'ajout
            }
            break;

        default:
            // Afficher la liste des stagiaires par défaut
            require_once("bdd.php");
            break;
    }
} else {
    // Afficher la liste des stagiaires si aucune action n'est spécifiée
    require_once("bdd.php");
}

$maDao->deconnection(); // Déconnexion de la base de données

ob_end_flush(); // Terminer la temporisation de sortie et envoyer tout le contenu tamponné
?>
