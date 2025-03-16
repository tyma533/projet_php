<?php

    $host = "localhost";
    $user = "root";
    $passwd = "";
    $db = "projet_php-modif";

    $c = mysqli_connect($host, $user, $passwd, $db);
    $id = "";
    $nom = "";
    $prénom = "";
    $login = "";
    $passwd = "";
    $profile = "";

    $error = "";
    $success = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Vérification de l'ID de l'utilisateur
        if (!isset($_GET["id"])) {
            header("Location: /projet_mof_php/connect.php");
            exit;
        }
        $id = $_GET["id"];

        // Récupération des informations de l'utilisateur
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = mysqli_query($c, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            header("Location: /projet_mof_php/liste.php");
            exit;
        }

        $nom = $row["nom"];
        $prénom = $row["prénom"];
        $login = $row["login"];
        $passwd = $row["passwd"];
        $profile = $row["profile"];
    } else {
        // Modification des informations utilisateur
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $prénom = $_POST["prénom"];
        $login = $_POST["login"];
        $passwd = password_hash($_POST["passwd"], PASSWORD_DEFAULT); //Hashage du mot de passe 

        // Vérification de l'image uploadée
        if (!empty($_FILES["profile"]["name"])) {
            $target_directory = "photo_project/";
            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true);
            }

            // Création d'un nom unique pour l'image
            $file_ext = pathinfo($_FILES["profile"]["name"], PATHINFO_EXTENSION);
            $new_image_name = "profile_" . time() . "." . $file_ext;
            $target_path = $target_directory . $new_image_name;

            // Déplacement du fichier uploadé
            if (move_uploaded_file($_FILES["profile"]["tmp_name"], $target_path)) {
                $profile = $new_image_name;
            } else {
                $error = "Erreur lors du téléchargement du fichier.";
            }
        }

        // Mise à jour dans la base de données
        if (empty($error)) {
            $sql = "UPDATE users SET nom='$nom', prénom='$prénom', login='$login', passwd='$passwd', profile='$profile' WHERE id=$id";
            $result = mysqli_query($c, $sql);

            if ($result) {
                $success = "Utilisateur modifié avec succès";
                //Redirction vers la page des utilisateurs
                header("Location: /projet_mof_php/liste1.php");
                exit;
            } else {
                $error = "Erreur lors de la modification de l'utilisateur: " . mysqli_error($c);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: rgb(224, 229, 250);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier un utilisateur</h1>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <strong><?php echo $error; ?></strong>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>

            <div class="mb-3">
                <label for="prénom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prénom" name="prénom" value="<?php echo $prénom; ?>" required>
            </div>

            <div class="mb-3">
                <label for="login" class="form-label">Login</label>
                <input type="text" class="form-control" id="login" name="login" value="<?php echo $login; ?>" required>
            </div>

            <div class="mb-3">
                <label for="passwd" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="passwd" name="passwd" required>
            </div>

            <div class="mb-3">
                <label for="profile" class="form-label">Photo de profil</label>
                <input type="file" class="form-control" id="profile" name="profile" accept="image/*">
                <?php if (!empty($profile)): ?>
                    <img src="photo_project/<?php echo $profile; ?>" alt="Profile" class="img-thumbnail mt-2" width="100">
                <?php endif; ?>
            </div>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success">
                    <strong><?php echo $success; ?></strong>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Modifier</button>
            <a class="btn btn-secondary" href="/projet_mof_php/liste1.php">Annuler</a>
        </form>
    </div>
</body>
</html>
