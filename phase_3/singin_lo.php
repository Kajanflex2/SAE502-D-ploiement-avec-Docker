<?php 

require 'con_db/conexdb.php';

if(isset($_POST['submit'])){

    // obtenir les données d'un formulaire
    $username_email = filter_var($_POST['username_email']);

    $password = filter_var($_POST['password']);

    if(!$username_email){
        $_SESSION['signin'] = "Saisir un nom d'utilisateur ou un e-mail valide";
    }elseif(!$password){
        $_SESSION['signin'] = "Mot de passe requis";

    }else{
        
        // récupérer l'utilisateur dans la base de données
        $fetch_user_query = "SELECT * FROM users WHERE (username = '$username_email' OR email = '$username_email') AND email_verified = 1";
        $fetch_user_result = mysqli_query($conn, $fetch_user_query);

        if(mysqli_num_rows($fetch_user_result)==1){

            // convertir l'enregistrement en tableau
            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            // comparer le mot de passe avec le mot de passe de la base de données

            if(password_verify($password, $db_password)){

                // définir la session pour le contrôle

                $_SESSION['user-id'] = $user_record['id'];

                // l'utilisateur est administrateur ou non
                if($user_record['is_admin'] == 1){
                    $_SESSION['user_is_admin'] = true;
                }
                // enregistrer un utilisateur
                header('location: ' . $base_url . 'admin/');
            }else{
            $_SESSION['signin'] = "Mot de passe incorrect. Vérifiez à nouveau... !";
        }

        }else{
            $_SESSION['signin'] = "Utilisateur non trouvé ou Votre e-mail non vérifié ..!";
        }
    }
    // en cas de problème, rediriger vers la page d'inscription
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data']=$_POST;
        header('location: ' . $base_url . 'signin.php');
        die();
    }
}else{
    header('location: ' . $base_url . 'signin.php');
    die();
}

?>