<?php
 require 'config/conexdb.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // supprimer la vignette du message
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);

    // s'assurer qu'il n'y a qu'un seul enregistrement
    if(mysqli_num_rows($result) == 1){
        $post = mysqli_fetch_assoc($result);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = '../Data/' . $thumbnail_name;

        if($thumbnail_path){
            unlink($thumbnail_path);

            $delete_post_query = "DELETE FROM posts WHERE id=$id LIMIT 1";
            $delete_post_result = mysqli_query($conn, $delete_post_query);

            if(!mysqli_errno($conn)){
                $_SESSION['delete-post-success'] = "Publication a été supprimé avec succès..!";
            }
        }
    }

}

header('location: ' . $base_url . 'admin/');
die();

?>