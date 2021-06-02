<?php
include "../db.php";
if(isset($_POST['email'])) {
    $q1 = "SELECT ID FROM user WHERE Email = ?";
    $q2 = "SELECT ID FROM private_key WHERE UserID = ? AND ActiveStatus='ACTIVE' ";
    $q3 = "SELECT ID FROM public_key WHERE UserID = ? AND ActiveStatus='ACTIVE' ";

    $user_id = $con->prepare($q1);
    $user_id->bind_param("s", mysqli_real_escape_string($con, $_POST['email']));
//$user_id->bind_param("s", mysqli_real_escape_string($con,'mohammadifar.naghme@gmail.com'));
    $user_id->execute();
    $user_id->store_result();

    if ($user_id->num_rows == 1) {
        $user_id->bind_result($id);
        $user_id->fetch();
        $p_key = $con->prepare($q2);
        $p_key->bind_param('s', $id);
        $p_key->execute();
        $p_key->store_result();
        if ($p_key->num_rows > 0) {
            $p_key->bind_result($pr_id);
            $p_key->fetch();
            updateDatabase($con, "ActiveStatus = 'INACTIVE' ", 'private_key', ("ID=" . $pr_id));
            $p_key = $con->prepare($q3);
            $p_key->bind_param('s', $id);
            $p_key->execute();
            $p_key->store_result();
            $p_key->bind_result($pr_id);
            $p_key->fetch();
            updateDatabase($con, "ActiveStatus = 'INACTIVE'", 'public_key', ("ID=" . $pr_id));
        }
        $private = privateKey();
        insert($con, "'" . $id . "','ACTIVE' ,'" . $private[1] . "'", "UserID,ActiveStatus,PrKey", 'private_key');
        insert($con, "'" . $id . "','ACTIVE' ,'" . publicKey($private[0]) . "'", "UserID,ActiveStatus,PuKey", 'public_key');
    } else {
        echo "Error";
    }
}

function privateKey(){
    $config = array(
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA);
    $res =openssl_pkey_new($config);
    openssl_pkey_export($res, $privKey);

    return array($res, $privKey);
}
function publicKey($private_key){
    $public_key_pem = openssl_pkey_get_details($private_key)['key'];
//    return openssl_pkey_get_public($public_key_pem);
    return $public_key_pem;
}

