<?php
// Vérifie si une modification est en cours en regardant s'il y a un paramètre 'id' dans l'URL
$isEditing = isset($_GET['id']);
$stagiaire = null;

// Si une modification est en cours, récupère les informations du stagiaire correspondant
if ($isEditing) {
    $id = intval($_GET['id']); // Convertit l'id en entier pour des raisons de sécurité
    $stagiaire = $maDao->getMembreById($id); // Récupère les informations du stagiaire depuis la base de données
    if (!$stagiaire) {
        die("Aucun stagiaire trouvé avec cet ID."); // Si aucun stagiaire n'est trouvé, affiche un message d'erreur et arrête l'exécution du script
    }
}
?>

<!-- Titre du formulaire, qui change en fonction de si on ajoute ou modifie un stagiaire -->
<h1><?php echo $isEditing ? "Modification" : "Ajout"; ?> stagiaire</h1>

<!-- Formulaire pour ajouter ou modifier un stagiaire -->
<form action="index.php?action=<?php echo $isEditing ? "modif&id=" . $stagiaire['id_membre'] : "ajout"; ?>" method="POST">
    <label for="inputNomStagiaire">Nom: </label>
    <!-- Champ pour le nom du stagiaire, prérempli si on modifie -->
    <input type="text" id="inputNomStagiaire" name="nom_stagiaire" value="<?php echo $isEditing ? $stagiaire['nom_membre'] : ""; ?>">

    <label for="inputPrenomStagiaire">Prénom: </label>
    <!-- Champ pour le prénom du stagiaire, prérempli si on modifie -->
    <input type="text" id="inputPrenomStagiaire" name="prenom_stagiaire" value="<?php echo $isEditing ? $stagiaire['login_membre'] : ""; ?>">

    <!-- Boutons pour soumettre ou annuler le formulaire -->
    <input type="submit" value="Envoyer">
    <input type="reset" value="Annuler">
</form>
