<?php

session_start();

require_once 'models/users.php';

$users = null;
$loggedUserId = $_SESSION['user']['id'];

    
$users = getAllUsers();
//unset($_SESSION['friend_usernames']);



include 'views/allfriends.phtml';