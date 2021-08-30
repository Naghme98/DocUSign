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
        <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/decoupled-document/ckeditor.js"></script>
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
        <!-- The toolbar will be rendered in this container. -->
        <div class="editorstyle" id="toolbar-container" ></div>

        <!-- This container will become the editable. -->
        <div class="editorstyle" id="editor" style="height: 500px;">
            <textarea class="inputStyle" id="editor" name="content">متن را در اینجا وارد کنید...</textarea>
        </div>
        <div>
            <p class="editorstyle" style="text-align:right; margin-top: 20px; margin-bottom: 20px;"> لطفا ایمیل طرف های قرارداد را جهت امضا در جدول زیر وارد کنید</p>
            <table class="editorstyle" id="contractmembers" style="width: 40%; margin-right: 15%;">
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
        <!-- <form  action="../php%20files/ContractTextEditorLogic.php" method="post">
            <input type="submit" id="btn1" name="recordContract" style="width: 10%;" value="ثبت قرارداد" />
            <input type="submit" id="btn2" name="addRow" style="width: 10%;" value="افزودن سطر" />
        </form>    
        <button type="button" id="btn1" style="width: 10%;">ثبت قرارداد</button>
        <button type="submit" id="btn2" style="width: 10%;">افزودن سطر</button> -->
        <input type="submit" id="btn2" name="addRow" style="width: 10%;" value="افزودن سطر" />
        <input type="submit" id="btn1" name="recordContract" style="width: 10%;" value="ثبت قرارداد" />

        <script>
            var myEditor;
            DecoupledEditor
                .create( document.querySelector( "#editor" ),{
                    language: 'fa',
                    fontSize: {
                        options: [
                            9,11,10,12,14,16,18,20,22,24,26,28,30,34,40
                        ],
                        supportAllValues: true
                    },
                    toolbar: {
                        items: [
                            'heading', '|',
                            'alignment', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'bulletedList', 'numberedList', 'todoList',
                            '-', // break point
                            'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor', '|',
                            'code', 'codeBlock', '|',
                            'insertTable', '|',
                            'outdent', 'indent', '|',
                            'uploadImage', 'blockQuote', '|',
                            'undo', 'redo', 'comment'
                        ],
                        // shouldNotGroupWhenFull:true
                    },sidebar: {
                        container: document.querySelector( '#sidebar' )
                    }
                } )
                .then( editor => {
                    const toolbarContainer = document.querySelector( "#toolbar-container" );
                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );
                    // handleStatusChanges(editor)
                    myEditor = editor
                } )
                .catch( error => {
                    console.error( error );
                } );

                // pending actions (to show the spinner animation when the editor is busy).
            function handleStatusChanges( editor ) {
                editor.plugins.get( 'PendingActions' ).on( 'change:hasAny', () => updateStatus( editor ) );

                editor.model.document.on( 'change:data', () => {
                    isDirty = true;

                    updateStatus( editor );
                } );
            }
        </script>

        <script>
            var editor_data;
            $(document).ready(function(){
                $("#btn1").on("click", async function(){
                    // check table is empty or not
                    var emails = getTableData()
                    if(emails.length == 0)
                        alert('لطفا ایمیل طرفین قرارداد را وارد کنید')
                    else{
                        var answer = window.confirm("آیا از متن قرارداد و ایمیل طرفین قرار داد مطمئن هستید؟");
                        if (answer) {
                            editor_data = myEditor.getData()
                            <?php $_SESSION['contract_text'] = "<script>return editor_data</script>"?> 
                            <?php $_SESSION['party_emails'] = "<script>return emails</script>"?> 
                            location.href='ContractTextEditorLogic.php';
                            // const myJson = await response.json();
                            // <?php
                            //     $_SESSION['contract_text'] = echo "<script>my_doc.writeln(editor_data);</script>";
                            //     $_SESSION['party_emails'] = echo "<script>my_doc.writeln(emails);</script>";
                            // ?>
                            // $.session.set("contract_text", editor_data);
                            // $.session.set("party_emails", emails);
                            // window.location.href='ContractTextEditorLogic.php';
                            // alert(editor_data)
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
                var count = 2;
            $("#btn2").on("click", function(){
                var row = `<tr>
                        <td><input type="email" name="product" style="width: 100%; height: 100%;"></input></td>
                        <td><p>`+count+`</p></td>
                    </tr>`;
                count++
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
                    email = myTab.rows[i].cells[0].children[0].value;
                    number = myTab.rows[i].cells[1].children[0].textContent;
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