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
        <h2>Ajouter une image à <?= $don['model'] ?> </h2>

        <form action="treatmentImgAdd.php?id=<?= $don['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group my-3">
                <label for="image">Image de galerie</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" value="Ajouter" class="btn btn-success">
            </div>
        </form>
    </div>   
</body>
</html>
    
