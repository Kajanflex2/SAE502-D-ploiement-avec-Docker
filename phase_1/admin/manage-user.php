<?php
include 'header/header.php';


// récupérer l'utilisateur dans la base de données mais pas l'utilisateur actuel
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM users WHERE NOT id=$current_admin_id";
$users = mysqli_query($conn, $query);
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

    <!-- l'ajout d'un utilisateur est réussi -->
    <?php if(isset($_SESSION['add-user-success'])) : ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['add-user-success'];
              unset($_SESSION['add-user-success']);
              ?>
        </p>
    </div>

    <!-- Modifier les détails de l'utilisateur réussi -->

    <?php elseif(isset($_SESSION['edit-user-success'])) : ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['edit-user-success'];
                    unset($_SESSION['edit-user-success']);
                    ?>
        </p>
    </div>

    <!-- L'édition des détails de l'utilisateur n'a pas abouti-->

    <?php elseif(isset($_SESSION['edit-user'])) : ?>
    <div class="alert__message error container">
        <p>
            <?= $_SESSION['edit-user'];
                    unset($_SESSION['edit-user']);
                    ?>
        </p>
    </div>

    <!-- la suppression des détails de l'utilisateur n'a pas abouti -->

    <?php elseif(isset($_SESSION['delete-user'])) : ?>
    <div class="alert__message error container">
        <p>
            <?= $_SESSION['delete-user'];
                    unset($_SESSION['delete-user']);
                    ?>
        </p>
    </div>
    <!-- suppression des détails de l'utilisateur réussie -->

    <?php elseif(isset($_SESSION['delete-user-success'])) : ?>
    <div class="alert__message success container">
        <p>
            <?= $_SESSION['delete-user-success'];
                    unset($_SESSION['delete-user-success']);
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
                        <h5>Gérer les postes</h5>
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
                    <a href="manage-user.php" class="active">
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
                        <h5>Gérer les catégories</h5>
                    </a>
                </li>

                <?php endif ?>
            </ul>
        </aside>

        <main>
            <h2>Gérer les utilisateurs</h2>
            <?php if(mysqli_num_rows($users) > 0) : ?>
            <table>
                <thead>
                    <th>Nom</th>
                    <th>Nom d'utilisateur</th>
                    <th>Mise à jour</th>
                    <th>Supprimer</th>
                    <th>Admin</th>
                </thead>
                <tbody>
                    <?php while($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                        <td><?= "{$user['firstname']} {$user['lastname']}" ?> </td>
                        <td> <?= $user['username'] ?> </td>
                        <td><a href="<?= $base_url ?>admin/edit-user.php?id=<?= $user['id'] ?>"
                                class="btn sm success">Modifier un utilisateur</a></td>
                        <td><a href="<?= $base_url ?>admin/delete-user.php?id=<?= $user['id'] ?>"
                                class="btn sm danger">Supprimer un utilisateur</a></td>
                        <td><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>

            <?php else : ?>
                <div class="alert__message error"><?= "Pas d'utilisateurs ..!" ?></div>

                <?php endif ?>
        </main>
    </div>
</section>



<?php
  include __DIR__. '/../hefo/footer.php';
?>