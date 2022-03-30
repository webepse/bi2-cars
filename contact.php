<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
    <script>
        window.addEventListener('load',()=>{
            const myForm = document.querySelector("#my-form")
    
            console.log(myForm)

            myForm.onsubmit = (event) => {
                event.preventDefault()
                const nom = document.querySelector("#nom")
                var errorNom = true
                console.log(nom.value)
                const email = document.querySelector("#email")
                var errorEmail = true
                console.log(email.value)
                const message = document.querySelector("#message")
                var errorMessage = true
                console.log(message.value)

                // valider les données

                if(nom.value=="")
                {
                    nom.classList.add('is-invalid')
                    errorNom = true
                }else{
                    nom.classList.remove('is-invalid')
                    errorNom = false
                }

                if(email.value=="")
                {
                    email.classList.add('is-invalid')
                    errorEmail = true
                }else{
                    email.classList.remove('is-invalid')
                    errorEmail = false
                }

                if(message.value=="")
                {
                    message.classList.add("is-invalid")
                    errorMessage = true
                }else{
                    message.classList.remove("is-invalid")
                    errorMessage = false
                }


                if(!errorNom && !errorEmail && !errorMessage)
                {
                    myForm.submit()
                }else{
                    console.log("J'ai une erreur")
                }


                
            }

        })



    </script>
</head>
<body>
    <div class="container">
        <h2>Contact</h2>
        <form action="treatment.php" method="POST" id="my-form">
            <div class="form-group my-3">
                <label for="nom">Nom: </label>
                <input type="text" name="nom" id="nom" class="form-control">
                <div class="invalid-feedback">
                    Veuillez donner votre nom 
                </div>
            </div>
            <div class="form-group my-3">
                <label for="email">Email: </label>
                <input type="email" name="email" id="email" class="form-control">
                <div class="invalid-feedback">
                    Veuillez donner votre adresse E-mail
                </div>
            </div>
            <div class="form-group my-3">
                <label for="message">Message: </label>
                <textarea name="message" id="message" rows="10" class="form-control"></textarea>
                <div class="invalid-feedback">
                    Veuillez donner un message
                </div>
            </div>
            <div class="my-3">
                <input type="submit" value="Envoyer" class="btn btn-success">
            </div>

            <?php 
                if(isset($_GET['error']))
                {
                    echo "<div class='alert alert-danger my-3'>Une erreur s'est produite (code erreur: ".$_GET['error'].")</div>";
                }
            ?>

        </form>
    </div>

    
</body>
</html>