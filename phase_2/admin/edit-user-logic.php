<?php
 require 'config/conexdb.php';
if(isset($_POST['submit'])){

    // submit form data
    $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'],FILTER_SANITIZE_NUMBER_INT);

    
    if(!$firstname || !$lastname){
        $_SESSION['edit-user'] = "Entrées de formulaire non valides sur la page Modifier l'utilisateur";
    }else{

        $query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', is_admin = $is_admin WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn, $query);

        if(mysqli_errno($conn)){
            $_SESSION['edit-user'] = "Échec de la mise à jour de l'utilisateur. Réessayez ..!!";

        }else{
            $_SESSION['edit-user-success'] = "Utilisateur $firstname $lastname  Mise à jour effectuée avec succès ..!!";
        }
    }
}

header('location: ' . $base_url . 'admin/manage-user.php');
die();

?>