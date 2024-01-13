<?php
 require 'config/conexdb.php';

// faire en sorte que le bouton "Modifier le message" soit cliqué
if(isset($_POST['submit'])){
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'],FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // met is_feactured à 0, s'il n'a pas été coché

    $is_featured = $is_featured == 1 ?: 0;

    // vérifier et valider les valeurs d'entrée

    if(!$title){
        $_SESSION['edit-post'] = "Impossible de mettre à jour le message. Données de formulaire invalides dans la page Modifier l'article ..!";
    }elseif(!$category_id){
        $_SESSION['edit-post'] = "Impossible de mettre à jour le message. Données de formulaire invalides dans la page Modifier l'article ..!";
    }elseif(!$body){
        $_SESSION['edit-post'] = "Impossible de mettre à jour le message. Données de formulaire invalides dans la page Modifier l'article ..!";
    }else{

        // supprimer la vignette existante
        if($thumbnail['name']){
            $previous_thumbnail_path = '../data/' . $previous_thumbnail_name;
            if($previous_thumbnail_path){
                unlink($previous_thumbnail_path);
            }

            //travailler sur une nouvelle vignette
            $time = time();

            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../data/' . $thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png', 'jpg', 'jpeg', 'webp','php'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if(in_array($extension, $allowed_files)){

                // assurez-vous que l'avatar n'est pas trop grand
                if($thumbnail['size'] < 50000000){

                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                }else{
                    $_SESSION['edit-post'] = "Impossible de mettre à jour le message. La taille de la vignette est trop grande. Ajouter une vignette de moins de 50MB ..!";
                }

            }else{
                $_SESSION['edit-post'] = "Ne peut pas mettre à jour l'article. La vignette doit être au format PNG, JPG, JPEG ou WEBP Type de fichier ..!";
            }
        }
    }

    if($_SESSION['edit-post']){

        // la redirection vers le site de gestion de la page n'est pas valide
        header('location: ' . $base_url . 'admin/');
        die();
    }else{

        // mettre is_featured de tous les messages à 0, si is_featured de ce message est à 1

        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($conn, $zero_all_is_featured_query);
        }

        // définir le nom de la vignette, si une nouvelle vignette a été téléchargée

        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title='$title', body='$body', thumbnail = '$thumbnail_to_insert', category_id=$category_id, is_featured=$is_featured WHERE id=$id LIMIT 1";
        $result = mysqli_query($conn, $query);
    }
    
    if(!mysqli_errno($conn)){
        $_SESSION['edit-post-success'] = " Le message a été mis à jour avec succès ..!";
    }
}

header('location: ' . $base_url . 'admin/');
die();

?>