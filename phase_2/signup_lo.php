<?php

require 'con_db/conexdb.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

#require "PHPMailer/PHPMailerAutoload.php";

function sendmail_verify($username,$email,$verification_token) {

    //Create an instance; passing `true` enables exceptions

    $mail = new PHPMailer(true);

    //mail->SMTPDebug = 2;
    try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output

    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'tenser.manerso@gmail.com';                     //SMTP username
    $mail->Password   = 'vaxeicwfyntoxokp';                               //SMTP password
    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you   have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through

    //Recipients
    $mail->setFrom('tenser.manerso@gmail.com', $username);
    $mail->addAddress($email);     //Add a recipient

    /* $email_format = "<h2>Récamment vous avez enregistré un compte sur notre site web !</h2>
    <h5>Confirmez votre e-mail en cliquant sur le lien ci-dessous :</h5>
    <a href='http://localhost:8080/verify.php?token=$verification_token'>Cliquez ici</a>";*/
    
    $email_format = "
        <html>
        <head>
        <style>
            body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
            }
            .email-container {
            background-color: #ffffff;
            padding: 20px;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
            }
            a.confirmation-link {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            }
            a.confirmation-link:hover {
            background-color: #45a049;
            }
        </style>
        </head>
        <body>
        <div class='email-container'>
            <h2>Récemment, vous avez enregistré un compte sur notre site web !</h2>
            <h5>Confirmez votre e-mail en cliquant sur le lien ci-dessous :</h5>
            <a href='http://localhost:8080/verify.php?token=$verification_token' class='confirmation-link'>Cliquez ici</a>
        </div>
        </body>
        </html>";

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email verification';
    $mail->Body    = $email_format;

    $mail->send();
    //echo 'Message has been sent';
        
    } catch (Exception $e) {

        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }

} 

if(isset($_POST['submit'])){
    
  $firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
  $createpassword = filter_var($_POST['createpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $confirmpassword = filter_var($_POST['confirmpassword'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $verification_token = md5(rand());

  $avatar =$_FILES['avatar'];

   //sendmail_verify("$username","$email","$verification_token");
   // echo " sent or not ?";
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
    $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin, verification_token) VALUES ('$firstname', '$lastname', '$username', '$email', '$hashed_password', '$avatar_name', 0 , '$verification_token')";

    $insert_user_result = mysqli_query($conn, $insert_user_query);

    if(!mysqli_errno($conn)){

        $_SESSION['signup-success'] = "Enregistrement réussi, Vérifier votre boîte de réception ..!";

        sendmail_verify("$username","$email","$verification_token");

        header('location: ' . $base_url . 'signin.php');

        die();
    }
}

} else{

 header(('location: ' .$base_url . 'signup.php'));

  die();
}

?>