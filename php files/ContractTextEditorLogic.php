<?php
session_start();
include "../db.php";
if($_COOKIE['contract_content'] != ''){
    $contract_content = $_COOKIE['contract_content'];
    $emails = preg_split ("/\,/", $_COOKIE['party_emails']);
    if(count($emails)!= 0 && $_COOKIE['party_emails'] != ''){
        $emails_userids = [];
        foreach ($emails as $email){
            $x = mysqli_real_escape_string($con, $email);
            $ar = [];
            array_push($ar,$x);
            $stmt = selectFromDataBase('UserID','user_emails',"Email = ? AND ActiveStatus='ACTIVE'",$con,'s',$ar);
            if($stmt->num_rows == 0){
                echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>ایمیل ".$email." در این سامانه ثبتنام نکرده است.</b>
                </div>";
                $stmt->close();
                exit();
                break;
            }else{
                $obj = $stmt->fetch_assoc();
                $userid = $obj['UserID'];
                $emails_userids[$email] = $userid;
            }
        }
        if(count($emails) == count($emails_userids)){
            $party_ids = implode(",", array_unique(array_values($emails_userids)));
            $copy_num = count($emails);
            $creator_id = $_SESSION['userid'];
            $contract_state = 'RECIEVE_EMAILS_PENDING';
            $ar_tmp= [];
            array_push($ar_tmp,$contract_content,$party_ids,$copy_num, $creator_id, $contract_state);
            $res = insert($con,'?,?,?,?,?', $ar_tmp, "ssiis",
            "contract_content, party_ids, copy_nums, creator_id, contract_state",'contract_info' );
        }
        //add row to contract_info table
        
    }else{
        echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>لطفا ایمیل طرف های قرارداد را وارد کنید.</b>
			</div>
		";
        exit();
    }
}else{
    echo "
			<div class='alert alert-warning'>
				<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>لطفا متن قرارداد را وارد کنید.</b>
			</div>
		";
    exit();
}
?>