<?php

//ficheiro para ligar à base de dados
function getConnection() {
    
    $config = require 'configs/dbconfig.php'; //chamo as configurações do dbconfig.php  
    extract($config); //o extract cria directamente variáveis para todos os índices que estejam no ficheiro dbconfig.php
    //extract transforma qualquer array associativo em variáveis
    
    //$dsn = sprintf("mysql:host=%s;dbname=%s;port=%d", $host, $name, $port); //indica onde estão os meus dados e como vou acedê-los
    $dsn = "mysql:host=$host;dbname=$name;port=$port";

    try { 
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        //echo "Connected successfully"; //---->check!
        return $pdo; //tem que retornar o valor para poder ser usado na function getConnection()
        

    } catch(PDOException $e) {
        die('Error connecting to database' . $e->getMessage());
    }

    
    // outra forma de fazer a ligação à base de dados
    /*
    try {
        $connection = new PDO("mysql:host=$host;dbname=$dbname;port=$port", $user, $pass);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } */
}

