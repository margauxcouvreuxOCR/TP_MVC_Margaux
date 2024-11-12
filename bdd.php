<?php
// Inclure le fichier contenant la classe DAO
require_once 'dao.php';

// Créer une instance de la classe DAO
$maDAO = new DAO();

// Se connecter à la base de données
$maDAO->connection();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Liste des Stagiaires</title>
</head>
<body class="p-5">
    <h1 class="text-center">Stagiaires</h1>

    <!-- Tableau des stagiaires -->
    <table class="table w-50">
        <tr>
            <th>Id membre</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Suppression</th>
        </tr>

        <?php
        // Boucle sur tous les membres récupérés depuis la base de données
        foreach ($maDAO->getAllMembres() as $membre) {
        ?>
            <tr>
                <td><?php echo $membre['id_membre']; ?></td>
                <td><a href="index.php?action=modif&id=<?php echo $membre['id_membre']; ?>"><?php echo $membre['nom_membre']; ?></a></td>
                <td><?php echo $membre['login_membre']; ?></td>
                <td><a href="index.php?action=suppr&id=<?php echo $membre['id_membre']; ?>" class="btn btn-danger">Supprimer</a></td>
            </tr>
        <?php } ?>
    </table>
    
    <!-- Bouton pour ajouter un nouveau stagiaire -->
    <button onclick="window.location.href='index.php?action=ajout'" class="btn btn-primary">Ajouter un stagiaire</button>

    <!-- Inclusion du bundle Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Déconnexion de la base de données
$maDAO->deconnection();
?>
