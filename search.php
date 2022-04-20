<?php
    require "connexion.php";

   // pour gèrer la value de l'input search
    if(isset($_GET['search']))
    {
        // sécurité
        $search = htmlspecialchars($_GET['search']);
    }else{
        $search="";
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <h2>Rechercher</h2>
    <form action="search.php" method="GET">
        <div>
            <label for="recherche">Recherche: </label>
            <input type="text" id="recherche" name="search" value="<?= $search ?>">
            <input type="submit" value="Rechercher">
        </div>

    </form>
    <?php 

             // je suis en mode recherche (rechercher dans la base de données) ou c'est la 1ère fois que j'arrive (rien à faire)
            if(isset($_GET['search']))
            {
                // requête à la bdd
                $req = $bdd->prepare("SELECT marques.nom AS mnom, voiture.model AS vmodel, voiture.id as vid FROM marques INNER JOIN voiture ON marques.id=voiture.id_marque WHERE marques.nom LIKE :search OR voiture.model LIKE :search ORDER BY marques.nom ASC");
                $req->execute([
                    ":search"=> "%".$search."%"
                ]);
                // vérifier si j'ai au moins une réponse 
                $nb = $req->rowCount();
                if($nb>0)
                {
                    while($don = $req->fetch())
                    {
                        echo "<div><a href='voiture.php?id=".$don['vid']."'>".$don['mnom']." ".$don['vmodel']."</a></div>";
                    }
                }else{
                    echo "<div id='resultat'>Aucun résultat pour cette recherche</div>";
                }
                $req->closeCursor();
                
            }

    ?>
</body>
</html>