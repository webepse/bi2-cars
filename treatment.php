<?php
    if(isset($_POST['nom']))
    {
        $err = 0;

        if(empty($_POST['nom']))
        {
            $err=1;
        }else{
            $nom = htmlspecialchars($_POST['nom']);
        }

        if(empty($_POST['email']))
        {
            $err=2;
        }else{
            $email = htmlspecialchars($_POST['email']);
        }

        if(empty($_POST['message']))
        {
            $err=3;
        }else{
            $message = htmlspecialchars($_POST['message']);
        }

        if($err==0)
        {

        }else{
            header("LOCATION:contact.php?error=".$err);
        }



    }else{
        header("contact.php");
    }


