<?php
session_start();
include('db.php');
if(isset($_POST['comment'])){
    $comment = $_POST['comment'];
    $post_id = $_POST['postId'];
    $user_id = $_SESSION['loggedinuserid'];
    // Prevention to perform SQL injection attacks 
    $post_id = mysqli_real_escape_string($db, $post_id);
    $user_id = mysqli_real_escape_string($db, $user_id);
    $query = "INSERT INTO `comments` (`comment`, `post_id`,`added_by`)  VALUES ('$comment',$post_id, $user_id)";
    $result = mysqli_query($db, $query);
    if($result){
        echo "Comment Added Successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}
// update comment
if(isset($_POST['updateComment'])){
    $comment = $_POST['updateComment'];
    $comment_id = $_POST['commentId'];
    // Prevention to perform SQL injection attacks
    $comment = mysqli_real_escape_string($db, $comment);
    $comment_id = mysqli_real_escape_string($db, $comment_id);
    //parameterized query
    $query = "UPDATE `comments` SET `comment` = ? WHERE `comments`.`id` = ?";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $query)){
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    } else {
        mysqli_stmt_bind_param($stmt, "si", $comment, $comment_id);
        mysqli_stmt_execute($stmt);
        echo "Comment Updated Successfully";
    }
}
// save like
if(isset($_POST['likedPostId'])){
    $post_id = $_POST['likedPostId'];
    $user_id = $_SESSION['loggedinuserid'];
    // Prevention to perform SQL injection attacks
    $post_id = mysqli_real_escape_string($db, $post_id);
    $user_id = mysqli_real_escape_string($db, $user_id);
    // check if like is already available with same user and post with parameterized query
    $checkLikeQuery = "SELECT* from likes where post_id = ? and user_id = ?";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $checkLikeQuery)){
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result)>0){
            echo "Liked";
        } else{
            //parameterized query
            $query = "INSERT INTO `likes` (`post_id`,`user_id`) VALUES (?, ?)";
            $stmt = mysqli_stmt_init($db);
            if(!mysqli_stmt_prepare($stmt, $query)){
                echo "Error: " . $query . "<br>" . mysqli_error($db);
            } else {
                mysqli_stmt_bind_param($stmt, "ii", $post_id, $user_id);
                mysqli_stmt_execute($stmt);
                echo "Like Added Successfully";
            }
        }
    }
}

// delete comment
if(isset($_POST['deleteCommentId'])){
    $comment_id = $_POST['deleteCommentId'];
    // Prevention to perform SQL injection attacks
    $comment_id = mysqli_real_escape_string($db, $comment_id);  
    //parameterized query
    $query = "DELETE FROM `comments` WHERE `comments` . `id` = ?";
    $stmt = mysqli_stmt_init($db);
    if(!mysqli_stmt_prepare($stmt, $query)){
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    } else {
        mysqli_stmt_bind_param($stmt, "i", $comment_id);
        mysqli_stmt_execute($stmt);
        echo "Comment Deleted Successfully";
    }
}