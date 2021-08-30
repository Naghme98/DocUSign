<?php

require_once realpath(__DIR__ . '/DotEnv.php');
(new DotEnv(__DIR__ .'/.env'))->load();
$servername = getenv('DB_ADDRESS');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$db = getenv('DB_NAME');

//create connection
$con = new mysqli($servername,$username,$password,$db);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
//echo "Connected successfully";
function selectFromDataBase($columns, $table , $condition,$con,$types,$data){

    $quary = "SELECT ".$columns ." FROM ". $table. " WHERE ". $condition;
    $temp = $con->prepare($quary);
    $temp->bind_param($types,...$data);
    $temp->execute();
    $res = $temp->get_result();
    return $res;
}
function updateDatabase($conn,$data,$table_name,$conditions){
    $q = "UPDATE ".$table_name." SET ".$data." WHERE ".$conditions;

    if($conn->query($q) === TRUE){
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

}

function insert($conn,$data_place,$data,$types,$columnNames,$table_name){
    $q = "INSERT INTO ".$table_name. " (" . $columnNames. " ) VALUES (".$data_place .")";
//    echo "<br>".$q."<br>";
    $stmt = $conn->prepare($q);
    if(!$stmt){
        echo "Error: " . $q . "<br>" . $conn->error;
        return false;
    }
    $stmt->bind_param($types,...$data);
    $stmt->execute();
    if($stmt) {
        print_r($stmt);
        $stmt->close();
        return true;
    }
    else{
        echo 'insert error';
        return false;
    }
}

$q1 = 'SELECT MAX(MaddeNo) as number From contract_template WHERE TemplateID= \'TEMP_1\' ';
$q2 = 'SELECT MAX(BandNo) as number From contract_template WHERE TemplateID= \'TEMP_1\' AND MaddeNo=';
$q3 = 'SELECT Content FROM contract_template WHERE TemplateID=\'TEMP_1\' AND Part=\'M-TITLE\'';
$q4 = 'SELECT Content, ContentNum, FieldType,FieldStatus FROM contract_template WHERE TemplateID=\'TEMP_1\' 
        AND Part=\'B\' AND BandNo=? AND MaddeNo=? ORDER BY ContentNum ASC ';
$q5 = 'SELECT Content, FieldType,FieldStatus,TabsareNo,MaddeNo,BandNo FROM contract_template 
    WHERE TemplateID=\'TEMP_1\' AND Part=\'T\' ORDER BY ContentNum ASC';
$q6= 'SELECT MAX(ID) as number From contract';
?>
