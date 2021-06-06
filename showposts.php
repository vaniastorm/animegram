<?php

require_once 'models/posts.php';
//require_once 'removepost.php';

session_start();

$filter = $_SESSION['user']['id'];
$animes = array();

//$posts = getAllAnimePosts(isset($_GET['search']) ? $_GET['search'] : null);

/* if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$_SESSION['search'] = "search";
    $searchData = $_POST['searchPost'];
    $animes = searchPost($searchData);
    
    //die($animes[0]['title']);

}  else {
}*/

if (isset($_SESSION['searchPost']) != '') {

        $searchData = $_SESSION['searchPost'];
        $animes = searchPost($searchData);         
    
} else {
    $animes = getAllAnimePosts($filter);
}


include 'views/homepage.phtml';