<?php
const MYSQL_HOST='127.0.0.1';
const MYSQL_PORT=3306;            // mets 3307 si ton MySQL est sur 3307
const MYSQL_NAME='my_recipes';
const MYSQL_USER='root';
const MYSQL_PASSWORD='root';      // ou '' si pas de mdp

try {
  $dsn = sprintf('mysql:host=%s;dbname=%s;port=%s', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT);
  $db = new PDO($dsn, MYSQL_USER, MYSQL_PASSWORD, [
    PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"
  ]);
  $db->exec("SET collation_connection=utf8_general_ci");
} catch(Exception $e){ die('Erreur : '.$e->getMessage()); }
