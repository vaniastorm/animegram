<?php

session_start();

require_once 'models/users.php';

$users = null;
$loggedUserId = $_SESSION['user']['id'];
$users = getMyFriends($loggedUserId);
   

include 'views/myfriends.phtml';