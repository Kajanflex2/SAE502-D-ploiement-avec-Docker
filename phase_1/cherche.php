<?php

require 'hefo/header.php';

if(isset($_GET['search']) && isset($_GET['submit'])){
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query ="SELECT * FROM posts WHERE title LIKE '%$search%' ORDER BY date_time DESC";
    $posts = mysqli_query($conn, $query);

}else{
    header('location: ' . $base_url . 'blog.php');
    die();
}

?>

<?php if(mysqli_num_rows($posts) > 0) : ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>fr</title>
</head>
<body>

  <section class="posts section__extra-margin">
    
      <div class="container post__container">

          <?php while($post = mysqli_fetch_assoc($posts)) : ?>

          <article class="post">

              <div class="post__thumnail">
                  <img src="./data/<?= $post['thumbnail'] ?>" alt="blog">
              </div>
              
              <div class="post__info">

              <?php
              $category_id = $post['category_id'];
              $category_query ="SELECT * FROM categories WHERE id=$category_id";
              $category_result = mysqli_query($conn, $category_query);
              $category = mysqli_fetch_assoc($category_result);
              ?>
                  <a href="<?= $base_url ?>cat.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
                  <h3 class="post__title">
                      <a href="<?= $base_url ?>post.php?id=<?= $post['id'] ?>">
                          <?= $post['title'] ?>
                      </a>
                  </h3>

                  <p class="post__body">
                      <?= substr($post['body'],0 , 150) ?> 
                      <br/>
                      <a href="<?= $base_url ?>post.php?id=<?= $post['id'] ?>">
                          Lire plus...
                      </a>
                  </p>

                  <div class="post__author">
                      <?php
                      $author_id = $post['author_id'];
                      $author_query = "SELECT * FROM users WHERE id=$author_id";
                      $author_result = mysqli_query($conn, $author_query);
                      $author = mysqli_fetch_assoc($author_result);

                      ?>

                      <div class="post__author-avatar">
                          <img src="./data/<?= $author['avatar'] ?>" alt="avatar">
                      </div>

                      <div class="post__author-info">

                          <h5>Post By : <?= "{$author['firstname']} {$author['lastname']}" ?></h5>

                          <small>
                              <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                          </small>

                      </div>

                  </div>

              </div>

          </article>

          <?php endwhile ?>

      </div>
  </section>

  <?php else : ?>

    <div class="alert__message error lg section__extra-margin">
        <p>
          Oups... ! Aucun publication n'a été trouvé pour cette recherche... !
        </p>
    </div>

    <?php endif ?>

  <section class="category__buttons">
    
      <div class="container category__buttons-container">

      <?php 
          $all_categories_query = "SELECT * FROM categories";
          $all_categories = mysqli_query($conn, $all_categories_query);
      ?>

      <?php while ($category = mysqli_fetch_assoc($all_categories)) : ?>
          <a href="<?= $base_url ?>cat.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
      <?php endwhile ?>
      </div>
  </section>

</body>
</html>

<?php
    
    include 'hefo/footer.php';
    
?>