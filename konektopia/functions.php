<?php
include 'db.php';

if(isset($_POST['checkEmailExists'])){
    $email = $_POST['email'];
    // Prevention to perform SQL injection attacks 
    $email = mysqli_real_escape_string($db, $email);
    $query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($db, $query);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
      echo "success";
}else{
    echo "Email not found";
}
}
// updatePassword
if(isset($_POST['updatePassword'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "UPDATE `users` SET `password` = '$password' WHERE `users`.`email` = '$email'"; 
    if(mysqli_query($db, $query)){
        echo "success";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}
// delete deletePostId
if(isset($_POST['deletePostId'])){
    $post_id = $_POST['deletePostId'];
    $query = "DELETE FROM `posts` WHERE `posts`.`id` = $post_id"; 
    if(mysqli_query($db, $query)){
        echo "Post Deleted Successfully";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($db);
    }
}