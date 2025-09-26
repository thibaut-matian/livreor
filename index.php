<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'Or - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1> Livre d'Or Magique</h1>
            <p>Partagez vos pensées et découvrez celles des autres</p>
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
                    <p>Bienvenue, <strong><?php echo htmlspecialchars($_SESSION['user_login']); ?></strong> !</p>
                </div>
            <?php endif; ?>

            <h2>Bienvenue sur notre Livre d'Or</h2>
            <p>Ce site vous permet de partager vos pensées, vos expériences et vos messages avec la communauté. 
            Découvrez ce que les autres ont à dire et laissez votre propre empreinte dans notre livre d'or numérique.</p>

            <h3>Fonctionnalités disponibles :</h3>
            <ul style="margin: 20px 0; padding-left: 20px;">
                <li><strong>Consultation du livre d'or</strong> : Lisez tous les commentaires laissés par les visiteurs</li>
                <?php if (!isLoggedIn()): ?>
                    <li><strong>Inscription</strong> : Créez votre compte pour pouvoir participer</li>
                    <li><strong>Connexion</strong> : Connectez-vous à votre compte existant</li>
                <?php else: ?>
                    <li><strong>Ajout de commentaires</strong> : Partagez vos pensées avec la communauté</li>
                    <li><strong>Gestion de profil</strong> : Modifiez vos informations personnelles</li>
                <?php endif; ?>
            </ul>

            <?php if (!isLoggedIn()): ?>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="inscription.php" class="btn">Rejoignez-nous !</a>
                    <a href="connexion.php" class="btn btn-secondary">Se connecter</a>
                </div>
            <?php else: ?>
                <div style="text-align: center; margin-top: 30px;">
                    <a href="livre-or.php" class="btn">Voir le Livre d'Or</a>
                    <a href="commentaire.php" class="btn btn-secondary">Laisser un commentaire</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>