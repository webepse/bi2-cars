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

     // vérifier si formulaire envoyé ou non
     if(isset($_POST['model']))
     {
         // connexion à la bdd
         require "../connexion.php";
 
         // pour le debug
         var_dump($_POST);
         // var_dump($_FILES);
 
         // vérif tout sauf le fichier 
         $err = 0;
         if(empty($_POST['marque']))
         {
             $err=1;
         }else{
             $marque=htmlspecialchars($_POST['marque']); // protection avant req sinon risque
             // si la marque donnée existe ou non dans ma base de données
             $brands = $bdd->prepare("SELECT * FROM marques WHERE id=?");
             $brands->execute([$marque]);
             if(!$donBrands = $brands->fetch()){
                 $err=6;
             }
             $brands->closeCursor();
         }
 
         if(empty($_POST['model'])){
             $err=2;
         }else{
             $model=htmlspecialchars($_POST['model']);
         }
 
         if(empty($_POST['carburant']))
         {
             $err=3;
         }else{
             // test si la valeur donnée est acceptée ou non 
             $carburant=htmlspecialchars($_POST['carburant']);
             $accptCarbu=["E","D","EL","H"];
             if(!in_array($carburant,$accptCarbu))
             {
                 $err=4;
             }    
         }
 
 
         // vérifier si formulaire ok ou non
         if($err == 0){
            // vérifier si fichier dans le champs image ou non
            if(empty($_FILES['cover']['tmp_name']))
            {
                // traitement sans image
                 // modification de la base de données 
                 $update = $bdd->prepare("UPDATE voiture SET id_marque=:idMark, model=:model, carburant=:carbu WHERE id=:id");
                 $update->execute([
                     ":idMark"=>$marque,
                     ":model"=>$model,
                     ":carbu"=>$carburant,
                     ":id"=>$id
                 ]);
                 $update->closeCursor();
                 // redirection vers le tableau des voitures
                 header("LOCATION:cars.php?UpdateCars=".$id);
            }else{
                // traitement avec image

                // supprimer l'image
                unlink("../images/".$don['cover']);
                  //gestion de l'image
                $dossier = '../images/';
                $fichier = basename($_FILES['cover']['name']);
                $taille_maxi = 200000;
                $taille = filesize($_FILES['cover']['tmp_name']);
                $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
                $extension = strrchr($_FILES['cover']['name'], '.');
    
                if(!in_array($extension,$extensions)){
                    $imgError = 2; // problème au niveau de l'extension
                }
    
                if($taille>$taille_maxi)
                {
                    $imgError = 3; // problème pour la taille du fichier
                }
    
                // vérif si prob avec  le fichier envoyé
                if(isset($imgError))
                {
                    header("LOCATION:carsAdd.php?imgerror=".$imgError);
                }else{
                    //  pas de problème donc on va essayer de le déplacer et gérer la syntaxe du nom de fichier
                    //On formate le nom du fichier, strtr remplace tous les KK spéciaux en normaux suivant notre liste
                    $fichier = strtr($fichier,
                    'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ',
                    'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                    $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier); // preg_replace remplace tout ce qui n'est pas un KK normal en tiret
    
                    // gestion des conflits 
    
                    $fichiercpt = rand().$fichier;
    
                    // déplacement du fichier dans le bon dossier avec le bon nom
                    if(move_uploaded_file($_FILES['cover']['tmp_name'], $dossier.$fichiercpt))
                    {
                        // modification de la base de données 
                        $update = $bdd->prepare("UPDATE voiture SET id_marque=:idMark, model=:model, carburant=:carbu, cover=:cover WHERE id=:id");
                        $update->execute([
                            ":idMark"=>$marque,
                            ":model"=>$model,
                            ":carbu"=>$carburant,
                            ":cover"=>$fichiercpt,
                            ":id"=>$id
                        ]);
                        $update->closeCursor();
                        // redirection vers le tableau des voitures
                        header("LOCATION:cars.php?UpdateCars=".$id);
                        
                    }else{
                        header("LOCATION:carsUpdate.php?id=".$id."&imgerror=4");
                    }
 
             }
            }
         }else{
             header("LOCATION:carsUpdate.php?id=".$id."&error=".$err);
         }
 
     }else{
         // redirection dans le cas ou l'utilisateur passe sur le fichier sans passer par le formulaire
         header("LOCATION:carsUpdate.php?id=".$id);
     }
     
