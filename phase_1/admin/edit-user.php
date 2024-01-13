<?php
include 'header/header.php';


if(isset($_GET['id'])){
  $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM users WHERE id=$id";
  $result = mysqli_query($conn, $query);
  $user = mysqli_fetch_assoc($result);
}else{
  header('location: ' . $base_url
  . 'admin/manage-users.php');
  die();
}
?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>euser</title>
  </head>
  <body>
    

    <section class="form__section">
      <div class="container form__section-container">
        <h2>Modifier l'utilisateur</h2>

   
       <form action="<?= $base_url ?>admin/edit-user-logic.php" method="POST">
          <input type="hidden" name="id" value="<?= $user['id'] ?>" />
          <input type="text" placeholder="Saisissez votre prénom" name="firstname" value="<?= $user['firstname'] ?>" />
          <input type="text" placeholder="Saisissez votre nom de famille" name="lastname" value="<?= $user['lastname'] ?>" />
         
          <select name="userrole">
            <option value="0">Interne</option>
            <option value="1">Admin</option>
          </select>

         
          <button type="submit" class="btn" name="submit">Mise à jour de l'utilisateur</button>
          
        </form>
      </div>
    </section>

  </body>
  </html>

 
    
<?php
  include __DIR__. '/../hefo/footer.php';
?>