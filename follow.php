<?php

require_once 'models/users.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idFriend = (int)$_POST['id-followed'];
    $idUser = (int)$_SESSION['user']['id'];
    $usernameFriend = $_POST['friendName'];    
    
    
    $_SESSION['followFriends'] = "follow";
    $result = follow($usernameFriend, $idFriend, $idUser);
    //die($result);

    if ($result) {
        //$_SESSION['friend_usernames'] = [$usernameFriend];
        $followedUserNames = array();

        if (isset($_SESSION['friend_usernames'])) {    //verificar se já existem users a ser seguidos na sessão        
            
            $followedUserNames = (array)$_SESSION['friend_usernames']; //recuperar a lista com os users que já esão a ser seguidos
            array_push($followedUserNames, $usernameFriend); //adicionar nov elemento à list dos que já estão a ser seguidos
        } else { //primeiro follow
            array_push($followedUserNames, $usernameFriend); //adicionar à lista o primeiro elemento
        }

        $_SESSION['friend_usernames'] = $followedUserNames; //criar sessão com os nomes dos seguidos ou actualizar a lista dos seguidos
        
        header("Location: myfriends.php");
    } else {
        $message = "Não foi possível seguir o seu amigo";
    }
}