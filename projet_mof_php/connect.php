<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body{
            background-image:url('https://plus.unsplash.com/premium_photo-1661936361131-c421746dcd0d?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        section {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

<?php
if(isset($_POST['admin']) && isset($_POST['mdpass'])){
    $admin = $_POST['admin'];
    $mpass = $_POST['mdpass'];
    if($admin == 'maty.bigue' && $mpass =="bigs_b"){
        //Redierction en cas de succes
        $id = isset($_GET["id"]) ? $_GET["id"] : null;

        if ($id) {
         header("Location: update.php?id=$id");
        } else {
         header("Location: liste1.php");
        }
        exit;

        
    }else{
        echo 'Erreur de connexion';
    }
}
?>


    <section>

        <div class="form-container">
        <h1>Authentification</h1>
        <!-- Formulaire d'authentification -->
            <form method="POST">
                <div class="mb-3">
                    <label for="admin" class="form-label">Login</label>
                    <input type="text" class="form-control" id="admin" name="admin">
                </div>
                <div class="mb-3">
                    <label for="mdpass" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="mdpass" name="mdpass">
                </div>
                <button type="submit" class="btn btn-primary">Connexion</button>
            </form>
        </div>
    </section>


</body>
</html>