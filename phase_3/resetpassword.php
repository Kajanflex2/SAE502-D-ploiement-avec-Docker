<?php 

require 'con_db/conexdb.php';

$password = $_SESSION['signin-data']['password'] ?? null;

unset($_SESSION['signin-data']);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réinitialisation du mot de passe</title>
  <link rel="stylesheet" href="<?= $base_url ?>css/style.css" />
  <link rel="stylesheet" href="<?= $base_url ?>css/signup.css" />

      <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
</head>
<body>

  <section class="form__section">

    <div class="container form__section-container">

      <h2>Réinitialiser le mot de passe</h2>

      <h2>Connexion</h2>
                <?php if(isset($_SESSION['reset-success'])) : ?>
              <div class="alert__message success">
                  <p>
                      <?= $_SESSION['reset-success'];
                       unset($_SESSION['reset-success']); ?>
                  </p>
              </div>

              <?php elseif(isset($_SESSION['reset-error'])) : ?>

              <div class="alert__message error">
                  <p>
                      <?= $_SESSION['reset-error']; unset($_SESSION['reset-error']);?>
                  </p>
              </div>

              <?php endif ?>

      <form action="reset_password_logic.php" method="post">

        <div class="form__control">
          <input type="password" placeholder="Ancien mot de passe" name="old_password" required>
        </div>

        <div class="form__control">
          <input type="password" placeholder="Nouveau mot de passe" name="new_password" required>
        </div>

        <div class="form__control">
          <input type="password" placeholder="Confirmer nouveau mot de passe" name="confirm_new_password" required>
        </div>

        <button type="submit" class="btn" name="submit">Réinitialiser</button>

      </form>

    </div>

  </section>

</body>
</html>
