<?php

require 'con_db/conexdb.php';

if (isset($_GET['token'])){

  $token = $_GET['token'];

  $verify_query = "SELECT verification_token, email_verified FROM users  WHERE verification_token= '$token' LIMIT 1";
  
  $verify_query_exec = mysqli_query($conn, $verify_query);

  if(mysqli_num_rows($verify_query_exec) > 0 ) {
    # code...
    $row = mysqli_fetch_array($verify_query_exec);

   // echo $row['verification_token'];

    if ($row['email_verified'] == "0") {

      $clicked_token = $row['verification_token'];
      $update_query = "UPDATE users SET email_verified='1' WHERE verification_token='$clicked_token' LIMIT 1";
      $update_query_run = mysqli_query($conn,$update_query);

      if ($update_query_run) {

        # code...
        $_SESSION['signup-success'] = "Votre e-mail a été vérifié avec succès ..!";
        header('location: ' . $base_url . 'signin.php');
        exit(0);

      }else {

        # code...
        $_SESSION['signin'] = "La vérification a échoué ..!";
        header('location: ' . $base_url . 'signin.php');
        exit(0);
      }
    } else {
      
      # code...
      $_SESSION['signin'] = "Votre e-mail a déjà été vérifié ..!";
      header('location: ' . $base_url . 'signin.php');
      exit(0);
    
    }

  }else {

      $_SESSION['signin'] = "Aucune donnée trouvée ..!";
      header('location: ' . $base_url . 'signin.php');

    }
  # code...
 } else {

    $_SESSION['signin'] = "Vous n'êtes pas autorisé :(";
    header('location: ' . $base_url . 'signin.php');
  
    } 

?>