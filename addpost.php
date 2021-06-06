<?php

require_once 'models/posts.php';
require_once 'models/users.php';

session_start();

//verificar se o user submeteu o form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $path = 'views/images/animecoverimg/';
    $hash = md5(uniqid()); 
    $postDate = date('Y-m-d_H-i-s');
    $targetFile = '';
 
    if (!empty($_FILES)) { //se o ficheiro não estiver vazio...
        
        $targetFile = sprintf("%s%s_%s_%s", $path, $postDate, $hash, $_FILES['image']['name']);
        $data = file_get_contents($_FILES['image']['tmp_name']); 
        file_put_contents($targetFile, $data);
    }   

    $postCreated = createAnimePost($targetFile, $_POST['title'], $_POST['textContent'], $postDate, $hash);
    
    if ($postCreated) {
        header("Location: showposts.php?status=PostCreated");
    } else {
        print_r("Error: post not created");
    }

} 

$animes = glob('views/images/animecoverimg/*');

include 'views/form.phtml';
