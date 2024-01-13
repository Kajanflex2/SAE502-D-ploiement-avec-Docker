<?php

require 'config/conexdb.php';

if(isset($_POST['submit'])){
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


    if(!$title || !$description){
        $_SESSION['edit-category'] = "Formulaire invalide sur la page de la catégorie Edite ..!";
    }else{
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn, $query);

        if(mysqli_errno($conn)){
            $_SESSION['edit-category'] = "Impossible de mettre à jour la catégorie ..!";
        }else{
            $_SESSION['edit-category-success'] = "La catégorie $title a été mise à jour avec succès ..!";
        }
    }
}

header('location: ' . $base_url . 'admin/manage-category.php');
die();

?>