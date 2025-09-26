<?php
require_once 'config.php';

// Message erreur et validation
function displayMessage($type, $message) {
    echo "<div class='alert alert-$type'>$message</div>";
}

// user co 
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// proctection des pages
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: connexion.php');
        exit;
    }
}

// password hasher
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Fonction pour nettoyer les données d'entrée
function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>