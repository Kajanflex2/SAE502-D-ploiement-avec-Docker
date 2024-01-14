<?php
require 'con_db/conexdb.php';

if (isset($_POST['submit'])) {

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];

    // Vérifier si l'utilisateur est connecté et obtenir son id
    $userId = $_SESSION['user-id'] ?? null;

    if ($userId && $new_password === $confirm_new_password) {

        // Récupérer l'ancien mot de passe depuis la base de données
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($old_password, $user['password'])) {
                // L'ancien mot de passe est correct, on peut mettre à jour avec le nouveau

                // Valider le nouveau mot de passe
                $createpassword = $new_password;
                $confirmpassword = $confirm_new_password;

                if (strlen($createpassword) < 12 || strlen($confirmpassword) < 12) {
                    $_SESSION['reset-error'] = "Le mot de passe doit comporter 12 caractères.";
                } elseif (
                    !preg_match('@[A-Z]@', $createpassword) ||
                    !preg_match('@[a-z]@', $createpassword) ||
                    !preg_match('@[0-9]@', $createpassword) ||
                    !preg_match('@[^\w]@', $createpassword)
                ) {
                    $_SESSION['reset-error'] = "Le mot de passe doit contenir au moins un chiffre, une majuscule, une minuscule et un caractère spécial.";
                } else {
                    // Mot de passe valide, procéder à la mise à jour
                    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update_stmt->bind_param("si", $hashed_new_password, $userId);

                    if ($update_stmt->execute()) {
                        $_SESSION['reset-success'] = "Mot de passe mis à jour avec succès.";
                        header('location: ' . $base_url . 'index.php');
                        exit(0);
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
    exit(0);
}
?>
