<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

    // mode suppression
    if(isset($_GET['delete']))
    {
        // protection de l'id qui est delete 
        $id = htmlspecialchars($_GET['delete']);
        // recherche dans la bdd la valeur que l'on souhaite supprimer
        $req = $bdd->prepare("SELECT * FROM voiture WHERE id=?");
        $req->execute([$id]);
        // vérification si la valeur à supprimer existe
        if(!$don=$req->fetch())
        {
            // la valeur n'existe pas, fermer la requête, redirection vers une page introuvable (404)
            $req->closeCursor();
            header("LOCATION:404.php");
        }
        // je ne suis pas rentré dans le test (si valeur n'existe pas) alors je continue sur ma page
        $req->closeCursor();
        // supprimer l'image
        unlink("../images/".$don['cover']);

        // suppression des image de la galerie associé à la voiture 
        $gal = $bdd->prepare("SELECT * FROM images WHERE id_voiture=?");
        $gal->execute([$id]);
        while($galDon=$gal->fetch())
        {
            unlink("../images/".$galDon['image']);
        }
        $gal->closeCursor();

        // supprimer les données des images dans la bdd
        $deleteimg = $bdd->prepare("DELETE FROM images WHERE id_voiture=?");
        $deleteimg->execute([$id]);
        $deleteimg->closeCursor();

        // supprimer les données dans la bdd
        $delete = $bdd->prepare("DELETE FROM voiture WHERE id=?");
        $delete->execute([$id]);
        $delete->closeCursor();

        // j'ai tout supprimé en rapport avec la voiture donc je redirect vers la page cars avec une info validant la suppression
        header("LOCATION:cars.php?deleteSuccess=".$id);
      
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <?php 
        include("partials/header.php");
    ?>
    <div class="container-fluid">
        <h1>Les voitures</h1>
        <a href="carsAdd.php" class="btn btn-primary">Ajouter</a>
        <?php
            if(isset($_GET['addCars']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une voiture à la base de données</div>";
            }

            if(isset($_GET['UpdateCars']))
            {
                echo "<div class='alert alert-warning'>Vous avez bien modifié la voiture n°".$_GET['UpdateCars']."</div>";
            }

            if(isset($_GET['deleteSuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé la voiture n°".$_GET['deleteSuccess']."</div>";
            }
        ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>marque</th>
                    <th>Modèle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                      $cars = $bdd->query("SELECT voiture.model AS vmodel, marques.nom AS mnom, voiture.id AS vid FROM voiture INNER JOIN marques ON voiture.id_marque = marques.id");
                       while($donCars = $cars->fetch())
                       {
                            echo "<tr>";    
                                echo "<td>".$donCars['vid']."</td>";
                                echo "<td>".$donCars['mnom']."</td>";
                                echo "<td>".$donCars['vmodel']."</td>";
                                echo "<td>";
                                    echo "<a href='carsUpdate.php?id=".$donCars['vid']."' class='btn btn-warning mx-2'>Modifier</a>";
                                    echo "<a href='cars.php?delete=".$donCars['vid']."' class='btn btn-danger mx-2'>Supprimer</a>";
                                echo "</td>";
                            echo "</tr>";
                       }
                       $cars->closeCursor();

                ?>
            </tbody>
        </table>
    </div>    
</body>
</html>