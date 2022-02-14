<?php
define('SERVER', "votre connexion");
define('USER', "votre nom d'user");
define('PASSWORD', "votre mot de passe");
define('BASE', "votre nom de base");

try {
    $bdd = new PDO("mysql:host=" . SERVER . ";dbname=" . BASE, USER, PASSWORD);
    echo "la connexion fonctionne";
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
