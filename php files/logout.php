<?php
session_start();
include "./header.php";
if(!$_SESSION['loggedin']){
    echo "<script> location.href='../php files/Login.php'; </script>";
}
session_unset();
session_destroy();
echo "<script> location.href='../php files/MainPage.php'; </script>";
?>