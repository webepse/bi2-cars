<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    
    require "../connexion.php";

    if(isset($_GET['delete']))
    {
        $id=htmlspecialchars($_GET['delete']);
        $mark = $bdd->prepare("SELECT * FROM marques WHERE id=?");
        $mark->execute([$id]);
        if(!$donMark = $mark->fetch())
        {
            $mark->closeCursor();
            header("LOCATION:404.php");
        }
        $mark->closeCursor();

        unlink("../images/".$donMark['logo']);

        // supprimer les voitures de la marque
            // supprimer les images de voitures (cover)
            // supprimer les galeries images de voitures de la marque  

        // autre possibilité, vérifier s'il y a des voitures de la marque à supprimer, si c'est le cas, stopper l'action et prévenir l'utilisateur d'aller supprimer les voitures 


        $deleteBrands = $bdd->prepare("DELETE FROM marques WHERE id=?");
        $deleteBrands->execute([$id]);
        $deleteBrands->closeCursor();

        header("LOCATION:mark.php?deleteSuccess=".$id);

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
        <h1>Les marques de voiture</h1>
        <a href="markAdd.php" class="btn btn-primary">Ajouter</a>
        <?php
            if(isset($_GET['addMark']))
            {
                echo "<div class='alert alert-success'>Vous avez bien ajouté une marque de voiture à la base de données</div>";
            }

            if(isset($_GET['markUpdate']))
            {
                echo "<div class='alert alert-warning'>Vous avez bien modifié la marque n°".$_GET['markUpdate']."</div>";
            }

            if(isset($_GET['deleteSuccess']))
            {
                echo "<div class='alert alert-danger'>Vous avez bien supprimé la marque n°".$_GET['deleteSuccess']."</div>";
            }
        ?>
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
                      $brands = $bdd->query("SELECT * FROM marques");
                       while($donbrands = $brands->fetch())
                       {
                            echo "<tr>";    
                                echo "<td>".$donbrands['id']."</td>";
                                echo "<td>".$donbrands['nom']."</td>";
                                echo "<td>";
                                    echo "<a href='markUpdate.php?id=".$donbrands['id']."' class='btn btn-warning mx-2'>Modifier</a>";
                                    echo "<a href='mark.php?delete=".$donbrands['id']."' class='btn btn-danger mx-2'>Supprimer</a>";
                                echo "</td>";
                            echo "</tr>";
                       }
                       $brands->closeCursor();

                ?>
            </tbody>
        </table>
    </div>    
</body>
</html>