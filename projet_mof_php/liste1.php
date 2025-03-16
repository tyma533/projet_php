<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <style>
         /*Mis en forme de la page*/

        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 20px;
        }
        .add {
            background-color: rgb(212, 3, 3); /* Rouge */
            color: #fff; /* Texte blanc */
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.1s;
            display: inline-block;
            text-decoration: none;
        }
        
        table {
            margin-top: 5%;
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgb(46, 18, 78);
            color: #fff;
        }
        .supp {
            background-color: rgb(56, 2, 3);
            border-radius: 10px;
            padding: 10px 10px;
            color: white;
            text-decoration: none;
        }
        .mod {
            background-color: rgb(56, 76, 32);
            padding: 10px 10px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
        }
        .voir {
            background-color: rgb(21, 29, 78);
            padding: 10px 10px;
            border-radius: 10px;
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><center>Liste des utilisateurs</center></h1>

        <a class="add" href="create.php">Ajouter un utilisateur</a>
        <br>
        <!-- Tableau affichant les utilisateurs -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Login</th>
                    <th>Profile</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 // Connexion à la base de données
                    $host = "localhost";
                    $user = "root";
                    $passwd = "";
                    $db = "projet_php-modif";

                    $c = mysqli_connect($host, $user, $passwd, $db);

                    if (!$c) {
                        die("Connexion échouée: " . mysqli_connect_error());
                    } 

                  // Récupération des utilisateurs dans la base de données
                    $sql = "SELECT * FROM users";
                    $result = mysqli_query($c, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Affichage des utilisateurs dans le tableau
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>"; 
                            echo "<td>".$row['nom']."</td>";
                            echo "<td>".$row['prénom']."</td>";
                            echo "<td>".$row['login']."</td>";
                            // Lien pour afficher la photo de profil
                            echo "<td><a href='photo_project/".$row['profile']."' target='_blank'>Profil</a></td>";
                            echo "<td>";
                             // Boutons d'actions (voir, modifier, supprimer)
                            echo "<a class='voir' href='/projet_mof_php/liste.php?id={$row['id']}'>👁️</a> ";
                            echo "<a class='mod' href='/projet_mof_php/connect.php?id={$row['id']}'>✏️</a> ";
                            echo "<a class='supp' href='/projet_mof_php/delete.php?id={$row['id']}'>🗑️</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Aucun résultat trouvé</td></tr>";
                    }
                    // Fermeture de la connexion
                    mysqli_close($c);
                ?> 
            </tbody>
        </table>
    </div>
</body>
</html>
