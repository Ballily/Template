<?php
//database connection
$connect=mysqli_connect("localhost","user","pass","dbname");
if(mysqli_connect_errno()){
echo "Connection Fail".mysqli_connect_error();
}

  ?>
