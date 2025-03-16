<?php
// Vérifie si un identifiant est fourni dans l'URL
    if(isset($_GET["id"])){

        $id = $_GET["id"];
        $host = "localhost";
        $user="root";
        $passwd="";
        $db="projet_php-modif";

        $c=mysqli_connect($host, $user, $passwd, $db);

        $sql = "DELETE FROM users WHERE id = $id";
        $result = mysqli_query($c, $sql);
    }
    // Redirection vers la liste des utilisateurs après suppression
    header("Location: /projet_mof_php/liste1.php");
    exit;

?> 