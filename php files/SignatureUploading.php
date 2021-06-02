<?php include "../html files/Header.html";?>

<div class="container my-4" dir="rtl">
    <div class="row">
        <div class="col-md-6 mb-4">
            <form class="md-form" >
                <div class="file-field">
                    <div class="mb-4" >
                        <img src= "../img/signature.jpg" class="img-fluid"
                             alt="تصویر امضا" style="border-radius: 0.9rem; width: 30vw; height: 20vw; border-style: double" id="signature">
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="btn btn-mdb-color btn-rounded float-left btn-primary">
                            <label for="files" class="btn" >تصویر امضا خود را آپلود کنید</label>
                            <input type="file" id="files" accept=" image/jpeg, image/png" style="display: none;" onchange="loadFile(event)">
                        </div>
                        <div>
                            <button  class="btn btn-mdb-color btn-rounded float-left btn-danger" style=" margin-right: 1vw ;color: #0c0c0c;">
                                حذف امضا
                            </button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!--Grid column-->
    </div>
</div>

<?php include "../html files/Footer.html";?>
