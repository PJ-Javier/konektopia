<?php
define('DB_SERVER', 'localhost');
if ($_SERVER['SERVER_NAME'] == '') {
   define('DB_USERNAME', '');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', '');	
}else{
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'social_media_clone');	
}

//echo "<script>console.log('database name: " . DB_DATABASE . "' );</script>";
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>
