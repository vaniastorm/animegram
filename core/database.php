<?php

//ficheiro para ligar à base de dados
function getConnection() {
    
    $config = require 'configs/dbconfig.php'; 
    extract($config); 
    $dsn = "mysql:host=$host;dbname=$name;port=$port";

    try { 
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        return $pdo;         

    } catch(PDOException $e) {
        die('Error connecting to database' . $e->getMessage());
    }
}

