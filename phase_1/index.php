<?php

include 'hefo/header.php';

// Récupérer les données de la base de données
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_result = mysqli_query($conn, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);

// Récupérer 9 postes dans le tableau
$query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";

$posts = mysqli_query($conn,$query);

?>

<?php if(mysqli_num_rows($featured_result) == 1) : ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>index</title>
</head>
<body>
  <!--  -->
  <section class="feactured">
      <div class="container featured__container">
          <div class="post__thumnail_feacture">
              <img src="./data/<?= $featured['thumbnail'] ?>" alt="blog">
          </div>
          <div class="post__info">

          <?php
          $category_id = $featured['category_id'];
          $category_query ="SELECT * FROM categories WHERE id=$category_id";
          $category_result = mysqli_query($conn, $category_query);
          $category = mysqli_fetch_assoc($category_result);
          ?>
              <a href="<?= $base_url ?>cat.php?id=<?= $featured['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
              <h2 class="post__title">

                  <a href="<?= $base_url ?>post.php?id=<?= $featured['id'] ?>">
                      <?= $featured['title'] ?>
                  </a>
              </h2>
              <p class="post__body">
                  <?= substr($featured['body'],0 , 450) ?> ...
              </p>
              <div class="post__author">

              <?php
              $author_id = $featured['author_id'];
              $author_query = "SELECT * FROM users WHERE id=$author_id";
              $author_result = mysqli_query($conn, $author_query);
              $author = mysqli_fetch_assoc($author_result);

              ?>
                  <div class="post__author-avatar">
                      <img src="./data/<?= $author['avatar'] ?>" alt="avatar">
                  </div>
                  <div class="post__author-info">
                      <h5>publié par : <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                      <small>
                          <?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?>
                      </small>
                  </div>
              </div>
          </div>
      </div>
  </section>

  <?php endif ?>

  <!-- Poste de fin de fonctions -->

  <section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
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

                  <!-- Poste unique Lire la suite Section -->
                  <p class="post__body">
                      <?= substr($post['body'],0 , 150) ?> 
                      <br/>
                      <a href="<?= $base_url ?>post.php?id=<?= $post['id'] ?>">

                          Lire plus ...
                          
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
                          <img src="./images/<?= $author['avatar'] ?>" alt="avatar">
                      </div>
                      <div class="post__author-info">
                          <h5>Publié par: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
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

  <!-- Fin des fonctionnalités -->

  <!-- Section de la catégorie -->
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

  <!-- Fin de la section de la catégorie -->

</body>

    <?php  include 'hefo/footer.php'; ?>
    
</html>
