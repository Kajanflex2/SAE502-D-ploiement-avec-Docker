

<?php

include 'header/header.php';

// récupère les messages de l'utilisateur actuel dans la base de données

$current_user_id = $_SESSION['user-id'];
$query = "SELECT id, title, category_id FROM posts WHERE author_id=$current_user_id ORDER BY id DESC";
$posts = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index</title>
  <style>
      .dashboard__container {
      display: grid;
      grid-template-columns: 14rem auto;
      gap: 2rem;
      background: #1a1919;
      padding: 2rem;
      margin-top: 5rem;
      border-radius: 25px;
      font-size: initial;
      text-align: center;
    }

    .dashboard aside a:hover {
      background: #e86618eb;
    }

    .dashboard aside a.active {
      background-color: #33c000e0;
    }
    
  </style>
</head>
<body>

  <section class="dashboard">


      <?php if(isset($_SESSION['add-post-success'])) : ?>
      <div class="alert__message success container">
          <p>
              <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
          </p>
      </div>



      <?php elseif(isset($_SESSION['edit-post-success'])) : ?>
      <div class="alert__message success container">
          <p>
              <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
          </p>
      </div>

  

      <?php elseif(isset($_SESSION['edit-post'])) : ?>
      <div class="alert__message error container">
          <p>
              <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
          </p>
      </div>


      
      <?php elseif(isset($_SESSION['delete-post-success'])) : ?>
      <div class="alert__message success container">
          <p>
              <?= $_SESSION['delete-post-success'];
                unset($_SESSION['delete-post-success']);
                ?>
          </p>
      </div>
      

    
      <?php endif ?>

      <div class="container dashboard__container">
          <button class="sidebar__toggle" id="show__sidebar-btn"><i class="uil uil-angle-right-b"></i></button>
          <button class="sidebar__toggle" id="hide__sidebar-btn"><i class="uil uil-angle-left-b"></i></button>
          <aside>
              <ul>
                  <li>
                      <a href="add-post.php">
                          <i class="uil uil-edit"></i>
                          <h5>Ajouter un publication</h5>
                      </a>
                  </li>
                  <li>
                      <a href="index.php" class="active">
                          <i class="uil uil-create-dashboard"></i>
                          <h5>Gérer les publications</h5>
                      </a>
                  </li>

                  <?php if(isset($_SESSION['user_is_admin'])) : ?>

                  <li>
                      <a href="add-user.php">
                          <i class="uil uil-user-plus"></i>
                          <h5>Ajout d'un utilisateur</h5>
                      </a>
                  </li>
                  <li>
                      <a href="manage-user.php">
                          <i class="uil uil-user-arrows"></i>
                          <h5>Gérer les utilisateurs</h5>
                      </a>
                  </li>
                  <li>
                      <a href="add-category.php">
                          <i class="uil uil-edit"></i>
                          <h5>Ajouter une catégorie</h5>
                      </a>
                  </li>
                  <li>
                      <a href="manage-category.php">
                          <i class="uil uil-list-ul"></i>
                          <h5>Gérer la catégorie</h5>
                      </a>
                  </li>

                  <?php endif ?>
              </ul>
          </aside>

          <main>
              <h2>Gérer les publications</h2>
              <?php if(mysqli_num_rows($posts) > 0) : ?>

              <table>
                  <thead>
                      <th>Titre</th>
                      <th>Catégorie</th>
                      <th>Mise à jour</th>
                      <th>Supprimer</th>
                  </thead>
                  <tbody>
                      <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                          <!-- récupérer le titre de la catégorie de chaque article dans le tableau des catégories -->

                          <?php
                          $category_id = $post['category_id'];
                          $category_query = "SELECT title FROM categories WHERE id = $category_id";
                          $category_result = mysqli_query($conn, $category_query);
                          $category = mysqli_fetch_assoc($category_result);

                          ?>
                      <tr>
                          <td><?= $post['title'] ?></td>
                          <td><?= $category['title'] ?></td>
                          <td><a href="<?= $base_url ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm success">Mise à jour</a></td>
                          <td><a href="<?= $base_url ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Supprimer</a></td>
                      </tr>
                      <?php endwhile ?>
                    
                  </tbody>
              </table>

              <?php else : ?>
                  <div class="alert__message error"><?= "Aucun publication n'a été trouvé ..!" ?></div>

                  <?php endif ?>
          </main>
      </div>
  </section>
  
</body>
</html>

<?php
  include __DIR__. '/../hefo/footer.php';
?>