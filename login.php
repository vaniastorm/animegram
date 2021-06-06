<?php

require_once 'models/users.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (empty($_POST['username']) || empty($_POST['password'])) { //se os campos de username e password estivereme vazios, dá erro
        header("HTTP/1.1 400 Bad request");
        $message = 'Username and password are required';
    } else { //senão chama os valores dos campos
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password = md5($password);

        if (loginAccount($username, $password)) { //se fizer login com os valores dos campos
            header("Location: homepage.php"); //redirecciona para a homepage
            
        } else {
            $message = 'Bad credentials';
        }
    }
}

include 'views/login.phtml';
