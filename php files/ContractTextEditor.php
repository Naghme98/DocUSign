<?php
session_start();
include "./header.php";
if(!$_SESSION['loggedin']){
    echo "<script> location.href='../php files/Login.php'; </script>";
}
// include "../html files/documentEditor.html";
?>
<html dir="rtl" lang="fa">
    <head>
        <meta charset="utf-8">
        <title>CKEditor 5 – Document editor</title>
        <script src='https://cdn.tiny.cloud/1/sf0kaewkjdx5z33dsxsc92fiwruqiazcwa2trgvkhnf9gawv/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#mytextarea',
                directionality : "rtl"
            });
        </script>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <style>
            .editorstyle {
                width: 70%;
                margin: 0 auto;
            }
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 25%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: center;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <br>
        <h1 style="text-align:center; font-size: larger;">متن قرار داد</h1>
        <br>
        <!-- <form class="editorstyle container" action="ContractTextEditorLogic.php" method="post"> -->
        <form class="editorstyle container" method="post">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <textarea style="height: 500px;" class="editorstyle" id="mytextarea" name="mytextarea">متن را اینجا وارد کنید...</textarea>
                </div>
                <div class="col-sm-12 col-md-12">
                    <input type="button" id="btn2" name="addRow" style="width: 10%;" value="افزودن سطر" />
                    <input type="button" id="btn1" name="recordContract" style="width: 10%;" value="ثبت قرارداد" />
                </div>
                <div class="col-sm-12 col-md-12">
                    <p style="text-align:right; margin-top: 20px; margin-bottom: 20px;"> لطفا ایمیل طرف های قرارداد را جهت امضا در جدول زیر وارد کنید</p>
                    <table align="right" class="editorstyle" id="contractmembers" style="width: 40%; margin-bottom: 20px;">
                        <tr>
                            <th style="width: 20%;">شماره</th>
                            <th style="width: 80%;">ایمیل</th>
                        </tr>
                        <tr>
                            <td><p>1</p></td>
                            <td><input type="email" name="product" style="width: 100%; height: 100%;"></input></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
        <script>
            $(document).ready(function(){
                $("#btn1").on("click", async function(){
                    // check table is empty or not
                    var emails = getTableData()
                    if(emails.length == 0)
                        alert('لطفا ایمیل طرفین قرارداد را وارد کنید')
                    else{
                        var answer = window.confirm("آیا از متن قرارداد و ایمیل طرفین قرار داد مطمئن هستید؟");
                        if (answer) {
                            document.cookie = "party_emails = " + emails
                            document.cookie = "contract_content = " + tinymce.get("mytextarea").getContent();
                            
                            // <?php $_POST['party_emails'] = "<script>document.write(emails)</script>"?> 
                            location.href='ContractTextEditorLogic.php';
                        }
                        else {
                            alert("no")
                        }
                    }        
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                var rowNum = 2;
            $("#btn2").on("click", function(){
                var row = `<tr>
                        <td><p>`+rowNum+`</p></td>
                        <td><input type="email" name="product" style="width: 100%; height: 100%;"></input></td>
                    </tr>`;
                    rowNum++
                $("#contractmembers").append(row);
    
            });
            });
        </script>

        <script>
            function getTableData() {
                var myTab = document.getElementById('contractmembers');
                var all_emails = []
                // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
                for (i = 1; i < myTab.rows.length; i++) {
                    // GET THE CELLS COLLECTION OF THE CURRENT ROW.
                    var objCells = myTab.rows.item(i).cells;
                    email = myTab.rows[i].cells[1].children[0].value;
                    number = myTab.rows[i].cells[0].children[0].textContent;
                    if(email != '')
                        all_emails.push(email)
                }
                return all_emails
            }
        </script>
    </body>
</html>
<?php 
include "../html files/Footer.html";
?>