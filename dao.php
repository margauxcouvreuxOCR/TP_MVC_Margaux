<?php

class DAO
{
    private $database = "formation"; // Nom de la base de données
    private $user = "root";           // Nom d'utilisateur de la base de données
    private $pwd = "root";            // Mot de passe de la base de données
    private $dbh;                     // Gestionnaire de connexion à la base de données

    // Constructeur
    public function __construct() {}

    // Méthode de connexion à la base de données
    public function connection()
    {
        try {
            // Création d'une nouvelle connexion PDO à la base de données
            $this->dbh = new PDO('mysql:host=db;dbname=' . $this->database, $this->user, $this->pwd);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En cas d'erreur de connexion, afficher un message d'erreur
            echo "Oups ! Problème de connexion. Veuillez réessayer plus tard : " . $e;
        }
    }

    // Méthode pour exécuter une requête SQL
    public function executeSQL($sql)
    {
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    // Méthode pour récupérer tous les membres sous forme de tableau associatif
    public function getAllMembres()
    {
        return $this->executeSQL("SELECT * FROM `membres`")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer un membre par son ID
    public function getMembreById($id)
    {
        $sql = "SELECT * FROM membres WHERE id_membre = :id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindValue(":id", intval($id), PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Méthode pour modifier les informations d'un stagiaire
    public function modifierStagiaire($id, $nom, $prenom)
    {
        try {
            $nom = strtoupper($nom); // Convertit le nom en majuscules
            $prenom = ucfirst(strtolower($prenom)); // Convertit la première lettre du prénom en majuscule et le reste en minuscules
            $sql = "UPDATE membres SET nom_membre = :nom, login_membre = :prenom WHERE id_membre = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
            $stmt->bindValue(":id", intval($id), PDO::PARAM_INT);
            
            // Exécuter la mise à jour et vérifier si elle a réussi
            if ($stmt->execute()) {
                echo "Mise à jour réussie.";  // Pour vérifier que l'update a bien lieu
            } else {
                echo "Échec de la mise à jour.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }

    // Méthode pour supprimer un membre en fonction de son ID
    public function deleteOneMembre($id)
    {
        try {
            $sql = "DELETE FROM membres WHERE id_membre = :id";
            $reponse = $this->dbh->prepare($sql);
            $reponse->bindValue(":id", intval($id), PDO::PARAM_INT);
            $reponse->execute();
        } catch (PDOException $e) {
            // En cas d'erreur de suppression, afficher un message d'erreur
            echo "Erreur lors de la suppression : " . $e->getMessage();
        }
    }

    // Méthode pour ajouter un nouveau stagiaire
    public function ajouterStagiaire($nom, $prenom)
    {
        try {
            $nom = strtoupper($nom); // Convertit le nom en majuscules
            $prenom = ucfirst(strtolower($prenom)); // Convertit la première lettre du prénom en majuscule et le reste en minuscules
            $sql = "INSERT INTO membres (nom_membre, login_membre) VALUES (:nom, :prenom)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":nom", $nom, PDO::PARAM_STR);
            $stmt->bindValue(":prenom", $prenom, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            // En cas d'erreur d'ajout, afficher un message d'erreur
            echo "Erreur lors de l'ajout du stagiaire : " . $e->getMessage();
        }
    }

    // Méthode pour déconnecter de la base de données
    public function deconnection()
    {
        $this->dbh = null;
    }
}
?>
