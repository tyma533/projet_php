<?php
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $db = "projet_php-modif";

      // Connexion à la base de données 
    $c = mysqli_connect($host, $user, $passwd, $db);

    // Initialisation des variables
    $id = "";
    $nom = "";
    $prénom = "";
    $login = "";
    $passwd = "";
    $profile = "";

    $error = "";
    $success = "";

     // Vérification si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST["nom"];
        $prénom = $_POST["prénom"];
        $login = $_POST["login"];
        $passwd = hash('sha256', $_POST["passwd"]);
        $profile = $_FILES["profile"]["name"];

        do {
            // Vérification des champs obligatoires
            if (empty($nom)) {
                $error = "Le nom est obligatoire";
                break;
            }
            if (empty($prénom)) {
                $error = "Le prénom est obligatoire";
                break;
            }
            if (empty($login)) {
                $error = "Le login est obligatoire";
                break;
            }
            if (empty($_POST["passwd"])) {
                $error = "Le mot de passe est obligatoire";
                break;
            }
            if (empty($profile)) {
                $error = "Le profil est obligatoire";
                break;
            }

            // Vérifier et créer le dossier si inexistant
            $target_directory = "photo_project/";
            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true);
            }

            // Création d'un nom unique pour le fichier
            $file_basename = pathinfo($_FILES["profile"]["name"], PATHINFO_FILENAME);
            $file_ext = pathinfo($_FILES["profile"]["name"], PATHINFO_EXTENSION);
            $new_image_name = $file_basename . "_" . date("Y.m.d-H.i.s") . "." . $file_ext;
            $target_path = $target_directory . $new_image_name;

            // Ajouter un nouvel utilisateur dans la base de données
            $sql = "INSERT INTO users (nom, prénom, login, passwd, profile) 
                    VALUES ('$nom', '$prénom', '$login', '$passwd', '$new_image_name')";
            $result = mysqli_query($c, $sql);

            if (!$result) {
                $error = "Erreur lors de l'ajout de l'utilisateur: " . mysqli_error($c);
                break;
            }

            // Vérifier que le fichier a bien été téléchargé et le déplacer
            if (!empty($_FILES["profile"]["tmp_name"]) && move_uploaded_file($_FILES["profile"]["tmp_name"], $target_path)) {
                $image_link = "<a href='$target_path' target='_blank'>Voir l'image</a>";
                $success = "L'utilisateur a été créé avec succès. $image_link";
            } else {
                $error = "Erreur lors du téléchargement du fichier.";
                break;
            }

        } while (false);
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Créer un utilisateur</h1>


        <?php
         // Affichage des messages d'erreur ou de succès
        if (!empty($error)) {
            echo "<div class=\"alert alert-danger\" role=\"alert\">
            <strong>$error </strong>
            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
            </div>";
        }
        ?>

          <!-- Formulaire d'ajout d'utilisateur -->
        <form method="post" enctype="multipart/form-data">
            <div class="row mb-3">
                <label for="nom" class="col-sm-3 col-form-label">Nom</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nom" name="nom" >
                </div>
            </div>
            <div class="row mb-3">
                <label for="prénom" class="col-sm-3 col-form-label">Prénom</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="prénom" name="prénom" >
                </div>
            </div>
            <div class="row mb-3">
                <label for="login" class="col-sm-3 col-form-label">Login</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="login" name="login" autocomplete="off" >
                </div>
            </div>
            <div class="row mb-3">
                <label for="passwd" class="col-sm-3 col-form-label">Mot de passe</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" id="passwd" name="passwd" autocomplete="off" >
                </div>
            </div>
            <div class="row mb-3">
                <label for="profile" class="col-sm-3 col-form-label">Profile</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="profile" name="profile" accept="photo_project/*" required>
                </div>
            </div>

            <?php
             // Affichage du message de succès
                if (!empty($success)) {
                    echo "
                    <div class=\"row mb-3\">
                        <div class=\"offset-sm-3 col-sm-6\">
                            <div class=\"alert alert-success\" role=\"alert\">
                                <strong>$success </strong>
                                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                            </div>
                        </div>
                    </div>";
                }
            ?>
             <a href="liste1.php">RETOUR</a>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-secondary" href="/projet_mof_php/listes.php" role="button">Annuler</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
