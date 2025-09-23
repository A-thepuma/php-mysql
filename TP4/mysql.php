<?php
const MYSQL_HOST = '127.0.0.1'; // force TCP
const MYSQL_PORT = 3306;
const MYSQL_NAME = 'my_recipes';
const MYSQL_USER = 'root';
const MYSQL_PASSWORD = 'root';

try {
    $db = new PDO(
        'mysql:host='.MYSQL_HOST.';dbname='.MYSQL_NAME.';port='.MYSQL_PORT,
        MYSQL_USER,
        MYSQL_PASSWORD
    );
    // Active erreurs PDO
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Charset simple (compatible PHP 5.4 + MySQL 5.6)
    $db->exec("SET NAMES utf8");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
