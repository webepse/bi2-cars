<?php
    require "connexion.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  

    <title>Document</title>
</head>
<body>
    <h1>Cars</h1>
    <?php
        $voitures = $bdd->query("SELECT voiture.model AS vmodel, marques.nom AS mnom, voiture.id AS vid FROM voiture INNER JOIN marques ON voiture.id_marque = marques.id");
        while($voiture = $voitures->fetch())
        {
            echo "<a href='voiture.php?id=".$voiture['vid']."' class='car'>".$voiture['mnom']." ".$voiture['vmodel']."</a>";
        }
        $voitures->closeCursor();
    ?>
    <h3><a href="contact.php">Envoyer un message</a></h3>

</body>
</html>