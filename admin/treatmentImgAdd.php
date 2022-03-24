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


    // vérif si la voiture existe bien
    require "../connexion.php";
    $req = $bdd->prepare("SELECT * FROM voiture WHERE id=?");
    $req->execute([$id]);
    if(!$don = $req->fetch())
    {
        $req->closeCursor();
        header("LOCATION:cars.php");
    }
    $req->closeCursor();

     // vérifier si formulaire image ($_FILES) envoyé ou non
    if(!empty($_FILES['image']['tmp_name']))
    {
        //gestion de l'image
        $dossier = '../images/';
        $fichier = basename($_FILES['image']['name']);
        $taille_maxi = 200000;
        $taille = filesize($_FILES['image']['tmp_name']);
        $extensions = ['.png', '.gif', '.jpg', '.jpeg'];
        $extension = strrchr($_FILES['image']['name'], '.');

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
            header("LOCATION:imgAdd.php?id=".$id."&error=".$imgError);
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
            if(move_uploaded_file($_FILES['image']['tmp_name'], $dossier.$fichiercpt))
            {
              // insertion dans la base de données
              $insert = $bdd->prepare("INSERT INTO images(image,id_voiture) VALUES(:image,:id)");
              $insert->execute([
                  ':image'=>$fichiercpt,
                  ":id"=>$id
              ]);
              $insert->closeCursor();
              header("LOCATION:carsUpdate.php?id=".$id);

            }else{
                header("LOCATION:imgAdd.php?id=".$id."&error=4");
            }

        }
    }
     else{
         // redirection dans le cas ou l'utilisateur passe sur le fichier sans passer par le formulaire
         header("LOCATION:imgAdd.php?error=1&id=".$id);
     }
     
