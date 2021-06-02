<?php
include "../db.php";
include "../html files/Header.html";
if (isset($_POST['b_input_2_1'])) {
    ?>

    <script src="../javascript%20files/string-util.js"></script>
    <script src="../javascript%20files/scripts.js"></script>
    <div class="container" style="text-align: right">
        <div id="main-container" style="direction: rtl; padding-top: 20px">
            <div id="contract_content">

                <?php
                $bands_counter = 0;
                $tabsare_counter = 0;
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

                for ($i = 1; $i <= $maddeNumber; $i++) {
                    $bandNumber = $con->query($q2 . $i)->fetch_assoc()["number"];
                    ?>
                    <div class="text-default form-box d-flex flex-column" style="padding-left: 40px">
                    <div class="d-flex flex-row" style="padding-bottom: 5px">
                        <h6 class="text-bold">
                            <?php
                            if ($maddeNumber > 1) {
                                echo "<script>document.write(toPersianNumber('" . $i . "'))</script>" . ". ";
                            }
                            ?>
                            <span class="madde_title" id="m_title_<?= $i ?>">
                                    <?= $maddeTitles->fetch_assoc()['Content'] ?>
                                </span>
                        </h6>
                    </div>

                    <?php

                    for ($j = 1; $j <= $bandNumber; $j++) {
                        echo "<div class='form-inline' style='display: inline-block; position: relative;'>";
                        if ($bandNumber > 1) {
                            echo "<script>document.write(toPersianNumber('" . ($j - $bands_counter) . "'))</script>" . ") ";
                        }
                        $bandParts->bind_param('ii', $j, $i);
                        $bandParts->execute();
                        $parts = $bandParts->get_result();
                        $band_content = '';
                        while ($row = $parts->fetch_assoc()) {
                            if ($row['FieldStatus'] == 'FULL') {
                                $band_content .= ($row['Content'] . ' ');
                            } else {
                                $tm = '';
                                if($row['Content'] !== 'EMPTY')
                                    $tm = $row['Content'].'_';

                                $id = $tm. 'b_input_' . $row['ContentNum'] . '_' . $j;
                                $band_content .= ($_POST[$id] . ' ');
                            }
                        }

                        echo "<span class='band_part' id='b_m_" . ($j - $bands_counter) . "_" . $i . "'> " .
                            $band_content . " </span>";
                        echo "</div>";

                            if ($j != $bandNumber) {
                                echo "<br>";
                            }

                        $tab_bool = true;
                        if ($each_part_tabsare and $each_part_tabsare['MaddeNo'] === $i) {
                            if ($each_part_tabsare['BandNo'] == $j || ($each_part_tabsare['BandNo'] == -1 && $j == $bandNumber)) {
                                echo "<div class='form-inline' style='display: inline-block; position: relative;'>";
                                $tabsare_content = '';
                                do {
                                    if ($tab_bool) {
                                        echo "<br>";
                                        echo "تبصره " . "<script>document.write(toPersianNumber('" . $each_part_tabsare['TabsareNo'] . "'))</script>" . ": ";
                                    }
                                    if ($each_part_tabsare['FieldStatus'] == 'FULL') {
                                        $tabsare_content .= $each_part_tabsare['Content'] . ' ';
                                    } else {
                                        $tm = '';
                                        if($row['Content'] !== 'EMPTY')
                                            $tm = $row['Content'].'_';

                                        $id = $tm. "input_t_m_b_" . $each_part_tabsare['TabsareNo'] . "_" . $i . "_" . $each_part_tabsare['BandNo'];
                                        $tabsare_content .= $_POST[$id] . ' ';
                                    }
                                    $row = $tabsare->fetch_assoc();
                                    if ($each_part_tabsare['MaddeNo'] == $row['MaddeNo'] and $row['BandNo'] == $each_part_tabsare['BandNo'] and $row['TabsareNo'] == $each_part_tabsare['TabsareNo']) {
                                        $tab_bool = false;
                                    } else {
                                        $tab_bool = true;
                                        echo "<div class='tabsare_parts' id='t_b_m_" . $each_part_tabsare['TabsareNo'] . "_" .
                                            $each_part_tabsare['BandNo'] . "_" . $i . "'>" .
                                            $tabsare_content .
                                            "</div>";
                                        $tabsare_content ='';
                                        echo "<br>";

                                    }

                                    $each_part_tabsare = $row;
                                } while ($each_part_tabsare and $each_part_tabsare['MaddeNo'] == $i and (($each_part_tabsare['BandNo'] == -1 and $j == $bandNumber) || $each_part_tabsare['BandNo'] == $j));
                                echo "</div>";
                            }
                        }
                    }
                    ?>
            </div>
                <?php
                }

//

                ?>
                <form action="GetLastInformationForContract.php" method="POST">
                    <?php
                    foreach ($_POST as $key => $value) {
                        echo "<input type='hidden' id='".$key."' name='".$key."' value='".$value."'>";
                    }
                    echo "<input type='hidden' name='check' value='checked'>";
                    ?>

                <div class="text d-flex flex-row justify-content-end" style="margin-bottom: 30px">
                    <button class='btn btn-lg btn-primary' type='button' id='edit_btn' style="margin-left: 20px"
                            name='clear_btn' onclick='changeToEditable()'>تصحیح نهایی
                    </button>
                    <button class='btn btn-lg btn-success' type='submit' id='submit_btn'
                            name='submit_btn' >تایید و ارسال قرارداد
                    </button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <?php
}

include "../html files/Footer.html";