<?php
session_start();
include "../html files/Header.html";
include "../db.php";

if(!$_SESSION['loggedin']){
    echo "<script> location.href='../php files/Login.php'; </script>";
}
$_SESSION['contract'] = 'TEMP_1';
$result = $con->query($q1);
$maddeTitles = $con->query($q3);
$bandParts = $con->prepare($q4);
$tabsareParts = $con->prepare($q5);
$tabsareParts->execute();
$tabsare = $tabsareParts->get_result();
$each_part_tabsare = $tabsare->fetch_assoc();
$prepared_data = null;
if ($result->num_rows > 0) {
    $maddeNumber = $result->fetch_assoc()["number"];
} else {
    $maddeNumber = 0;
}

?>

<script src="../javascript%20files/string-util.js"></script>
<script src="../javascript%20files/scripts.js"></script>

<div class="container" style="text-align: right">
    <div id="main-container" style="direction: rtl; padding-top: 20px">
        <form action="ConfirmContract.php" method="POST">
        <div id="contract_content">

            <?php
            for ($i = 1; $i <= $maddeNumber; $i++) {
                $bandNumber = $con->query($q2 . $i)->fetch_assoc()["number"];
                ?>
                <div id="m_title_<?= $i ?>" class="text-default form-box d-flex flex-column" style="padding-left: 40px">
                    <div class="d-flex flex-row" style="padding-bottom: 5px">
                        <h6 class="text-bold">
                            <script>document.write(toPersianNumber(<?=$i?>) + ".")</script>
                            <span class="madde_title">
                                <?= $maddeTitles->fetch_assoc()['Content'] ?>
                            </span>
                        </h6>
                    </div>

                    <div class="d-flex flex-row" style="line-height: 2.4">
                        <div class="d-flex flex-column">
                            <?php
                            for ($j = 1; $j <= $bandNumber; $j++) {
                                echo "<div class='form-inline' style='display: inline-block; position: relative;'>";

                                if ($bandNumber > 1) {
                                    echo "<script>document.write(toPersianNumber('" . $j . "'))</script>";
                                    echo ")";
                                }

                                $bandParts->bind_param('ii', $j, $i);
                                $bandParts->execute();
                                $parts = $bandParts->get_result();

                                while ($row = $parts->fetch_assoc()) {
                                    if ($row['FieldStatus'] == 'FULL') {
                                        echo "<span class='band_part' id='b_part_" . $j . "'> " . $row['Content'] . " </span>";
                                    } else {
                                        $tm = '';
                                        if($row['Content'] !== 'EMPTY')
                                            $tm = $row['Content'].'_';

                                        $id = $tm.'b_input_' . $row['ContentNum'] . '_' . $j;

                                        $inputHtml = getInputByType($row['FieldType'], $id);
                                        echo " " . $inputHtml . " ";
                                    }
                                }

                                echo "</div>";

                                $tab_bool = true;
                                if ($each_part_tabsare and $each_part_tabsare['MaddeNo'] === $i) {
                                    if ($each_part_tabsare['BandNo'] == $j || ($each_part_tabsare['BandNo'] == -1 && $j == $bandNumber)) {
                                        echo "<div class='form-inline' style='display: inline-block; position: relative;'>";

                                        do {
                                            if ($tab_bool) {
                                                echo "<br>";
                                                echo "تبصره " . "<script>document.write(toPersianNumber('" . $each_part_tabsare['TabsareNo'] . "'))</script>" . ": ";
                                            }

                                            if ($each_part_tabsare['FieldStatus'] == 'FULL') {
                                                $id = "t_m_b_" . $each_part_tabsare['TabsareNo'] . "_" . $i . '_' . $each_part_tabsare['BandNo'];
                                                echo "<span class='tabsare_part' id='" . $id . "'> " . $each_part_tabsare['Content'] . " </span>";
                                            } else {
                                                $tm = '';
                                                if($row['Content'] !== 'EMPTY')
                                                    $tm = $row['Content'].'_';

                                                $id = $tm. "input_t_m_b_" . $each_part_tabsare['TabsareNo'] . "_" . $i . "_" . $each_part_tabsare['BandNo'];
                                                $inputHtml = getInputByType($each_part_tabsare['FieldType'], $id);
                                                echo $inputHtml;
                                            }

                                            $row = $tabsare->fetch_assoc();
                                            if ($each_part_tabsare['MaddeNo'] == $row['MaddeNo'] and $row['BandNo'] == $each_part_tabsare['BandNo'] and $row['TabsareNo'] == $each_part_tabsare['TabsareNo']) {
                                                $tab_bool = false;
                                            } else {
                                                $tab_bool = true;
                                                echo "<br>";
                                            }
                                            $each_part_tabsare = $row;
                                        } while ($each_part_tabsare and $each_part_tabsare['MaddeNo'] == $i and (($each_part_tabsare['BandNo'] == -1 and $j == $bandNumber) || $each_part_tabsare['BandNo'] == $j));

                                        echo "</div>";
                                    }
                                }

                                if ($j != $bandNumber) {
                                    echo "<br>";
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="text d-flex flex-row justify-content-end" style="margin-bottom: 30px">
                <button class='btn btn-lg btn-secondary' type='button' id='clear_btn' style="margin-left: 20px"
                        name='clear_btn' onclick='clearAllInputs()'>پاک کردن اطلاعات
                </button>
                <button class='btn btn-lg btn-success' type='submit' id='submit_btn'
                        name='submit_btn'>تایید قرارداد
                </button>
            </div>
        </div>
        </form>
    </div>
</div>

<?php
function getInputByType($type, $id)
{
    $inputType = 'text';
    switch ($type) {
        case 'EMAIL':
            $inputType = 'email';
            break;
        case 'DATE':
            $inputType = 'date';
            break;
        case 'INT':
            $inputType = 'number';
            break;
    }

    $inputWidth = 'auto';
    if ($type == 'ADDRESS') {
        $inputWidth = '50%';
    }

    return "<input type='" . $inputType . "' class='form-control' style='width: " . $inputWidth . "' id='" . $id . "' name='" . $id ."'>";
}

include "../html files/Footer.html";
?>