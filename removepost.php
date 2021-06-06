<?php

require_once 'models/posts.php';
require_once 'models/users.php';


session_start();

$user = verifyAccess();
$idUser = $_SESSION['user']['id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idPost = (int)$_POST['id-post'];
    $result = removeAnimePost($idPost, $idUser);

    if ($result) {
        header("Location: showposts.php");
    } else {
        $message = "Não foi possível apagar o seu post";
    }
} else {
    die('failed');
}


