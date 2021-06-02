<?php
session_start();
include "../db.php";
if (isset($_POST["fl_name"])) {
    $fl_name = mysqli_real_escape_string($con, $_POST["fl_name"]);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $citizenID= mysqli_real_escape_string($con, $_POST['citizen_id']);
    $password = $_POST['password'];
    $repassword = $_POST['re_password'];
    $mobile = mysqli_real_escape_string($con, $_POST['phone_number']);
    $name = "/([a-zA-Z ]+)|([\u0600-\u06FF\s]+)$/";
    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
    $number = "/^[0-9]+$/";
    $citizenidValidation = "/^[0-9]+$/";

    if(empty($fl_name) || empty($email) || empty($password) || empty($repassword) ||
        empty($mobile) || empty($citizenID)){

        echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>لطفا تمام قسمت‌ها را پر کنید..!</b>
			</div>
		";
        exit();
    } else {

        if(!preg_match($name,$fl_name)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>$fl_name معتبر نمی‌باشد..!</b>
			</div>
		";
            exit();
        }
        if(!preg_match($citizenidValidation,$citizenID) and strlen($citizenID) !=10){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b> $citizenID معتبر نمی‌باشد..!</b>
			</div>
		";
            exit();
        }
        if(!preg_match($emailValidation,$email)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b> $email معتبر نمی‌باشد..!</b>
			</div>
		";
            exit();
        }
        if(strlen($password) < 9 ){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>رمزعبور انتخاب شده ضعیف‌ است</b>
			</div>
		";
            exit();
        }
        if(strlen($repassword) < 6 ){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>رمزعبور انتخاب شده ضعیف‌ است</b>
			</div>
		";
            exit();
        }
        if($password != $repassword){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>رمزعبور یکسان نمی‌باشد</b>
			</div>
		";
        }
        if(!preg_match($number,$mobile)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>شماره تماس $mobile معتبر نمی‌باشد</b>
			</div>
		";
            exit();
        }
        if(!(strlen($mobile) == 11)){
            echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>شماره تماس شامل ۱۱ عدد می‌شود</b>
			</div>
		";
            exit();
        }
        //existing email address in our database
        $ar = [];
        array_push($ar,$email);
        $stmt = selectFromDataBase('ID','user_emails',"Email = ? AND ActiveStatus='ACTIVE'",$con,'s',$ar);
        if($stmt->num_rows > 0){
            echo "
			<div class='alert alert-danger'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				<b>قبلا  با این آدرس ایمیل ثبت نام صورت گرفته است</b>
			</div>
		";
            $stmt->close();
            exit();
        } else {
            $stmt->close();
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            $ar_tmp= [];
            array_push($ar_tmp,$fl_name,$mobile,$citizenID,$pass_hash);
            $res = insert($con,'?,?,?,?', $ar_tmp, "ssss",
                "Name, Phone_Number, CitizenID,Password",'user' );


            if($res) {
                $id = mysqli_insert_id($con);
                $ar_tmp= [];
                array_push($ar_tmp,$id,$email,'ACTIVE');
                insert($con, "?,?,?",$ar_tmp, "sss",
                    "UserID, Email, ActiveStatus", 'user_emails');

                $_SESSION["userid"] = $id;
                $_SESSION["name"] = $fl_name;
                $_SESSION['loggedin'] = TRUE;
                $ip_add = getenv("REMOTE_ADDR");
                $_SESSION['ip'] = $ip_add;
                $_SESSION['time'] = time();
                $ip_add = getenv("REMOTE_ADDR");
                if (mysqli_insert_id($con) !== false) {
                    echo "<script> location.href='MainPage.php'; </script>";
                    exit;
                }

            }
        }
    }

}



?>