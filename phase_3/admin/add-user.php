<?php
include 'header/header.php';

$firstname = $_SESSION['add-user-data']['firstname'] ?? null;
$lastname = $_SESSION['add-user-data']['lastname'] ?? null;
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$createpassword = $_SESSION['add-user-data']['createpassword'] ?? null;
$confirmpassword = $_SESSION['add-user-data']['confirmpassword'] ?? null;

unset($_SESSION['add-user-data']);

?>

<section class="form__section">

    <div class="container form__section-container">
       
    <h2>Add User</h2>

        <?php if(isset($_SESSION['add-user'])) : ?>
        
            <div class="alert__message error">

            <p>
                <?= $_SESSION['add-user'];

                unset($_SESSION['add-user']);

                ?>

            </p>

        </div>

        <?php endif ?>

        <form action="<?= $base_url ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">

            <input type="text" placeholder="Saisissez votre prénom" name="firstname" value="<?= $firstname ?>" />

            <input type="text" placeholder="Saisissez votre nom de famille" name="lastname" value="<?= $lastname ?>" />

            <input type="text" placeholder="Entrez votre nom d'utilisateur" name="username" value="<?= $username ?>" />

            <input type="email" placeholder="Saisissez votre adresse e-mail" name="email" value="<?= $email ?>" />

            <input type="password" placeholder="Saisir le mot de passe" name="createpassword" value="<?= $createpassword ?>" />

            <input type="password" placeholder="Confirmer le mot de passe" name="confirmpassword"

                value="<?= $confirmpassword ?>" />

            <select name="userrole">

                <option value="0">Interne</option>

                <option value="1">Admin</option>

            </select>

            <div class="form__control">

                <label for="avatar">Avatar d'utilisateur</label>

                <input type="file" id="avatar" name="avatar" />
            </div>

            <button type="submit" class="btn" name="submit">Ajouter d'utilisateur</button>

        </form>
    </div>

</section>

<?php
  include __DIR__. '/../hefo/footer.php';
?>