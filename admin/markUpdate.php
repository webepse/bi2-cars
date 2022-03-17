<?php 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }
    // j'ai besoin de id pour fonctionner
    if(!isset($_GET['id']))
    {
        header("LOCATION:mark.php");
    }else{
        $id = htmlspecialchars($_GET['id']);
    }


    require "../connexion.php";
    $req = $bdd->prepare("SELECT * FROM marques WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:mark.php");
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
        <h1>Ajouter une marque</h1>
        <form action="treatmentMarkUpdate.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group my-3">
              <label for="marque">Marque: </label>
              <input type="text" id="marque" name="marque" value="<?= $don['nom'] ?>" class="form-control">
          </div>
          <div class="form-group my-3">
                <div class="col-4">
                    <img src="../images/<?= $don['logo'] ?>" alt="logo de voiture" class="img-fluid">
                </div>
              <label for="logo">Logo: </label>
              <input type="file" name="logo" id="logo" class="form-control">
          </div>
          <div class="form-group my-3">
              <input type="submit" value="Ajouter" class="btn btn-primary">
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