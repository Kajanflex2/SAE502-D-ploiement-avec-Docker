<?php

include 'hefo/header.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM posts WHERE category_id=$id ORDER BY date_time DESC";

    $posts = mysqli_query($conn, $query);

}else{

    header('location: ' . $base_url . 'blog.php');

    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>cat</title>
</head>
<body>

  <header class="category__title">

      <h2>
              <?php
              $category_id = $id;
              $category_query ="SELECT * FROM categories WHERE id=$id";
              $category_result = mysqli_query($conn, $category_query);
              $category = mysqli_fetch_assoc($category_result);
              echo $category['title']
          
              ?>
      </h2>

  </header>

  <?php if(mysqli_num_rows($posts) > 0) : ?>

    <section class="posts">

      <div class="container post__container">

          <?php while($post = mysqli_fetch_assoc($posts)) : ?>

          <article class="post">

              <div class="post__thumnail">

                  <img src="./data/<?= $post['thumbnail'] ?>" alt="blog">

              </div>

              <div class="post__info">

                  <h3 class="post__title">

                      <a href="<?= $base_url ?>post.php?id=<?= $post['id'] ?>">

                          <?= $post['title'] ?>

                      </a>

                  </h3>
                  
                  <p class="post__body">

                      <?= substr($post['body'],0 , 150) ?> 

                      <br/>

                      <a href="<?= $base_url  ?>post.php?id=<?= $post['id'] ?>">

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

    <div class="alert__message error lg">
        <p>
            Aucun message n'a été trouvé pour cette catégorie ..!
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