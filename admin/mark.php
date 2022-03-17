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
        <h1>Les marques de voiture</h1>
        <a href="markAdd.php" class="btn btn-primary">Ajouter</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>marque</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                      $cars = $bdd->query("SELECT * FROM marques");
                       while($donCars = $cars->fetch())
                       {
                            echo "<tr>";    
                                echo "<td>".$donCars['id']."</td>";
                                echo "<td>".$donCars['nom']."</td>";
                                echo "<td>";
                                    echo "<a href='' class='btn btn-warning mx-2'>Modifier</a>";
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