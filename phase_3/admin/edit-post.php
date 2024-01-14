<?php
include 'header/header.php';

// récupérer la catégorie dans la base de données
$category_query = "SELECT * FROM categories";
$categories = mysqli_query($conn, $category_query);


// récupérer les données du courrier dans la base de données

if(isset($_GET['id'])){
  $id = filter_var($_GET['id'],FILTER_SANITIZE_NUMBER_INT);
  $query = "SELECT * FROM posts WHERE id=$id";
  $result = mysqli_query($conn, $query);
  $post = mysqli_fetch_assoc($result);
}else{
  header('location: ' . ROOT_URL . '/admin');
  die();
}
?>

   <!DOCTYPE html>
   <html lang="en">
   <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>epost</title>
   </head>
   <body>

 
     <section class="form__section">
      <div class="container form__section-container">
        <h2>Edit Posts</h2>

        <form action="<?= $base_url ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
          <input type="hidden" name="id" value="<?= $post['id'] ?>">
          <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">

          <input type="text" name="title" placeholder="Title" value="<?= $post['title'] ?>">
          <select name="category">
            <?php while($category = mysqli_fetch_assoc($categories)) : ?>
            <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
            <?php endwhile ?>
        
          </select>
          <textarea rows="10" placeholder="Body" name="body"><?= $post['body'] ?></textarea>

          <div class="form__control inline">
            <input type="checkbox" name="is_featured" id="is_feactured" value="1" checked>
            <label for="is_feactured">À la une</label>
          </div>

          <div class="form__control">
            <label for="thumbnail">Mise à jour de la vignette</label>
            <input type="file" id="thumbnail" name="thumbnail">
          </div>
          
          <button type="submit" class="btn" name="submit">Mise à jour des postes</button>
          
        </form>
      </div>
    </section>

   </body>
   </html>

<?php
  include __DIR__. '/../hefo/footer.php';
?>
