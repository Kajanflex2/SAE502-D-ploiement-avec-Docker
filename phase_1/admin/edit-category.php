<?php
include 'header/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch data form db
    $query = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1){
        $category = mysqli_fetch_assoc($result);
    }

}else{
    header('location: ' . $base_url
    . 'admin/manage-category');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>editcat</title>
</head>
<body>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Modifier la catégorie</h2>

            <form action="<?= $base_url ?>admin/edit-category-logic.php" method="POST">
                <input type="hidden" value="<?= $category['id'] ?>" name="id" />
                <input type="text" placeholder="Titre" value="<?= $category['title'] ?>" name="title" />

                <textarea rows="4" placeholder="Description" name="description"><?= $category['description'] ?></textarea>


                <button type="submit" class="btn" name="submit">Mise à jour de la catégorie</button>

            </form>
        </div>
    </section>
        
</body>
</html>

<?php
  include __DIR__. '/../hefo/footer.php';
?>