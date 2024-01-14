<?php
session_start();
require 'con_db/conexdb.php';

if (isset($_POST['submit'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Vérifier si l'utilisateur est connecté et obtenir son ID
    $userId = $_SESSION['user-id'] ?? null;

    if ($userId && $new_password === $confirm_new_password) {
        // Récupérer l'ancien mot de passe depuis la base de données
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_array($result);

            if (password_verify($old_password, $user['password'])) {
                // L'ancien mot de passe est correct, valider le nouveau mot de passe
                if (strlen($new_password) < 12) {
                    $_SESSION['reset-error'] = "Le mot de passe doit comporter au moins 12 caractères.";
                } elseif (!preg_match('@[A-Z]@', $new_password)) {
                    $_SESSION['reset-error'] = "Le mot de passe doit contenir au moins une lettre majuscule.";
                } elseif (!preg_match('@[a-z]@', $new_password)) {
                    $_SESSION['reset-error'] = "Le mot de passe doit contenir au moins une lettre minuscule.";
                    } elseif (!preg_match('@[0-9]@', $new_password)) {
                    $_SESSION['reset-error'] = "Le mot de passe doit contenir au moins un chiffre.";
                    } elseif (!preg_match('@[^\w]@', $new_password)) {
                    $_SESSION['reset-error'] = "Le mot de passe doit contenir au moins un caractère spécial.";
                    } else {
                    // Le nouveau mot de passe est valide, procéder à la mise à jour
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update_stmt->bind_param("si", $hashed_new_password, $userId);
                    $update_stmt->execute();
                if (mysqli_affected_rows($conn) > 0) {
                    $_SESSION['reset-success'] = "Mot de passe mis à jour avec succès.";
                    header('location: ' . $base_url . 'index.php');
                    exit();
                } else {
                    $_SESSION['reset-error'] = "Erreur lors de la mise à jour du mot de passe.";
                }
            }
        } else {
            $_SESSION['reset-error'] = "L'ancien mot de passe est incorrect.";
        }
    } else {
        $_SESSION['reset-error'] = "Utilisateur non trouvé.";
    }
} else {
    $_SESSION['reset-error'] = "Les mots de passe ne correspondent pas ou vous n'êtes pas connecté.";
}
header('location: ' . $base_url . 'resetpassword.php');
exit();
}
?>
