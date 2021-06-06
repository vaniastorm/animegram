<?php

require_once 'core/database.php';

//This file hosts functions concerning posts
//devolve um array com todos os meus posts
function getAllAnimePosts($filter = null) {  
    $pdoConnection = getConnection();
    $sqlQuery = "SELECT * FROM posts";

    if (!is_null($filter)) { 
        $sqlQuery .= " WHERE id_user = " . $filter;
    }

    $command = $pdoConnection->prepare($sqlQuery);    
    $command->execute();
    $posts = $command->fetchAll(PDO::FETCH_ASSOC);    
    return $posts; 
}

//SEARCH
function searchPost($filter) {
    $pdoConnection = getConnection();
   
    if (!is_null($filter)) { 
        
        $sqlQuery = "SELECT * FROM posts WHERE textContent LIKE ? OR title LIKE ?";
        $params = array("%$filter%", "%$filter%");
        $command = $pdoConnection->prepare($sqlQuery);
        $command->execute($params);

        $posts = $command->fetchAll(PDO::FETCH_ASSOC);  
        return $posts;
    } else {
        echo "No posts found that match the search term";
    }
}

//útil para fazer o update
function getAnimePostById($idPost) {
    $pdoConnection = getConnection();
    $command = $pdoConnection->prepare("SELECT * FROM posts WHERE id_post = :id_post" );
    $command->execute([':id_post' => $idPost]); 
    $post = $command->fetch();
    return $post;
}

//criar post
function createAnimePost($targetFile, $title, $textContent, $postDate, $image_id) {
    $pdoConnection = getConnection();
    $id_user = $_SESSION['user']['id'];
    $username = $_SESSION['user']['name'];

    $sqlQuery = "INSERT INTO posts (textContent, postDate, id_user, id_image, username, title, imageUrl)
                 VALUES (:textContent, :postDate, :id_user, :id_image, :username, :title, :imageUrl)";

    $command = $pdoConnection->prepare($sqlQuery);    
    $result = $command->execute(array(':textContent'=>$textContent, ':postDate'=>$postDate, 
                                      ':id_user'=>$id_user, ':id_image'=>$image_id,
                                      ':username'=>$username, ':title'=>$title, ':imageUrl'=>$targetFile));
    
    if ($result) {
        echo "post created";
        return true;
    } else {
        echo "Error: post not created";
        return false;
    }
}

//check!
function removeAnimePost($idPost, $idUser) {
    $pdoConnection = getConnection();
    $anime = getAnimePostById($idPost);    

    if ($anime != null && $anime['id_user'] == $idUser) {
        $data = [
            'id_post' => $idPost,
            'id_user' => $idUser
        ];
    
        $sqlQuery = "DELETE FROM posts WHERE id_post = :id_post AND id_user = :id_user";
        $command= $pdoConnection->prepare($sqlQuery);
        $result = $command->execute($data);

        if ($result) {
            echo "post deleted";
            return true;
        } else {
            echo "Error: it was not possible to delete post";
            return false;
        }
    }    
}

function getAllUsersPosts() {
    $pdoConnection = getConnection();
    $datePosted = date('Y-m-d_H-i-s');

    try {
        $sqlQuery = "SELECT * FROM posts";
        $command = $pdoConnection->prepare($sqlQuery);
        $command->execute();
        $posts = $command->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    } catch (PDOException $e) {
        echo "PDOException: " . $e->getMessage();
        return false;
    }
}

