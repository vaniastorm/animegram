<?php

session_start();

require_once 'models/users.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username   = $_POST['username'];
    $password   = $_POST['password'];
    $email      = $_POST['email'];    
    
    if (signupAccount($username, $password, $email)) { 
        header("Location: login.php"); 
        die();
    } else {
        $message = 'Error signing up';
    }
}

include 'views/signup.phtml';