<?php
    require "connexion.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Document</title>
</head>
<body>
    <h1>Cars</h1>
    <form action="search.php" method="GET">
        <div>
            <label for="recherche">Recherche: </label>
            <input type="text" id="recherche" name="search">
            <input type="submit" value="Rechercher">
        </div>

    </form>
    <div id="container-voiture">
        <?php
            $voitures = $bdd->query("SELECT voiture.model AS vmodel, marques.nom AS mnom, voiture.id AS vid FROM voiture INNER JOIN marques ON voiture.id_marque = marques.id ORDER BY voiture.id DESC LIMIT 6");
            while($voiture = $voitures->fetch())
            {
                // echo "<div class='voitures' style='background-color: ".$voiture['color'].";'><a href='voiture.php?id=".$voiture['vid']."' class='car'>".$voiture['mnom']." ".$voiture['vmodel']."</a></div>";
                echo "<div class='voitures'><a href='voiture.php?id=".$voiture['vid']."' class='car'>".$voiture['mnom']." ".$voiture['vmodel']."</a></div>";
            }
            $voitures->closeCursor();
        ?>
    </div>
    <h3><a href="contact.php">Envoyer un message</a></h3>

</body>
</html>