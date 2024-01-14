
<?php 

require __DIR__ . '/../con_db/conexdb.php';


?> 

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>SAE502 PROJET</title>

    <link rel="stylesheet" href="<?= $base_url ?>css/style.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/about.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/blog.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/signup.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/post.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/category-post.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/manage-category.css" />

    <!-- icon cloud cdn -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
</head>

<body>

  <?php

    if(isset($_SESSION['user-id'])){
        $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT avatar FROM users WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $avatar = mysqli_fetch_assoc($result);
    }
  ?>


      <!-- Nav Bar-->
      <nav>
        <div class="container nav__container">
            <a href="<?= $base_url ?>" class="nav__logo">SAE502 PROJET</a>
            <ul class="nav__items">
                <li><a href="<?= $base_url ?>">Accueil</a></li>
                <li><a href="<?= $base_url ?>blog.php">Publication</a></li>
                <li><a href="<?= $base_url ?>about.php">À propos</a></li>
                <li><a href="<?= $base_url ?>contact.php">Contact</a></li>
                <?php if(isset($_SESSION['user-id'])) : ?>
                <li class="nav__profile">
                    <div class="avatar">
                        <img src="<?= $base_url . 'images/' . $avatar['avatar'] ?>" alt="profile" />
                    </div>

                    <ul>
                        <li><a href="<?= $base_url ?>admin/index.php">Index</i></a></li>
                        <li><a href="<?= $base_url ?>resetpassword.php">Réinitialiser mot de passe</i></a></li>
                        <li><a href="<?= $base_url ?>logout.php">Déconnexion</i></a></li>

                    </ul>
                </li>
                <?php else : ?>
                <li><a href="<?= $base_url ?>signin.php">connexion</a></li>
                <?php endif ?>
            </ul>

            <!-- mobile view -->
            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>

        </div>
    </nav>
</body>
</html>