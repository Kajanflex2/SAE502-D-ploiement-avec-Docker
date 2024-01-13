<?php

 require 'config/conexdb.php';

if(isset($_GET['id'])){


    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);


    if(mysqli_num_rows($result) ==1 ){
        $avatar_name = $user['avatar'];
        $avatar_path = '../data/' . $avatar_name;


        if($avatar_path){
            unlink($avatar_path);
        }
    }


    $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id=$id";

    $thumbnail_result = mysqli_query($conn, $thumbnails_query);

    if(mysqli_num_rows($thumbnail_result) > 0){
        while($thumbnail = mysqli_fetch_assoc($thumbnail_result)){
            $thumbnail_path = '../data/' . $thumbnail['thumbnail'];

            if($thumbnail_path){
                unlink($thumbnail_path);
            }
        }
    }

    $delete_user_query = "DELETE FROM users WHERE id=$id";
    $delete_user_result = mysqli_query($conn, $delete_user_query);

    if(mysqli_errno($conn)){
        $_SESSION['delete-user'] = "Impossible '{$user['firstname']}' '{$user['lastname']}'. Réessayez à nouveau ..!";
    }else{
        $_SESSION['delete-user-success'] = "Supprimé '{$user['firstname']}' '{$user['lastname']}' Utilisateur avec succès ..!";
    }
    
}

header('location: ' . $base_url . 'admin/manage-user.php');
die();

?>