<?php

require_once 'models/users.php';

session_start();

if (isset($_SESSION['user'])) { //se houver uma sessão com o user...
    header("Location: homepage.php"); //...redirecciona para a homepage
    die();
}

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 403:
            header('HTTP/1.1 403 Forbidden');
            $message = 'Access denied';
            break;
    }
}

include 'views/index.phtml';

