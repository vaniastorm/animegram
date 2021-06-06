<?php

require_once 'models/users.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idFriend = (int)$_POST['id-followed'];
    $nameFriend = $_POST['name-followed'];
    $idUser = (int)$_SESSION['user']['id'];    

    $result = unFollow($idFriend, $idUser);

    if ($result) {
        header("Location: myfriends.php");
        
        if (isset($_SESSION['friend_usernames'])) { 
            $_SESSION['friend_usernames']=array_diff($_SESSION['friend_usernames'],$nameFriend);
        } 

    } else {
        $message = "Não foi possível deixar de seguir o seu amigo";
    }
}