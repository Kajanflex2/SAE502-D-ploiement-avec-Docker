<?php 
 require 'config/conexdb.php';


if(isset($_GET['id'])){
    $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);

    $update_query = "UPDATE posts SET category_id=20 WHERE category_id=$id";
    $update_result = mysqli_query($conn, $update_query);

    if(!mysqli_errno($conn)){
        

    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($conn, $query);
    $_SESSION['delete-category-success'] = "Deleted Category Successfully..!";

    }

}
header('location: ' . $base_url . 'admin/manage-category.php');
die();

?>