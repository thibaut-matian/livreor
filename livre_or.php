<?php
require_once 'config.php';
require_once 'functions.php';

// Récupérer tous les commentaires avec les informations des utilisateurs
$stmt = $pdo->prepare("
    SELECT c.id, c.commentaire, c.date, u.login 
    FROM commentaires c 
    JOIN utilisateurs u ON c.id_utilisateur = u.id 
    ORDER BY c.date DESC
");
$stmt->execute();
$commentaires = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or</title>
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
                    <?php if (isLoggedIn()): ?>
                        <li><a href="profil.php">Mon Profil</a></li>
                        <li><a href="commentaire.php">Ajouter un commentaire</a></li>
                        <li><a href="logout.php" class="logout-link">Se déconnecter</a></li>
                    <?php else: ?>
                        <li><a href="inscription.php">S'inscrire</a></li>
                        <li><a href="connexion.php">Se connecter</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>

        <div class="main-content">
            <?php if (isLoggedIn()): ?>
                <div class="user-info">
                    <p>Connecté en tant que : <strong><?php echo htmlspecialchars($_SESSION['user_login']); ?></strong></p>
                </div>
            <?php endif; ?>

            <h2>Livre d'Or</h2>
            <p>Découvrez les messages laissés par notre communauté.</p>

            <?php if (isLoggedIn()): ?>
                <div style="text-align: center; margin-bottom: 30px;">
                    <a href="commentaire.php" class="btn">Laisser un commentaire</a>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin-bottom: 30px;">
                    <p>Vous devez être connecté pour laisser un commentaire.</p>
                    <a href="connexion.php" class="btn">Se connecter</a>
                    <a href="inscription.php" class="btn btn-secondary">S'inscrire</a>
                </div>
            <?php endif; ?>

            <?php if (empty($commentaires)): ?>
                <div style="text-align: center; padding: 40px; color: #666;">
                    <p>Aucun commentaire pour le moment. Soyez le premier à laisser un message !</p>
                </div>
            <?php else: ?>
                <div style="margin-top: 30px;">
                    <?php foreach ($commentaires as $commentaire): ?>
                        <div class="comment">
                            <div class="comment-meta">
                                Posté le <?php echo date('d/m/Y', strtotime($commentaire['date'])); ?> 
                                par <strong><?php echo htmlspecialchars($commentaire['login']); ?></strong>
                            </div>
                            <div class="comment-text">
                                <?php echo nl2br(htmlspecialchars($commentaire['commentaire'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>