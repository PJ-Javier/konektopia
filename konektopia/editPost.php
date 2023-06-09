<?php
include 'head.php';
include 'header.php';
include 'sidebar.php';
include 'db.php';
// check if user is logged in
if (!isset($_SESSION['loggedinuserid'])) {
    header("Location: index.php");
    exit();
}
$id = $_GET['id'];
?>
<?php
  if (isset($_POST['save'])) {
        $post_description = $_POST['post_description'];
        $tags = $_POST['tags'];
        $user_id = $_SESSION['loggedinuserid'];
        // check if user has uploaded any file
        if (empty($_FILES['files']['name'][0])) {
            // update post without image
            $query = "UPDATE `posts` SET `post_description` = '$post_description', `tags` = '$tags' WHERE `posts`.`id` = $id";
            if(mysqli_query($db, $query)){
                echo "<script>
                setTimeout(function() {
                    alert('Post Updated Successfully');
                    location.href = 'allPosts.php';
                }, 1000);
                </script>";
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($db);
                echo "<p style='color:red;text-align:center;margin: 10px 0;'>Can't Insert Item.</p>";
            }
       
        }else{
        $files = $_FILES['files'];
        $file_count = count($_FILES['files']['name']);
        $file_keys = array_keys($files);
        for ($i = 0; $i < $file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $files[$key][$i];
            }
        }
        foreach ($file_ary as $file) {
            // only image files allowed
            if($file['type'] != 'image/jpeg' && $file['type'] != 'image/png' && $file['type'] != 'image/jpg') { 
                echo "<script>
                setTimeout(function() {
                    alert('Only image files are allowed');
                    location.href = 'createPost.php';
                }, 1000);
                </script>";
                exit();
            }
            $file_name = $file['name'];
            $file_tmp = $file['tmp_name'];
            $file_ext = explode('.', $file_name);
            $file_ext = strtolower(end($file_ext));
            $randNumber = rand(1, 100000);
            $file_name_new =  $randNumber.'-'.$file_name ;
            $file_destination = 'uploads/' . $file_name_new;
            if (move_uploaded_file($file_tmp, $file_destination)) {
                // remove old image
                $query = "SELECT * FROM `posts` WHERE `id` = $id";
                $result = mysqli_query($db, $query);
                $row = mysqli_fetch_assoc($result);
                $old_image = $row['image'];
                unlink('uploads/' . $old_image);
                $query = "UPDATE `posts` SET `post_description` = '$post_description', `tags` = '$tags', `image` = '$file_name_new' WHERE `posts`.`id` = $id";
                if(mysqli_query($db, $query)){
                    echo "<script>
                    setTimeout(function() {
                        alert('Post Updated Successfully');
                        location.href = 'allPosts.php';
                    }, 1000);
                    </script>";
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($db);
                    echo "<p style='color:red;text-align:center;margin: 10px 0;'>Can't Insert Item.</p>";
                }
            }
        }
    }
}
?>
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
                                    Update Post
                                </h1>
                            </div>
                            <div class="col-12 col-xl-auto mt-5">
                                <div class="card mb-4"></div>
                            </div>
                        </div>
                    </div>
            </header>
            <main>
                <div class="container-xl px-12 mt-12">
                    <div style="justify-content: center;margin-top: -120px" class="row">
                        <div class="col-xl-10">
                            <div class="card mb-5">
                                <div class="card-header">Update Post</div>
                                <div class="card-body">
                                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" autocomplete="off"
                                        enctype="multipart/form-data">
                                        <?php
                                        if (isset($_GET['id'])) {
                                            $id = $_GET['id'];
                                            $query = "SELECT * FROM posts WHERE id = $id";
                                            $result = mysqli_query($db, $query);
                                            $row = mysqli_fetch_assoc($result);
                                        }
                                        ?>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-12">
                                                <label class="small mb-1" for="description">What's on your mind?</label>
                                                <textarea rows="4" cols="50" class="form-control" required
                                                    name="post_description" type="text"
                                                    placeholder="What's on your mind?"><?php echo $row['post_description']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-12">
                                                <label class="small mb-1" for="Image">Image</label>
                                                <input class="form-control"  name="files[]" type="file"
                                                    multiple />
                                            </div>
                                        </div>
                                        <div class="row gx-3 mb-3">
                                            <div class="col-md-12">
                                                <label class="small mb-1" for="description">Tags</label>
                                                <input class="form-control" required name="tags" type="text"
                                                    placeholder="Tags" value="<?php echo $row['tags']; ?>" />
                                            </div>
                                        </div>
                                        <input style="float:right" type="submit" class="btn btn-primary mt-5 "
                                            name="save" type="button" value="Update" />
                                        </div>
                                    </form>
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