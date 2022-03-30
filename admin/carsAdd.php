<?php 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <form action="treatmentCarsAdd.php" method="POST" enctype="multipart/form-data">
            <div class="form-group my-2">
                <label for="marque">Marque:</label>
                <select name="marque" id="marque" class="form-control">
                    <?php
                        require "../connexion.php";
                        $brands = $bdd->query("SELECT * FROM marques");
                        while($donBrands = $brands->fetch()){
                            echo "<option value='".$donBrands['id']."'>".$donBrands['nom']."</option>";
                        }
                        $brands->closeCursor();
                    ?>
                </select>
            </div>
            <div class="form-group my-2">
                <label for="model">Modèle: </label>
                <input type="text" id="model" name="model" class="form-control" value="">
            </div>
            <div class="form-group my-2">
                <label for="carbu">Carburant: </label>
                <select name="carburant" id="carbur" class="form-control">
                    <option value="E">Essence</option>
                    <option value="D">Diesel</option>
                    <option value="El">Electrique</option>
                    <option value="H">Hybride</option>
                </select>
            </div>
            <div class="form-group my-2">
                <label for="cover">Image de couverture: </label>
                <input type="file" name="cover" id="cover" class="form-control">
            </div>
            <div class="form-group my-2">
                <input type="submit" value="Enregister" class="btn btn-success">
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
    </div>
</body>
</html>
    
