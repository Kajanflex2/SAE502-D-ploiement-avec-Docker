<?php
 require 'config/conexdb.php';

if(isset($_POST['submit'])){

    // Obtenir les données d'un formulaire
    $title = filter_var($_POST['title'],FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_var($_POST['description'],FILTER_SANITIZE_SPECIAL_CHARS);

    if(!$title){

        $_SESSION['add-category'] = "Ajouter le titre de l'article";
    }elseif(!$description){

        $_SESSION['add-category'] = "Veuillez ajouter la description du poste";
        
    }

    // Rediriger vers le formulaire de catégorie avec les données de ce problème

    if(isset($_SESSION['add-category'])){
        $_SESSION['add-category-data'] = $_POST;
        
        header('location: ' . $base_url . 'admin/add-category.php');

        die();
        
    }else{

        // insérer la catégorie dans la base de données
        $query = "INSERT INTO categories (title, description) VALUES ('$title', '$description')";

        $result = mysqli_query($conn, $query);

        if(mysqli_errno($conn)){

            $_SESSION['add-category'] = "Impossible d'ajouter des données de catégorie";

            header('location: ' . $base_url . 'admin/add-category.php');

            die();
        }else{

            $_SESSION['add-category-success'] = "Catégorie $title Ajouté Succès ..!!";

            header('location: ' . $base_url . 'admin/manage-category.php');
            
            die();
        }
    }

}

?>