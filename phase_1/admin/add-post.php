<?php
include 'header/header.php';


$query = "SELECT * FROM categories";

$categories = mysqli_query($conn, $query);

// récupérer les données du formulaire
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

// supprimer la session de données du formulaire
unset($_SESSION['add-post-data']);
?>

<!-- Formulaire d'ajout d'un article -->
<section class="form__section">
    <div class="container form__section-container">

        <h2>Ajouter des postes</h2>

        <?php if(isset($_SESSION['add-post'])) : ?>

        <div class="alert__message error">
            <p>
                <?= $_SESSION['add-post'];
                unset($_SESSION['add-post']);
                 ?>
            </p>
        </div>

        <?php endif ?>

        <form action="<?= $base_url ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">

            <input type="text" placeholder="Titre" name="title" value="<?= $title ?>">

            <select name="category">

            <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>
            <textarea rows="10" placeholder="Contenu" name="body"><?= $body ?></textarea>

            <?php if(isset($_SESSION['user_is_admin'])) : ?>

            <div class="form__control inline">
                <input type="checkbox" id="is_feactured" name="is_featured" value="1" checked>
                <label for="is_feactured">À la une</label>
            </div>

            <?php endif ?>

            <div class="form__control">
                <label for="thumbnail">Ajouter une vignette</label>
                <input type="file" id="thumbnail" name="thumbnail">
            </div>

            <button type="submit" class="btn" name="submit">Créer des postes</button>

        </form>
    </div>
</section>

<?php
  include __DIR__. '/../hefo/footer.php';
?>
