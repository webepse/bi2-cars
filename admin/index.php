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
    <div class="container">
        <h1 class="py-5 text-center">connexion à l'admin</h1>
        <form action="index.php" method="POST">
            <div class="row">
                <div class="col-4 offset-4">
                    <div class="form-group py-3">
                        <label for="login">Login: </label>
                        <input type="text" id="login" name="login" class="form-control">
                    </div>
                    <div class="form-group py-3">
                        <label for="mdp">Mot de passe: </label>
                        <input type="password" name="password" id="mdp" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Connexion" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>

    </div>
</body>
</html>