<?php
include "../db.php";
if(isset($_POST["email-confirm"]) && isset($_POST["password-confirm"])) {
    $email = mysqli_real_escape_string($con, $_POST["email-confirm"]);
    $password = $_POST["password"];
    $ar = [];
    array_push($ar, $email);
    $stmt = selectFromDataBase('UserID', 'user_emails', 'email=?', $con, 's', $ar);
    if ($stmt->num_rows == 1) {
        $id = $stmt->fetch_assoc();
//        // Account exists, now we verify the password.
        $id = $id['UserID'];
        $ar = [];
        array_push($ar, $id);
        $stmt = selectFromDataBase('Name,Password', 'user', 'ID=?', $con, 's', $ar);
        $count = $stmt->num_rows;
        if ($count == 1) {
            $user_info = $stmt->fetch_assoc();
            if (password_verify($_POST['password-confirm'], $user_info['Password'])) {
                $_SESSION['time'] = time();
                echo "confirm_success";
            }
        }

    }
}