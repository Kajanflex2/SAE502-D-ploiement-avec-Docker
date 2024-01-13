<?php
include 'header/header.php';


$query= "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($conn, $query);
?>


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

<section class="dashboard">

    <!-- Ajouter un message de réussite -->
    <?php if(isset($_SESSION['add-category-success'])) : ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['add-category-success'];
                    unset($_SESSION['add-category-success']);
                    ?>
        </p>
    </div>

    <!-- Ajouter un message d'échec -->
    <?php elseif(isset($_SESSION['add-category'])) : ?>
    <div class="alert__message error container">
        <p>
            <?= $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                    ?>
        </p>
    </div>
    <!-- Message d'échec de la modification de la catégorie -->
    <?php elseif(isset($_SESSION['edit-category'])) : ?>
    <div class="alert__message error container">
        <p>
            <?= $_SESSION['edit-category'];
                    unset($_SESSION['edit-category']);
                    ?>
        </p>
    </div>

    <!-- Le message "Modifier la catégorie" a abouti -->
    <?php elseif(isset($_SESSION['edit-category-success'])) : ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['edit-category-success'];
                    unset($_SESSION['edit-category-success']);
                    ?>
        </p>
    </div>

    <!-- Le message de suppression de la catégorie a été envoyé avec succès -->
    <?php elseif(isset($_SESSION['delete-category-success'])) : ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['delete-category-success'];
                    unset($_SESSION['delete-category-success']);
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
                        <h5>Ajouter un poste</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php">
                        <i class="uil uil-create-dashboard"></i>
                        <h5>Gérer le poste</h5>
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
                    <a href="manage-category.php" class="active">
                        <i class="uil uil-list-ul"></i>
                        <h5>Gérer les catégories</h5>
                    </a>
                </li>

                <?php endif ?>
            </ul>
        </aside>

        <main>
            <h2>Gérer les catégories</h2>
            <?php if(mysqli_num_rows($categories) > 0) : ?>
            <table>
                <thead>
                    <th>Titre</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </thead>
                <tbody>
                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                    <tr>
                        <td><?= $category['title'] ?></td>
                        <td><a href="<?= $base_url ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm success">Modifier la catégorie</a></td>
                        <td><a href="<?= $base_url ?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Supprimer une catégorie</a></td>
                    </tr>
                    <?php endwhile ?>

                </tbody>
            </table>

            <?php else : ?>
                <div class="alert__message error"><?= "Aucune catégorie n'a été trouvée ..! " ?></div>
                <?php endif ?>
        </main>
    </div>
</section>

<!-- End category section -->


<?php
  include __DIR__. '/../hefo/footer.php';
?>