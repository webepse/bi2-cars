<?php 
    session_start();
    if(!isset($_SESSION['login'])){
        header("LOCATION:403.php");
    }

    if(isset($_GET['deco']))
    {
        session_destroy();
        header("LOCATION:index.php");
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
        <h1>Dashboard</h1>
        <div class="row d-flex justify-content-between">
            <div class="col-3 bg-primary text-white text-center">
                <h2>Voiture(s)</h2>
                <?php
                    $cars = $bdd->query("SELECT * FROM voiture");
                    $nbCars = $cars->rowCount();
                    echo "<h3>".$nbCars."</h3>";
                ?>
                
            </div>
            <div class="col-3 bg-warning text-white text-center">
                <h2>marque(s)</h2>
                <?php
                    $brands = $bdd->query("SELECT * FROM marques");
                    $nbBrands = $brands->rowCount();
                    echo "<h3>".$nbBrands."</h3>";
                ?>
            </div>
            <div class="col-3 bg-success text-white text-center">
                <h2>utilisateur(s)</h2>
                <?php
                    $users = $bdd->query("SELECT * FROM users");
                    $nbUsers = $users->rowCount();
                    echo "<h3>".$nbUsers."</h3>";
                ?>
            </div>
        </div>


    </div>
</body>
</html>