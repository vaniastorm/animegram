<?php

require_once 'models/users.php';

logoutAccount();

header("Location: index.php");
die();