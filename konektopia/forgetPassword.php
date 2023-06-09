<?php
include "db.php";
include "head.php";
?>
<?php
if(isset($_SESSION['loggedinuserid'])){
 header("location: allProjects.php");
}
if (isset($_POST['loginAttempt'])) {
   
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = mysqli_real_escape_string($db, $_POST['inputEmailAddress']);
        $password = mysqli_real_escape_string($db, $_POST['inputPassword']);
        $sql = "SELECT * FROM users WHERE  email = '$email' AND password = '$password'";
        $result = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            if($row['status']!="Active"){
                echo "<script>
                setTimeout(function() {
                    alert('You are not active, please contact admin');
                    location.href = 'index.php';
                }, 1000);
                </script>";
               
                exit();
            }
                $userrole =  $row['role'];
                $_SESSION['loggedinusername']= $row['full_name'];
                $_SESSION['loggedinuseremail'] = $email;
                $_SESSION['loggedinuserid'] = $row['id'];
                $_SESSION['loggedinuserrole'] = $userrole;
              

               if($userrole=='Admin'){
                   header("location: admin/index.php");
                }elseif(($userrole=='User'|| $userrole=='' || $userrole==null)){
                    header("location: allProjects.php");
                }
            }else{
                echo "<script>
                setTimeout(function() {
                    alert('Wrong email or password');
                    location.href = 'index.php';

                }, 1000);
                </script>";
               
                exit();
            }
        }
    } 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    body {
        background-image: url("public/images/hero_image2.jpg");
    }
    </style>
    <?php
   
    include 'header.php';
    ?>
</head>
<body>
    <div class="d-flex flex-column h-100">
        <main>
            <div class="container-xl px-4" style="margin-top: 50px;">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg" style="margin-top: 100px;">
                            <div class="card-header justify-content-center">
                                <h3 class="fw-light my-4">Reset Password</h3>
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <div class="mb-3 email_section">
                                        <label class="small mb-1" for="inputEmailAddress">Email
                                            Address</label>
                                        <input class="form-control" id="inputEmailAddress" type="email"
                                            placeholder="Enter email address" />
                                    </div>
                                    <div class="mb-3 password_section">
                                        <label class="small mb-1" for="inputPassword">Password </label>
                                        <input class="form-control" id="inputPassword" type="password"
                                            placeholder="Enter password" />
                                    </div>
                                    <div class="mb-3 password_section">
                                        <label class="small mb-1" for="inputPassword">Confirm Password </label>
                                        <input class="form-control" id="inputConfirmPassword" type="password"
                                            placeholder="Enter confirm password" />
                                    </div>
                                    <div style="float: right;"
                                        class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button  class="btn btn-primary" type="button" onclick="checkEmail()">Reset Password</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center">
                                <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
<script>
function checkEmail() {
    // check if password section is visible
    if ($(".password_section").is(":visible")) {
        // check if password and confirm password are same
        var password = document.getElementById("inputPassword").value;
        var confirmPassword = document.getElementById("inputConfirmPassword").value;
        if (password != confirmPassword) {
            alert("Password and confirm password are not same");
            return false;
        } else {
            // update password
            var email = document.getElementById("inputEmailAddress").value;
            $.ajax({
                type: "POST",
                url: "functions.php",
                data: {
                    updatePassword: true,
                    email: email,
                    password: password
                },
                success: function(data) {
                    if (data == "success") {
                        alert("Password updated successfully");
                        location.href = 'index.php';
                    } else {
                        alert("Something went wrong");
                    }
                }
            });
        }
    }else{
        // check email
        checkEmailExists();
    }
   
}

function checkEmailExists(){
    var email = document.getElementById("inputEmailAddress").value;
    if (email == "") {
        alert("Please enter email");
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: "functions.php",
            data: {
                checkEmailExists: true,
                email: email
            },
            success: function(data) {
                if (data == "success") {
                    // hide email section
                    $(".email_section").hide();
                    // show password section
                    $(".password_section").show();
                    
                    // location.href = 'index.php';
                } else {
                    alert("Email not found");
                }
            }
        });
    }
}
</script>