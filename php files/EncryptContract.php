<?php
session_start();
include "../db.php";
if(!$_SESSION['loggedin']){
    echo "<script> location.href='../php files/Login.php'; </script>";
}
//if(isset($_POST['contract-data']) and isset($_POST['contract-password'])){
//    $contract_data = json_decode($_POST['contract-data'], true);
//    $contract_copies =mysqli_real_escape_string($con,$_POST['contract-copy-num']);
//    $contract_budget = mysqli_real_escape_string($con,$_POST['contract-budget']);
//    $contract_end_date = mysqli_real_escape_string($con,$_POST['contract-end-date']);
//    $contract_start_date = mysqli_real_escape_string($con,$_POST['contract-start-date']);
//    $contract_password = mysqli_real_escape_string($con,$_POST['contract-password']);
//    $contract_subject = mysqli_real_escape_string($con,$_POST['contract-subject']);
////    var_dump($contract_data["bandParts"]);
////    var_dump($contract_data);
//    $contract_parties = array();
//    $user_email = mysqli_real_escape_string($con,$_SESSION['email']);
//    for($i =1 ; ; $i++){
//        if(isset($_POST[('contract-party-'.$i)]))
//            $contract_parties = array_push($contract_parties, mysqli_real_escape_string($con, ('contract-party-' . $i)));
//        else if(!isset($_POST[('contract-party-'.($i+1))])) {
//            break;
//        }
//    }
    $user_id = selectFromDataBase('ID','user'," Email = '".$user_email."'",$con,'ID');
//    $public_key = selectFromDataBase('PuKey','public_key',"UserID = '".$user_id. "' AND ActiveStatus = 'ACTIVE' ",$con,'PuKey');
    $private_key = selectFromDataBase('PrKey','private_key',"UserID = '".$user_id. "' AND ActiveStatus = 'ACTIVE' ",$con, 'PrKey');
    openssl_public_encrypt($contract_password, $encrypted, $public_key);
    $base64 = base64_encode($encrypted);
    $contract_id = selectFromDataBase('MAX(ID) as md','contract','1=1',$con,'md');
    $c_id = (substr($contract_id,strpos($contract_id,'_')+1)+1);
//    $c_id = 1;
    $data = " 'CON_".$c_id."', '$contract_subject', '$contract_budget', '3', '$contract_copies', '$contract_start_date', '$contract_end_date', '"
        .count($contract_data['maddeTitles'])."', '$user_id', '$base64', 'SIGN_PENDING'";
    $column_names = "ID, ContractSubject, Budget, PageNums, CopyNums, StartDate, EndDate, MaddeNums, CreatorID, KeyUsedToSign, State";
////    var_dump(count($contract_data['bandParts']));
//    insert($con,$data,$column_names,'contract');
////    $selected = selectFromDataBase('KeyUsedToSign','contract'," ID = 'CON_1'",$con,'KeyUsedToSign');
//    set_madde($c_id,$con,$contract_data['maddeTitles']);
////    var_dump($contract_data['bandInfo']);
//    set_band($c_id,$con,$contract_data['bandParts'],$contract_data['bandInfo']);
//    echo "<script> location.href='../php files/MainPage.php'; </script>";
////    $iid = base64_decode($selected);
////    openssl_private_decrypt($iid,$dec, $private_key);
//
//}
//
//function set_madde($c_id,$con,$titles){
//    $madde_id = selectFromDataBase('MAX(ID) as md','contract_madde',"ContractID = 'CON_".$c_id."'",$con,'md');
//    $m_id = (substr($madde_id, strpos($madde_id, '_') + 1) + 1);
//    var_dump($madde_id);
//    for($i=0 ; $i<count($titles) ; $i++) {
//        $data = " 'MAD_" . ($m_id+$i) . "', 'CON_".$c_id."' , '$titles[$i]', '".($i+1)."', 'ACTIVE'";
//        $column_names = "ID , ContractID, MaddeTitle, MaddeNum, ActiveStatus";
//        insert($con,$data,$column_names,'contract_madde');
//    }
//}
//
//function set_band($c_id,$con,$bands,$band_info){
//    $madde_id = selectFromDataBase('MIN(ID) as md','contract_madde',"ContractID = 'CON_".$c_id."'",$con,'md');
//    $m_id = (substr($madde_id, strpos($madde_id, '_') + 1));
//    $b_counter = 0;
//    var_dump($madde_id);
//    for($i=0 ; $i<count($band_info) ; $i++){
//        for($j=0 ; $j<$band_info[$i] ; $j++){
//            $data = "'BAND_".($b_counter+1)."', 'MAD_" . ($m_id) . "', 'CON_".$c_id."' ,'".($b_counter+1)."','$bands[$b_counter]', 'ACTIVE'";
//            $column_names = "ID ,MaddeID ,ContractID, BandNum, Content, ActiveStatus";
//            insert($con,$data,$column_names,'contract_band');
//            $b_counter++;
//        }
//        $m_id++;
//    }
//}
//
//function set_tabsare(){
//
//}
//
//function set_parties(){
//
//}

//if (isset($_POST['checked'])){
    $cont_num = $con->query($q6);
    if ($cont_num->num_rows > 0) {
        $cont_num = explode("_",$cont_num->fetch_assoc()["number"])[1]+1;
    } else {
        $cont_num = '1';
    }
    $copy_num = mysqli_real_escape_string($con,$_POST['contract-copy-num']);
    $pass = mysqli_real_escape_string($con,$_POST['contract-password']);
    $result = $con->query($q1);
    $maddeNumber = $result->fetch_assoc()["number"];
    $bud ='';$start='';$end ='';$subj = '';$page_num = '1';
    $state = 'SIGN_PENDING';
//    we need email of parties to be set in table with unique keys

    foreach ($_POST as $key=>$value){
        if(strpos($key,'BUDGET')!== false)
            $bud  = mysqli_real_escape_string($con,$value);
        else if(strpos($key,'START_DATE')!== false)
            $start = mysqli_real_escape_string($con,$value);
        else if(strpos($key,'END_DATE')!== false)
            $end = mysqli_real_escape_string($con,$value);
        else if (strpos($key , 'CONT_SUB')!== false)
            $subj = mysqli_real_escape_string($con,$value);

    }
    $cont_num = 'CONT_'.$cont_num;
    $ar = [];
    array_push($ar,$cont_num,$subj,$bud,$page_num,$copy_num,$start,$end,$maddeNumber
        ,$_SESSION['userid'],$pass,$state,$_SESSION['contract']);
    $stmt = insert($con,"?,?,?,?,?,?,?,?,?,?,?,?",$ar,'ssdiissiisss',
        'ID, ContractSubject, Budget, PageNums, CopyNums, StartDate, EndDate,
            MaddeNums, CreatorID, KeyUsedToSign, State, TemplateID','contract');
    if(!$stmt){
        echo "Error";
    }
    else{
        $success = true;
        foreach ($_POST as $key=>$value){
            echo "ps: ".$key." : ".strpos($key,"input")." :"."<br>";
            if(strpos($key,"input") !==false ) {
                $ar = [];
                array_push($ar, $key, $cont_num, $value, 'ACTIVE');
                $stmt = insert($con, '?,?,?,?', $ar, 'ssss', 'ItemID,ContractID,Content,ActiveStatus', 'template_contract_items');
                if (!$stmt) {
                    echo "Error2";
                    $success = false;
                }
            }
        }
        if($success){
            echo "<script> location.href='../php files/MainPage.php'; </script>";
        }

    }
