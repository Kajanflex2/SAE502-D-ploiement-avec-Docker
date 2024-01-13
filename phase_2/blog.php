
<?php

include 'hefo/header.php';

$query = "SELECT * FROM posts ORDER BY date_time DESC";

$posts = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Publication</title>
</head>
<body>

<section class="search__bar">

    <form action="<?= $base_url ?>cherche.php" method="GET" class="container search__bar-container">

        <div><i class="uil uil-search"></i>

            <input type="search" name="search" placeholder="Rechercher les publication ici ...">

        </div>

        <button type="submit" class="btn" name="submit">

            Chercher

        </button>

    </form>

</section>

<section class="posts">

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
                <a href="<?= $base_url ?>category-post.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
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

</body>
</html>