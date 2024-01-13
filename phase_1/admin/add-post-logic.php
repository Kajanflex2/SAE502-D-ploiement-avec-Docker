<?php
 require 'config/conexdb.php';

if(isset($_POST['submit'])){

    $author_id = $_SESSION['user-id'];

    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];


    $is_featured = $is_featured == 1 ?: 0;


    if(!$title){
        $_SESSION['add-post'] = "Créer le titre de l'article";

    }elseif(!$category_id){
        $_SESSION['add-post'] = "Sélectionnez la catégorie de l'article";

    }elseif(!$body){
        $_SESSION['add-post'] = "Ajouter le contenu du corps de l'article";
        
    }elseif(!$thumbnail['name']){
        $_SESSION['add-post'] = "Veuillez choisir la vignette de l'article";
    }else{


        $time = time(); 
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../Data/' . $thumbnail_name;


        $allowed_files = ['png', 'jpg', 'jpeg', 'webp', 'pdf','php'];

        $extension = explode('.', $thumbnail_name);

        $extension = end($extension);

        if(in_array($extension, $allowed_files)){

            if($thumbnail['size'] < 100_000_000){
    

                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);

            }else{

                $_SESSION['add-post'] = " Taille du fichier trop importante. Elle doit être inférieure à 100MB ";
            }
        }else{

            $_SESSION['add-post'] =" Le fichier doit être au format PNG, JPG, JPEG ou WEBP. ";
        }
    }

    // en cas d'erreur dans la section d'ajout d'un article, retour à la page d'ajout d'un article redirigée
    if($_SESSION['add-post']){
        $_SESSION['add-post-data'] = $_POST;

        header('location: ' . $base_url . 'admin/add-post.php');
        die();
    }else{

        // mettre toutes les caractéristiques à 0
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured =0";
            $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
        }

        // insérer dans la base de données
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES('$title', '$body', '$thumbnail_name', $category_id, $author_id, $is_featured)";
        $result = mysqli_query($conn, $query);

        if(!mysqli_errno($conn)){
            $_SESSION['add-post-success'] = "Nouveau poste ajouté Succès ..!";

            header('location: ' . $base_url . 'admin/');
            die();
        }
    }

}

header('location: ' . $base_url . 'admin/add-post.php');
die();

?>