<?php

session_start();

require_once 'models/posts.php';

$users = null;
$loggedUserId = $_SESSION['user']['id'];
$animes = getAllUsersPosts();
   

include 'views/allposts.phtml';