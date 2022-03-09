<?php
    require "connexion.php";

    // vérif si le get ID existe
    // si oui : je protège la valeur avec htmlspecialchars
    // si non: je redirige vers index.php car mon fichier ne fonctionne pas sans id
    if(isset($_GET['id']))
    {
        $id = htmlspecialchars($_GET['id']);
    }else{
        header("LOCATION:index.php");
    }

    // faire la requête à la base de données
    $car = $bdd->prepare("SELECT marques.logo AS mlogo, voiture.model AS vmodel, marques.nom AS mnom, voiture.carburant AS vcarburant, voiture.catalogue AS vcatalogue, voiture.cover AS image FROM voiture INNER JOIN marques ON voiture.id_marque = marques.id WHERE voiture.id=?");
    $car->execute([$id]);

    // vérif si j'ai une correspondance dans ma base de données sinon je redirige
    if(!$don = $car->fetch())
    {
        $car->closeCursor();
        header("LOCATION:404.php");
    }

    $car->closeCursor();

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
    <img src="images/<?= $don['mlogo'] ?>" alt="logo <?= $don['mnom'] ?>">
    <h2><?= $don['mnom'] ?></h2>
    <h1><?= $don['vmodel'] ?></h1>
    <img src="images/<?= $don['image'] ?>" alt="image <?= $don['vmodel'] ?>">
    <div class="info">
        <div class="carburant">Carburant: 
            <?php
                switch($don['vcarburant'])
                {
                    case 'E':
                        echo "Essence";
                        break;
                    case 'D':
                        echo "Diesel";
                        break;
                    case 'H':
                        echo "Hybride";
                        break;
                    case 'EL':
                        echo "Electrique";
                        break;
                    default:
                        echo "inconnu";
                }
            ?>
        </div>
    </div>
    <h1>Galerie d'image</h1>
    <?php
        $galerie = $bdd->prepare("SELECT * FROM images WHERE id_voiture=?");
        $galerie->execute([$id]);
        while($image = $galerie->fetch())
        {
            echo "<div class='images'><img src='images/".$image['image']."' alt='image de ".$don['vmodel']."'></div>";
        }
        $galerie->closeCursor();
    ?>
</body>
</html>