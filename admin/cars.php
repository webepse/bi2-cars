<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

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
                                    echo "<a href='' class='btn btn-danger mx-2'>Supprimer</a>";
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