<?php

require_once 'models/posts.php';
require_once 'models/users.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $path = 'views/images/profilephotos/';
    $hash = md5(uniqid()); 
    $postDate = date('Y-m-d_H-i-s');
    $targetFile = '';
 
    if (!empty($_FILES)) { 
        
        $targetFile = sprintf("%s%s_%s_%s", $path, $postDate, $hash, $_FILES['photo']['name']);
        $data = file_get_contents($_FILES['photo']['tmp_name']); 
        file_put_contents($targetFile, $data);
    }   
    
    $profilePhoto = addProfilePhoto($targetFile);
    
    if ($profilePhoto) { 
        header("Location: login.php"); //tem que terminar a sessão para actualizar a foto de perfil(function login)
    } else {
        print_r("Error: photo not uploaded");
    }
} 

$photos = glob('views/images/profilephotos/*');
