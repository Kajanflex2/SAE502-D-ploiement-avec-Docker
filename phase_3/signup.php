<?php

  require 'con_db/conexdb.php';

 
  $firstname = $_SESSION['signup-data']['firstname'] ?? null;
  $lastname = $_SESSION['signup-data']['lastname'] ?? null;
  $username = $_SESSION['signup-data']['username'] ?? null;
  $email = $_SESSION['signup-data']['email'] ?? null;
  $createpassword = $_SESSION['signup-data']['createpassword'] ?? null;
  $confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null;

  
  unset($_SESSION['signup-data']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>

    <link rel="stylesheet" href="<?= $base_url ?>css/style.css" />
    <link rel="stylesheet" href="<?= $base_url ?>css/signup.css" />

    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />

</head>
<body>

  <section class="form__section">
          <div class="container form__section-container">

              <h2>Créer un compte</h2>
              <?php if(isset($_SESSION['signup'])) : ?>
              <div class="alert__message error">
                  <p>
                      <?= $_SESSION['signup'];
                          unset($_SESSION['signup']);                        
                          ?>
                  </p>
              </div>
              <?php endif ?>
              <form action="<?= $base_url ?>signup_lo.php" enctype="multipart/form-data" method="POST">
                  <input type="text" placeholder="Saisissez votre prénom" name="firstname"  />

                  <input type="text" placeholder="Saisissez votre nom de famille" name="lastname" />

                  <input type="text" placeholder="Entrez votre nom d'utilisateur" name="username" />

                  <input type="email" placeholder="Saisissez votre adresse e-mail" name="email" />

                  <input type="password" placeholder="Saisir le mot de passe" name="createpassword" />

                  <input type="password" placeholder="Confirmer le mot de passe" name="confirmpassword" />

                  <div class="form__control">
                      <label for="avatar">Avatar d'utilisateur</label>
                      <input type="file" id="avatar" name="avatar" />
                  </div>
                  <button type="submit" class="btn" name="submit">Créer un compte</button>
                  <small>Vous avez déjà un compte ?<a href="signin.php"> Connexion</a></small>
              </form>
          </div>
    </section>
  
</body>
</html>

