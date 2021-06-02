<?php

include "../db.php";
    session_start();
if(isset($_POST["email"]) && isset($_POST["password"])){

    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $password = $_POST["password"];
    $ar = [];
    array_push($ar,$email);
    $stmt = selectFromDataBase('UserID','user_emails','email=?',$con,'s' ,$ar);
    if($stmt->num_rows == 1) {
        $id = $stmt->fetch_assoc();
//        // Account exists, now we verify the password.
        $id = $id['UserID'];
        $ar = [];
        array_push($ar, $id);
        $stmt = selectFromDataBase('Name,Password', 'user', 'ID=?', $con, 's', $ar);
        $count = $stmt->num_rows;
        if ($count == 1) {
            $user_info = $stmt->fetch_assoc();
            if (password_verify($_POST['password'], $user_info['Password'])) {
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $user_info['Name'];
                $_SESSION['userid'] = $id;
                $ip_add = getenv("REMOTE_ADDR");
                $_SESSION['ip'] = $ip_add;
                $_SESSION['time'] = time();
//            echo 'Welcome ' . $_SESSION['name'].'!';
                echo "login_success";
                echo "<script> location.href='../php files/MainPage.php'; </script>";

            }
        }
    }
    echo "<script> location.href='../php files/Login.php'; </script>";

}
?>