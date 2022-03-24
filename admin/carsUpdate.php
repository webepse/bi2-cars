<?php 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }

// j'ai besoin de id pour fonctionner
if(!isset($_GET['id']))
{
    header("LOCATION:cars.php");
}else{
    $id = htmlspecialchars($_GET['id']);
}


require "../connexion.php";
$req = $bdd->prepare("SELECT * FROM voiture WHERE id=?");
$req->execute([$id]);
if(!$don = $req->fetch())
{
    $req->closeCursor();
    header("LOCATION:cars.php");
}
$req->closeCursor();


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
    <div class="container">
        <h1>Ajouter une voiture</h1>
        <form action="treatmentCarsUpdate.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="marque">Marque:</label>
                <select name="marque" id="marque" class="form-control">
                    <?php
                        require "../connexion.php";
                        $brands = $bdd->query("SELECT * FROM marques");
                        while($donBrands = $brands->fetch()){
                            if($don['id_marque']==$donBrands['id']){
                                echo "<option value='".$donBrands['id']."' selected>".$donBrands['nom']."</option>";
                            }else{
                                echo "<option value='".$donBrands['id']."'>".$donBrands['nom']."</option>";
                            }
                        }
                        $brands->closeCursor();
                    ?>
                </select>
            </div>
            <div class="form-group my-2">
                <label for="model">Modèle: </label>
                <input type="text" id="model" name="model" class="form-control" value="<?= $don['model'] ?>">
            </div>
            <div class="form-group my-2">
                <label for="carbu">Carburant: </label>
                <select name="carburant" id="carbur" class="form-control">
                    <?php 
                        if($don['carburant']=="E")
                        {
                            echo '<option value="E" selected>Essence</option>';
                            echo '<option value="D">Diesel</option>';
                            echo '<option value="El">Electrique</option>';
                            echo '<option value="H">Hybride</option>';
                            
                        }elseif($don['carburant']=="D")
                        {
                            echo '<option value="E">Essence</option>';
                            echo '<option value="D" selected>Diesel</option>';
                            echo '<option value="El">Electrique</option>';
                            echo '<option value="H">Hybride</option>';
                        }elseif($don['carburant']=="El")
                        {
                            echo '<option value="E">Essence</option>';
                            echo '<option value="D">Diesel</option>';
                            echo '<option value="El" selected>Electrique</option>';
                            echo '<option value="H">Hybride</option>';
                        }else{
                            echo '<option value="E">Essence</option>';
                            echo '<option value="D">Diesel</option>';
                            echo '<option value="El">Electrique</option>';
                            echo '<option value="H" selected>Hybride</option>';
                        }

                    ?>
                   
                   
                    
                    
                </select>
            </div>
            <div class="form-group my-2">
                <div class="col-4">
                    <img src="../images/<?= $don['cover'] ?>" alt="image de voiture" class="img-fluid">
                </div>
                <label for="cover">Image de couverture: </label>
                <input type="file" name="cover" id="cover" class="form-control">
            </div>
            <div class="form-group my-2">
                <input type="submit" value="Modifier" class="btn btn-warning">
            </div>
            <?php
                if(isset($_GET['error']))
                {
                    echo "<div class='alert alert-danger my-3'>Une erreur s'est produite (code erreur: ".$_GET['error'].")</div>";
                }

                if(isset($_GET['imgerror']))
                {
                    switch($_GET['imgerror'])
                    {
                        case 2: 
                            echo "<div class='alert alert-danger'>L'extension de votre fichier n'est pas acceptée</div>";
                            break;
                        case 3:
                            echo "<div class='alert alert-danger'>La taille de votre fichier dépasse la limite autorisée</div>";
                            break;  
                        case 4:
                            echo "<div class='alert alert-danger'>Une erreur est survenue, veuillez recommencer</div>";
                            break;  
                        default: 
                            echo "<div class='alert alert-danger'>Une erreur est survenue</div>";      
                    }
                }
            ?>
        </form>

        <h3>Galerie d'image</h3>
        <a href="imgAdd.php?id=<?= $id ?>" class="btn btn-primary">Ajouter une image</a>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>image</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $galImg = $bdd->prepare("SELECT * FROM images WHERE id_voiture=?");
                    $galImg->execute([$id]);
                    while($donGalImg=$galImg->fetch())
                    {
                        echo "<tr>";
                            echo "<td>".$donGalImg['id']."</td>";
                            echo "<td>".$donGalImg['image']."</td>";
                            echo "<td><a href='' class='btn btn-danger'>Supprimer</a></td>";
                        echo "</tr>";
                    }
                    $galImg->closeCursor();
                ?>
            </tbody>
        </table>


    </div>
</body>
</html>
    
