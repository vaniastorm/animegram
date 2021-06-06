<?php

require_once 'models/users.php';
require_once 'models/posts.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchData = $_POST['searchPost'];
        
    if ($searchData != "") { 
        $_SESSION['searchPost'] = $searchData;
        header("Location: showposts.php");
    } else {
        $message = "Não foi possível seguir o seu amigo";
    }
}