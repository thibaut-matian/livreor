<?php
require_once 'config.php';
require_once 'functions.php';

// Si l'utilisateur est déjà connecté, rediriger vers l'accueil
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = cleanInput($_POST['login']);
    $password = $_POST['password'];
    
    if (empty($login) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Vérifier les identifiants
        $stmt = $pdo->prepare("SELECT id, login, password FROM utilisateurs WHERE login = ?");
        $stmt->execute([$login]);
        $user = $stmt->fetch();
        
        if ($user && verifyPassword($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_login'] = $user['login'];
            
            header('Location: index.php');
            exit;
        } else {
            $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Livre d'Or</title>
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
                <h2>Connexion</h2>
                <p>Connectez-vous à votre compte pour accéder à toutes les fonctionnalités.</p>
                
                <?php if ($error) displayMessage('error', $error); ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="login">Nom d'utilisateur :</label>
                        <input type="text" id="login" name="login" value="<?php echo isset($_POST['login']) ? htmlspecialchars($_POST['login']) : ''; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div style="text-align: center;">
                        <button type="submit" class="btn">Se connecter</button>
                        <a href="inscription.php" class="btn btn-secondary">Pas encore inscrit ?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>