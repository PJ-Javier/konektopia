<?php
//error_reporting(1);

include "head.php";
include "header.php";
include "sidebar.php";
include "db.php";
// check if user is logged in
if (!isset($_SESSION['loggedinuserid'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['loggedinuserid'];

if (isset($_POST['submit'])) {

    // check if file more than 20 in project_files table
    $query = "SELECT * FROM `project_files` WHERE `project_id` = $project_id";
    $result = mysqli_query($db, $query);
    $count = mysqli_num_rows($result);
    if ($count >= 20) {
        header("Location: viewProject.php?id={$project_id_ecrypted}&errorMessage=You can not upload more than 20 files in a project");
        exit();
    }
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['file']['name'])));
    $extensions = array("pdf");
    if (in_array($file_ext, $extensions) === false) {
        header("Location: viewProject.php?id=$project_id_ecrypted&errorMessage=Only pdf files are allowed");
        exit();
    }
    // $name = $_POST['file_name'];
    $description = $_POST['description'];
    $user_id = $_SESSION['loggedinuserid'];
    $project_id = $_POST['project_id'];
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $randNumber = rand(1, 100000);
    $file_name_new = $randNumber . "-" . $file_name;
    $file_destination = 'uploads/' . $file_name_new;
    if (move_uploaded_file($file_tmp, $file_destination)) {
        $query = "INSERT INTO `project_files` (`project_id`, `file_name`, `description`, `file_path`) 
        VALUES ($project_id, '$file_name', '$description','$file_name_new')";

        $execute = mysqli_query($db, $query);
        if ($execute) {
            // show message in modal
            $sucess_message = "File uploaded successfully";
        } else {
            // show message in modal
            $error_message = "Error: " . $query . "<br>" . mysqli_error($db);
        }
    }
}
?>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4 " style="margin-top: 50px;">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="activity"></i></div>
                                    Home
                                </h1>
                            </div>
                            <div class="col-12 col-xl-auto mt-4">
                                <!-- show all posts -->
                                <div class="card mb-4"> </div>
                            </div>
                        </div>
                    </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-n10">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12 mb-4">
                        <!-- <div class="card h-100"> -->
                            <div class="card-body h-100 p-5">
                                <div class="row align-items-center">
                                    <div class="col-xl-8 col-xxl-8">
                                        <div class="text-start text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">

                                        </div>
                                    </div>
                                    <div class="card-body custom-card bg-light ">
                                        <div class="row ">
                                            <!-- show all posts -->
                                            <?php
                                            function time_elapsed_string($datetime) {
                                                $seconds_ago = (time() - strtotime($datetime));

                                                if ($seconds_ago >= 31536000) {
                                                    echo intval($seconds_ago / 31536000) . " years ago";
                                                } elseif ($seconds_ago >= 2419200) {
                                                    echo  intval($seconds_ago / 2419200) . " months ago";
                                                } elseif ($seconds_ago >= 86400) {
                                                    echo  intval($seconds_ago / 86400) . " days ago";
                                                } elseif ($seconds_ago >= 3600) {
                                                    echo  intval($seconds_ago / 3600) . " hours ago";
                                                } elseif ($seconds_ago >= 60) {
                                                    echo  intval($seconds_ago / 60) . " minutes ago";
                                                } else {
                                                    echo "Just now";
                                                }
                                            }
                                            $query = "SELECT * FROM `posts` ";
                                            $result = mysqli_query($db, $query);
                                            if(mysqli_num_rows($result) > 0){
                                              while($row = mysqli_fetch_assoc($result)){
                                                // get created by user details
                                                $post_id = $row['id'];
                                                $created_by = $row['created_by'];
                                                $query = "SELECT * FROM `users` WHERE `id` = $created_by";
                                                $result1 = mysqli_query($db, $query);
                                                $row1 = mysqli_fetch_assoc($result1);
                                                $created_by_name = $row1['full_name'];
                                                // date time format
                                                $dateTime = date($row['created_at'], 1541843467);
                                                // $created_by_profile_pic = $row1['profile_pic'];

                                                ?>
                                            <div class="col-sm-10" style="margin-left: 9%;">
                                                <div class="post-block">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex mb-3">
                                                            <div class="mr-2">
                                                                <a href="javascript:void(0)" class="text-dark"><img src="public/images/user-image.png" alt="User" class="author-img"></a>
                                                            </div>
                                                            <div>
                                                            <h5 class="mb-0"><a href="javascript:void(0)" class="text-dark"><?php echo $created_by_name; ?></a></h5>
                                                                <p class="mb-0 text-muted"><small><?php echo time_elapsed_string($dateTime); ?></small></p>
                                                            </div>
                                                        </div>
                                                         <!-- check if user_id and  create_by id matched -->
                                                         <?php if($user_id == $created_by){ ?>
                                                        <div class="post-block__user-options">
                                                            <a href="javascript:void(0)" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                             
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
                                                              
                                                                <a class="dropdown-item text-dark" href="editPost.php?id=<?php echo $row['id']?>">Edit</a>
                                                                <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deletePost(this)" data-post-id="<?php echo $row['id']?>">Delete</a>
                                                              
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="post-block__content mb-2">
                                                        <p><?php echo $row['post_description']; ?></p>
                                                        <!-- post tags -->
                                                      
                                                        <a style="margin-bottom:10px"href="javascript:void(0)"><?php echo $row['tags']; ?></a>
                                                        <br>
                                                        <img src="uploads/<?php echo $row['image']; ?>" alt="post-image"style="width: 100%;!important" class="img-fluid rounded" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="d-flex justify-content-between mb-2">
                                                            <div class="d-flex">
                                                                <!-- make heart red if it has any like  -->

                                                                <a href="javascript:void(0)" class="text-danger mr-2" onclick="likePost(this)" data-post-id="<?php echo $row['id']?>"><span><i  class="fa fa-heart"></i></span></a>
                                                            </div>
                                                            <a href="javascript:void(0)" class="text-dark mr-2" onclick="showCommentsSection(this)"><span>Comment</span></a>
                                                        </div>
                                                        <!-- get liked by -->
                                                        <?php
                                                        // count likes
                                                        $query = "SELECT * FROM `likes` WHERE `post_id` = $post_id";
                                                        $result2 = mysqli_query($db, $query);
                                                        $likes_count = mysqli_num_rows($result2);
                                                        
                                                        // inner join on likes and users table
                                                        $query = "SELECT * FROM `likes` INNER JOIN `users` ON `likes`.`user_id` = `users`.`id` WHERE `likes`.`post_id` = $post_id limit 1";
                                                        $result2 = mysqli_query($db, $query);
                                                        if(mysqli_num_rows($result2)>0){
                                                            $liked_by = "";
                                                            while($row2 = mysqli_fetch_assoc($result2)){
                                                                $liked_by .= $row2['full_name'].", ";
                                                            }
                                                            $liked_by = rtrim($liked_by, ", ");
                                                            ?>
                                                            <p class="mb-0">Liked by <a href="javascript:void(0)" class="text-muted font-weight-bold"><?php echo $liked_by; ?></a> and <a href="javascript:void(0)" class="text-muted font-weight-bold"><?php echo $likes_count; ?> others</a></p>

                                                        <?php   
                                                        }else{
                                                            $liked_by = "No likes yet";
                                                            ?>

                                                            <p class="mb-0"><?php echo $liked_by; ?></p>
                                                       <?php
                                                        }
                                                       ?>

                                                    </div>
                                                    <hr>
                                                    <div class="post-block__comments d-none">
                                                        <!-- Comment Input -->
                                                        <div class="input-group mb-3">
                                                            <input type="text" id="comment" class="form-control" placeholder="Add your comment">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button" id="button-addon2" onclick="addComment(this)" data-comment-add-id="<?php echo $row['id'];?>"><i class="fa fa-paper-plane"></i></button>
                                                            </div>
                                                        </div>
                                                        <!-- Comment content -->
                                                        <!-- show all comments -->
                                                        <?php
                                                        $query = "SELECT * FROM `comments` WHERE `post_id` = $post_id";
                                                        $result2 = mysqli_query($db, $query);
                                                        if(mysqli_num_rows($result2) >0){
                                                          while($row2 = mysqli_fetch_assoc($result2)){
                                                            $commented_by = $row2['added_by'];
                                                            $query = "SELECT * FROM `users` WHERE `id` = $commented_by";
                                                            $result3 = mysqli_query($db, $query);
                                                            $row3 = mysqli_fetch_assoc($result3);
                                                            $commented_by_name = $row3['full_name'];
                                                            $create_at = time_elapsed_string($row2['created_at']);
                                                            ?>

                                                        <div class="comment-view-box mb-3">
                                                            <div class="d-flex mb-2">
                                                                <img src="public/images/user-image.png" alt="User img" class="author-img author-img--small mr-2">
                                                                <div>
                                                                    <h6 class="mb-1"><a href="javascript:void(0)" class="text-dark"><?php echo $commented_by_name ?></a> <small class="text-muted"><?php echo $create_at?></small></h6>
                                                                    <p class="mb-1"><?php echo $row2['comment']; ?></p>
                                                                    <!-- check if post have logged in user comment -->
                                                                    <?php
                                                                    if($commented_by == $_SESSION['loggedinuserid']){
                                                                        ?>
                                                                    <div class="d-flex">
                                                                        <a href="javascript:void(0)" class="text-dark mr-2" style="font-size: 13px;" onclick="showCommentBox(this)">Edit</a>
                                                                        <a href="javascript:void(0)" class="text-dark mr-2" style="font-size: 13px;" onclick="deleteComment(this)" data-comment-id="<?php echo $row2['id'];?>">Delete</a>

                                                                    </div>
                                                                    <!-- update comment input -->
                                                                    <div class="input-group mb-3" style="display: none;">
                                                                        <input type="text" id="edit_comment" class="form-control" placeholder="Add your comment">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-primary" type="button" id="button-addon2" onclick="editComment(this)" data-comment-edit-id="<?php echo $row2['id'];?>"><i class="fa fa-paper-plane"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                          }
                                                        }else{
                                                            ?>
                                                            <!-- no comment found section-->
                                                            <div class="comment-view-box mb-3">
                                                            <div class="d-flex mb-2">
                                                                    <p class="mb-1">No comments found</p>
                                                            </div>
                                                        </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <!-- More Comments -->
                                                        <hr>
                                                        <!-- <a href="javascript:void(0)" class="text-dark">View More comments <span class="font-weight-bold">(12)</span></a> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                              }
                                            }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- </div> -->
                        </div>
                    </div>
                </div>
        </main>
        <?php include "footer.php"; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>

<script>
    function addComment(e) {
        var comment = $(e).parent().parent().find('#comment').val();
        var postId = $(e).attr('data-comment-add-id');
        //alert(comment);
        $.ajax({
            url: 'comments.php',
            type: 'POST',
            data: {
                comment: comment,
                postId: postId
            },
            success: function(response) {
                if (response) {
                    alert(response);
                    $('#comment').val('');
                    location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
    function showCommentBox(e){
        // show comment box
        $(e).parent().parent().parent().parent().find('.input-group').show();

    }
    function editComment(e) {
        var commentId = $(e).attr('data-comment-edit-id');
        var comment = $(e).parent().parent().find('#edit_comment').val();
        $.ajax({
            url: 'comments.php',
            type: 'POST',
            data: {
                updateComment: comment,
                commentId: commentId
            },
            success: function(response) {
                if (response) {
                    alert(response);
                    $('#edit_comment').val('');
                    location.reload();
                } else {
                    alert('Error occured while adding comment');
                }
            }
        });
    }

    function showCommentsSection(e){
        $(e).parent().parent().parent().parent().find('.post-block__comments').toggleClass('d-none');
    }
    function likePost(e){
        var postId = $(e).attr('data-post-id');
        // change heart color
        var heart = $(e).find('i').toggleClass('text-danger');
        
console.log(heart)
        $.ajax({
            url: 'comments.php',
            type: 'POST',
            data: {
                likedPostId: postId
            },
            success: function(response) {
                if (response) {
                    alert(response);
                    location.reload();
                } else {
                    alert('Error occured while adding comment');
                }
            }
        });
    }
    function deleteComment(e){
        var commentId = $(e).attr('data-comment-id');
        $.ajax({
            url: 'comments.php',
            type: 'POST',
            data: {
                deleteCommentId: commentId
            },
            success: function(response) {
                if (response) {
                    alert(response);
                    location.reload();
                } else {
                    alert('Error occured while adding comment');
                }
            }
        });
    }
    function deletePost(e){
        // confirm delete
        var r = confirm("Are you sure you want to delete this post?");
        if (r == false) {
            return false;
        }
        var postId = $(e).attr('data-post-id');
        $.ajax({
            url: 'functions.php',
            type: 'POST',
            data: {
                deletePostId: postId
            },
            success: function(response) {
                if (response) {
                    alert(response);
                    location.reload();
                } else {
                    alert('Error occured while adding comment');
                }
            }
        });
    }
</script>