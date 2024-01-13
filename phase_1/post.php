
<?php

include 'hefo/header.php';


if (isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
} else{
    header('location: ' . $base_url . 'blog.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publication</title>
</head>
<body>

  <section class="singlepost">
      <div class="container singlepost__container">
          <h2><?= $post['title'] ?></h2>

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

          <div class="singlepost__thumbnail">
              <img src="./data/<?= $post['thumbnail'] ?>" alt="wildlife">
          </div>
          <p>
              <?= $post['body'] ?>
          </p>   
      </div>
  </section>

</body>
</html>

<?php

  include 'hefo/footer.php';

?>
