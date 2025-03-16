<html lang="fr">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
      <style type="text/css">
      
        .container{
            padding: 20px;
            margin-left: 20%;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(42, 40, 40, 0.1);
            max-width: 600px;  
            width: 700px;
            position: relative;
            justify-content: center; 
            align-items: center;     
            height: 80vh;           
    
        }
        body {
          background-image: url('https://plus.unsplash.com/premium_photo-1661936361131-c421746dcd0d?q=80&w=1918&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); /* Chemin de l'image */
          background-size: cover;                       /* L'image couvre toute la page */
          background-position: center;                  /* Centre l'image */
          background-repeat: no-repeat;                 /* Pas de répétition */
          height: 100vh;                                /* Hauteur de la page */
          margin: 0;
          padding: 0;
        }

        

      </style> 
    </head>
    <body>
    
<?php
      if(isset($_POST['admin']) && isset($_POST['mdpass'])){
          $admin = $_POST['admin'];
          $mpass = $_POST['mdpass'];
            if($admin == 'maty.bigue' && $mpass =="bigs_b"){
               header('Location: listes.php');
            }else{
                echo 'Erreur de connexion';
            }
      }
    ?>
        <h1><center>CONNEXION</center></h1>

      <div class="container">
          <form method="POST" >
              <center><label for="">Veuillez entrer votre login</label></center><br>
              <center><input type="text" name="admin"/></center><br><br>
              <center><label for="">Veuillez entrer votre mot de passe</label></center><br>
              <center><input type="password" name="mdpass"/></center><br><br>
              <center><input type="submit" value="OK"/></center>
          </form>    
      </div>


    </body>
</html>