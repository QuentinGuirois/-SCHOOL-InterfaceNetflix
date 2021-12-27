<?php
define('SERVER', "sqlprive-pc2372-001.privatesql.ha.ovh.net:3306");
define('USER', "cefiidev1175");
define('PASSWORD', "y34Dmn3E");
define('BASE', "cefiidev1175");

try {
    $bdd = new PDO("mysql:host=" . SERVER . ";dbname=" . BASE, USER, PASSWORD);
    echo "la connexion fonctionne";
} catch (Exception $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>