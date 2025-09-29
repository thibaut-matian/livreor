<?php
require_once 'config.php';
require_once 'functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = cleanInput($_POST['login']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($login) || empty($password) || empty($confirm_password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas.';
    } elseif (strlen($password) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
        // Vérifier si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        
        if ($stmt->fetch()) {
            $error = 'Ce nom d\'utilisateur est déjà pris.';
        } else {
            // Insére nouvel utilisateur
            $hashed_password = hashPassword($password);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, password) VALUES (?, ?)");
            
            if ($stmt->execute([$login, $hashed_password])) {
                $success = 'Inscription réussie ! Vous pouvez maintenant vous connecter.';
                // redirection (demande copilot)
                header('refresh:2;url=connexion.php');
            } else {
                $error = 'Erreur lors de l\'inscription. Veuillez réessayer.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Livre d'Or</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1> Livre d'Or Magique</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="livre-or.php">Livre d'Or</a></li>
                    <li><a href="inscription.php">S'inscrire</a></li>
                    <li><a href="connexion.php">Se connecter</a></li>
                </ul>
            </nav>
        </header>

        <div class="main-content">
            <div class="form-container">
                <h2>Inscription</h2>
                <p>Créez votre compte pour pouvoir laisser des commentaires dans notre livre d'or.</p>
                
                <?php 
                if ($error) displayMessage('error', $error);
                if ($success) displayMessage('success', $success);
                ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="login">Nom d'utilisateur :</label>
                        <input type="text" id="login" name="login" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                        <small style="color: #666;">Minimum 6 caractères</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirmer le mot de passe :</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="submit" class="btn">S'inscrire</button>
                        <a href="connexion.php" class="btn btn-secondary">Déjà inscrit ?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>