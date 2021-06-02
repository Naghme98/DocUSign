<?php
session_start();
if(!$_SESSION['loggedin']){
    echo "<script> location.href='../php files/Login.php'; </script>";
}
include "../html files/Header.html";
$contract_data ='';
if(isset($_POST['check'])) {
    ?>

    <style>
        #info-form {
            direction: rtl;
            padding-top: 3%;
            padding-bottom: 2%;
            padding-right: 30%;
            text-align: center;
            margin-top: 5%;
            font-size: 15px;
        }

        .inputs {
            border-radius: 30px;
        }

        .page-btn {
            font-size: 14px;
            margin-top: 20px;
            margin-left: 10px;
            padding: 10px 20px 10px 20px;
            border-radius: 10px;

        }
    </style>
    <div style=" border-radius: 1%; box-shadow: 0 0 10px rgba(55, 69, 80, 0.75);width: 60%; margin:0 auto; margin-top: 5%;margin-bottom: 5%">
        <h5 class="text-center" style="font-size:25px; padding-top: 5%;color: #811424!important;"> ثبت نهایی
            قرارداد</h5>
        <form id='info-form' action="../php files/EncryptContract.php" method="post">
            <?php
            $paties = [];
            $bud ='';$start='';$end ='';$subj = '';
            foreach ($_POST as $key => $value) {
                if(strpos($key,'EMAIL')!== false)
                    $paties[$key]=$value;
                else if(strpos($key,'BUDGET')!== false)
                    $bud  = $key.':'.$value;
                else if(strpos($key,'START_DATE')!== false)
                    $start = $key.':'.$value;
                else if(strpos($key,'END_DATE')!== false)
                    $end = $key.':'.$value;
                else if (strpos($key , 'CONT_SUB')!== false)
                    $subj = $key.':'.$value;
                else
                    echo "<input type='hidden' id='".$key."' name='".$key."' value='".$value."'>";
            }

            ?>
            <div class="form-group">
                <label for="contract-subject">موضوع قرارداد</label>
                <div class="col-7" style="padding-top: 6%">
                    <input type="text" class="form-control inputs" id="contract-subject" name=<?= explode(':', $subj)[0]?>
                           value=<?= explode(':',$subj)[1]?> readonly>
                </div>
            </div>
            <div class="form-group ">
                <label for="contract-budget">بودجه توافق شده</label>
                <div class="col-7" style="padding-top: 6%">
                    <input type="number" class="form-control inputs" id="contract-budget" name=<?= explode(':',$bud)[0]?>
                           readonly value=<?= explode(':',$bud)[1]?>>
                </div>
            </div>
            <div class="form-group ">
                <label for="contract-copy-num">تعداد کپی‌های مورد نیاز</label>
                <div class="col-7" style="padding-top: 6%">
                    <input type="number" class="form-control inputs" id="contract-copy-num" name="contract-copy-num"
                           required >
                </div>
            </div>
            <div class="form-group ">

                <label for="contract-start-date">تاریخ شروع قرارداد</label>
                <div class="col-7" style="padding-top: 6%">
                    <input type="date" class="form-control inputs" id="contract-start-date" name=<?= explode(':',$start)[0]?>
                           readonly value=<?= explode(':',$start)[1]?>>
                </div>
            </div>
            <div class="form-group ">
                <label for="contract-end-date">تاریخ پایان قرارداد</label>
                <div class="col-7" style="padding-top: 6%">
                    <input type="date" class="form-control inputs" id="contract-end-date" name=<?= explode(':',$end)[0]?>
                           readonly value=<?= explode(':',$end)[1]?>>
                </div>
            </div>
            <div class="form-group ">
                <label for="contract-parties">آدرس ایمیل طرف قرارداد</label>
                <div id = "contract-parties">
                <?php
                    foreach($paties as $key =>$value){
                ?>
                <div class="form-row" style="padding-top: 2%;" id="parties">
                    <div class=" col-lg-7" style="margin-right: 2%"">
                        <input style="width: 93%" type="email" class="form-control inputs" id=<?= $key ?> name=<?= $key ?>
                              value=<?= $value?> readonly>
                    </div>

                </div>
                <?php } ?>
                </div>
            </div>
            <div class="form-group ">
                <label for="contract-password">رمز مورد نیاز برای محرمانگی قراداد</label>
                <div class="col-7" style="padding-top: 6%">
                    <input type="password" class="form-control inputs" id="contract-password" name="contract-password"
                           required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check d-flex " style="text-align: left">

                    <label class="form-check-label" for="invalidCheck2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;با شرایط گفته شده موافقم
                    </label>
                    <input class="form-check-input" type="checkbox" id="invalidCheck2" name="invalidCheck2" required>
                </div>
            </div>
            <input type="hidden" value='<?= $contract_data ?>' name="contract-data">
            <div class="form-group " style="margin-left:40%">
                <button type="submit" class="btn btn-success page-btn">ثبت قرارداد</button>
                <button type="button" class="btn btn-secondary page-btn">ذخیره برای بعد</button>
                <button type="button" class="btn btn-danger page-btn">لغو قرارداد</button>
            </div>
        </form>

    </div>

    <?php
}
include "../html files/Footer.html";
