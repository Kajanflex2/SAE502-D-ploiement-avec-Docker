<!-- Démarrage de la session sur la page d'accueil-->
<?php

require 'con_db/conexdb.php';

$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <link rel="stylesheet" href="<?= $base_url ?>css/style.css" />
  <link rel="stylesheet" href="<?= $base_url ?>css/signup.css" />

      <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>

</head>
<body>

  <section class="form__section">
          <div class="container form__section-container">
              <h2>Connexion</h2>
                <?php if(isset($_SESSION['signup-success'])) : ?>
              <div class="alert__message success">
                  <p>
                      <?= $_SESSION['signup-success'];
                       unset($_SESSION['signup-success']); ?>
                  </p>
              </div>

              <?php elseif(isset($_SESSION['signin'])) : ?>

              <div class="alert__message error">
                  <p>
                      <?= $_SESSION['signin']; unset($_SESSION['signin']);?>
                  </p>
              </div>

              <?php endif ?>

              <form action=" <?= $base_url ?>singin_lo.php" method="POST">
                  <input type="text" placeholder="Adresse e-mail" name="username_email" >
                  <input type="password" placeholder="Saisissez votre mot de passe" name="password" >
                  <button type="submit" class="btn" name="submit"> Connexion</button>
                  <small>Vous n'avez pas de compte ? <a href="signup.php">Créer un compte</a></small>
              </form>

          </div>
      </section>
</body>
</html>
