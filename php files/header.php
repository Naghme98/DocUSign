<?php 
session_start();
if($_SESSION['loggedin']){
    include "../html files/headerAfterLogin.html";
}
else{
    include "../html files/Header.html";
}
?>