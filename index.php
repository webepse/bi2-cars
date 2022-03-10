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
        $cars = $bdd->query("SELECT voiture.model AS vmodel, marques.nom AS mnom, voiture.id AS vid FROM voiture INNER JOIN marques ON voiture.id_marque = marques.id");
        while($car = $cars->fetch())
        {
            echo "<a href='voiture.php?id=".$car['vid']."' class='car'>".$car['mnom']." ".$car['vmodel']."</a>";
        }
        $cars->closeCursor();
    ?>

</body>
</html>