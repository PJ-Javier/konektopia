<?php
include 'db.php';
include 'head.php';
include 'header.php';
include 'sidebar.php';
// if($_SESSION['loggedinuserrole']=="User") {
//     header('Location: ../index.php');
//     die();
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        body {
            background-image: url("public/images/hero_image2.jpg");
        }
    </style>
</head>

<body>
    <div id="layoutSidenav">
        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-4">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-auto mt-5">
                                    <h1 class="page-header-title">
                                        <div class="page-header-icon"><i data-feather="activity"></i></div>
                                        Update Profile
                                    </h1>
                                </div>
                            </div>
                        </div>
                </header>
                <main>
                    <div class="container-xl px-12 mt-12">
                        <div style="justify-content: center;margin-top: -120px" class="row">
                            <div class="col-xl-10">
                                <div class="card mb-5">
                                    <div class="card-header">Update Profile</div>
                                    <div class="card-body">
                                        <form>
                                            <?php
                                            $query = "SELECT * FROM users WHERE id = '" . $_SESSION['loggedinuserid'] . "'";
                                            $result = mysqli_query($db, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                                <div class="row gx-3">
                                                    <div class="col-md-6">
                                                        <input type="hidden" id="id" value="<?php echo $row['id']; ?>">
                                                        <div class="mb-3">
                                                            <label class="small mb-1" for="inputFullName">Name</label>
                                                            <input class="form-control" id="inputFullName" type="text" placeholder="Enter first name" value="<?php echo $row['full_name'] ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                            <input class="form-control" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" value="<?php echo $row['email'] ?>" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row gx-3">
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="small mb-1" for="inputPassword">Password</label>
                                                            <input class="form-control" id="inputPassword" type="text" placeholder="Enter password" value="<?php echo $row['password'] ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <a style="float: right;" class="btn btn-primary btn-block" href="#" onclick="UpdateAccount();">Update Account</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        <?php
        include 'footer.php';
        ?>
        </div>
    </div>
</body>

</html>
<script>
    function UpdateAccount() {

        var inputFullName = document.getElementById("inputFullName").value;
        var inputEmailAddress = document.getElementById("inputEmailAddress").value;
        var inputPassword = document.getElementById('inputPassword').value;
        var id = document.getElementById('id').value;

        if (inputFullName == "" || inputFullName == "0" || inputEmailAddress == "" || inputPassword == "") {
            alert("Please fill all the fields");
            return;
        }
        $.ajax({
            type: 'POST',
            url: 'registerUser.php',
            data: {
                inputFullName: inputFullName,
                inputEmailAddress: inputEmailAddress,
                inputPassword: inputPassword,
                id: id,
                action: "update"

            },
            success: function(res) {
                console.log(res);
                if (res == "Email Already exists, try another one") {
                    alert(res);
                    location.reload();

                } else if (res == "Successfully Updated") {
                    alert(res);
                    window.location.replace('index.php');

                } else {
                    alert("Something went wrong please try again")

                }
            }
        });

    }
</script>