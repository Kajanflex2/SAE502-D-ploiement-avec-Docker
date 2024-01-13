<?php

  require 'con_db/conexdb.php';

if(isset($_POST['submit'])){
    
  $firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
  $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  $avatar =$_FILES['avatar'];


  // validation les données reçu
  if(!$firstname){
      $_SESSION['signup']="Veuillez saisir votre prénom";
  }elseif(!$lastname){
      $_SESSION['signup']="Veuillez saisir votre nom de famille";
  }elseif(!$username){
      $_SESSION['signup']="Veuillez saisir votre nom d'utilisateur";
  }elseif(!$email){
      $_SESSION['signup']="Veuillez saisir votre adresse e-mail valide";
  }elseif(strlen($createpassword) < 8 || strlen($confirmpassword) <8){
      $_SESSION['signup']="Le mot de passe doit comporter 8 caractères";
  }elseif(!$avatar['name']){
      $_SESSION['signup']="Veuillez sélectionner l'image de votre avatar";
  }else{

      // vérifier si le mot de passe ne correspond pas

      if($createpassword !== $confirmpassword){
          $_SESSION['signup'] = "Le mot de passe ne correspond pas. Réessayez ..!!";
          
      }else{

          //hachage 
          $hashed_password = password_hash($createpassword,  PASSWORD_DEFAULT);
  

          // vérifier si le nom d'utilisateur ou l'adresse mail existe déjà dans la base de données.

          $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email'";

          $user_check_result = mysqli_query($conn, $user_check_query);

          if(mysqli_num_rows($user_check_result) > 0){

              $_SESSION['signup'] ="Le nom d'utilisateur ou l'e-mail existe déjà ..!";

          }else{


              $time = time(); //  rendre chaque nom d'image unique en utilisant l'horloge actuel
              $avatar_name = $time . $avatar['name'];

              $avatar_tmp_name = $avatar['tmp_name'];

              $avatar_destination_path = 'data/' . $avatar_name;

              // s'assurer que le fichier est une image
              $allowed_files = ['png', 'jpg', 'jpeg','php'];

              $extention = explode('.', $avatar_name);

              $extention = end($extention);

              if(in_array($extention, $allowed_files)){

                  // s'assurer que l'image n'est pas trop grande 50MB

                  if($avatar['size'] < 50000000){

 
                      move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                  }else{
                      $_SESSION['signup'] = "Taille du fichier trop importante. Choisissez un fichier de moins de 50MB ..!";
                  }
              }else{
                  $_SESSION['signup'] = "Le fichier doit être au format PNG, JPG ou JPEG";
              }
          }
      }
  }

  // Vérifier la redirection vers la page d'inscription, il y a eu une erreur.
  if(isset($_SESSION['signup'])){

      // pass form data back to sign up page
      $_SESSION['signup-data'] = $_POST;

      header('location: ' . $base_url . 'signup.php');

      die();

  }else{
    
      // insérer un nouvel utilisateur dans le tableau des utilisateurs
      $insert_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin=0";
      $insert_user_result = mysqli_query($conn, $insert_user_query);
      if(!mysqli_errno($conn)){

          $_SESSION['signup-success'] = "Enregistrement réussi. Veuillez vous connecter ..!";
          header('location: ' . $base_url . 'signin.php');
          die();
      }
  }

}else{

  header(('location: ' .$base_url . 'signup.php'));

  die();
}

?>