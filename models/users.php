<?php

require_once 'core/database.php';

//TODOS OS USERS
function getAllUsers() { //para seguir os friends
    $pdoConnection = getConnection();
    $userId = $_SESSION['user']['id'];
    $sqlQuery = "SELECT * FROM users WHERE id <> " . $userId;

    $command = $pdoConnection->query($sqlQuery); 
    return $command->fetchAll();    
}

//SELECCIONAR PELO USERNAME
function getUserByUsername($username, $password) {
    $pdoConnection = getConnection();
    $sqlQuery = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1"; //pode haver mais que um user com o mesmo username
    print_r($sqlQuery);
    $command = $pdoConnection->prepare($sqlQuery);    
    $command->execute();
    $result = $command->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//FAZER LOGIN
function loginAccount($username, $password) {
    $user = getUserByUsername($username, $password); 

    if(!is_null($user)) {

        $_SESSION['user'] = [
            'id'          => $user['id'],
            'name'        => $user['username'],
            'avatar_url'  => $user['pictureUrl'],
        ];        
        
    } else {
        $_SESSION['user'] = null;
        $errorLogin = 'user not found';
    }
    return true;    
}

//CRIAR NOVO REGISTO
function signupAccount($username, $password, $email) {
    $pdoConnection = getConnection();  
    $password = md5($password); 
    
    try {
        $defaultAvatar = 'views/images/websiteImg/avatar.png';
        $sqlQuery = "INSERT INTO users (username, password, email, pictureUrl) 
                     VALUES ('$username', '$password', '$email', '$defaultAvatar')";

        $command = $pdoConnection->prepare($sqlQuery);
        $result = $command->execute(array(':username'=>$username, ':password'=>$password, 
                                       ':email'=>$email, ':pictureUrl'=>$defaultAvatar));
        //die($result);
        return $result;
    } catch (PDOException $e) {
        echo "PDOException: " . $e->getMessage();
        return false;
    }  
}

//FAZER LOGOUT
function logoutAccount() {
    session_start();
    unset($_SESSION['user']);
}

//SESSION START
function verifyAccess() {
    //session_start();

    if (!isset($_SESSION['user'])) {
        header("HTTP/1.1 403 Forbidden");
        header("Location: homepage.php");
        die();
    }

    $user = $_SESSION['user'];
}

//ADD PROFILE PHOTO
function addProfilePhoto($targetFile) {
    $pdoConnection = getConnection();
    $id_user = $_SESSION['user']['id'];
    $data = [
        'pictureUrl' => $targetFile,
        'id' => $id_user,        
    ];

    $sqlQuery = "UPDATE users SET pictureUrl=:pictureUrl WHERE id=:id";
    $command= $pdoConnection->prepare($sqlQuery);
    $result = $command->execute($data);

    if ($result) {
        echo "photo created";
        return true;
    } else {
        echo "Error: photo not created";
        return false;
    }
}

//FOLLOW FRIENDS
function follow($usernameFriend, $idFriend, $idUser) {
    $pdoConnection = getConnection(); 
    $followDate = date('Y-m-d_H-i-s');          

    $data = [
        'username_friend' => $usernameFriend,
        'id_friend' => $idFriend,
        'id_user' => $idUser,
        'follow_date' => $followDate,
    ];

    $sqlQuery = "INSERT INTO friends (username_friend, id_friend, id_user, follow_date) 
                    VALUES (:username_friend, :id_friend, :id_user, :follow_date)";
    $command= $pdoConnection->prepare($sqlQuery);
    $result = $command->execute($data);

    if ($result) {
        echo "follow done";
        return true;
    } else {
        echo "Error: follow not done";
        return false;
    }
}

//UNFOLLOW
function unFollow($idFriend, $idUser) {
    $pdoConnection = getConnection();

    $data = [
        'idFriend' => $idFriend,
        'idUser' => $idUser,
    ];
    $sqlQuery = "DELETE FROM friends WHERE id_user = :idUser AND id_friend = :idFriend";
    $command= $pdoConnection->prepare($sqlQuery);
    $result = $command->execute($data);

    if ($result) {
        echo "unfollow done";
        return true;
    } else {
        echo "Error: unfollow not done";
        return false;
    }
}

//MY FRIENDS
function getMyFriends($loggedUserId) {
    $pdoConnection = getConnection(); 
    $followDate = date('Y-m-d_H-i-s');

    try {
        $sqlQuery = "SELECT * FROM users INNER JOIN friends ON users.id = friends.id_user WHERE users.id = " . $loggedUserId;

        $command = $pdoConnection->prepare($sqlQuery);
        $command->execute();
        $friends = $command->fetchAll(PDO::FETCH_ASSOC);
        return $friends;
    } catch (PDOException $e) {
        echo "PDOException: " . $e->getMessage();
        return false;
    }
}

