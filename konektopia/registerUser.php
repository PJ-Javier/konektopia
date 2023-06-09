<?php
include('db.php');
 if($_POST['action']=="registerUser"){
    $user_data = "SELECT * FROM users WHERE  email = '".$_POST['inputEmailAddress']."'";
            $u_data = mysqli_query($db, $user_data);
            $count_user = mysqli_num_rows($u_data);
            if ($count_user == 1) {
                echo"Email already exists, try another one.";
                die;
            }
		$insert_user2="insert into users(full_name,email,password) VALUE 
        ('".$_POST['inputFullName']."','".$_POST['inputEmailAddress']."','".$_POST['inputPassword']."')";
				  if(mysqli_query($db,$insert_user2))
				  {
					  echo "Successfully Registered";
				  }else{
                      echo "Error: " . $insert_user2 . "<br>" . mysqli_error($db);
                  }
 }elseif($_POST['action']=="update"){
    $update_user="update users set full_name='".$_POST['inputFullName']."',email='".$_POST['inputEmailAddress']."',password='".$_POST['inputPassword']."' where id='".$_POST['id']."'";
    if(mysqli_query($db,$update_user))
    {
        echo "Successfully Updated";
    }else{
        echo "Error: " . $update_user . "<br>" . mysqli_error($db);
    }
}
?>