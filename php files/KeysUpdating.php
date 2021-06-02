<?php include "../html files/Header.html"?>
<div class="container my-4" dir="rtl">
    <!--Grid row-->
    <div class="row">

        <!--Grid column-->
        <div class="col-md-6 mb-4">
        <div class="col-md-6 mb-4">

            <form class="md-form">
                <div class="file-field">
                    <div class="mb-4" >
                        <img src="../img/key.png" class=" avatar-picee" alt="example placeholder avatar" style="border-radius: 0.9rem; width: 30vw; height: 20vw; border-style: double;">
                    </div>
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-mdb-color btn-rounded float-left btn-primary" id="create-key"> ساخت کلید جدید</a>
                    </div>
                    </div>

            </form>

        </div>
        <!--Grid column-->

    </div>
    </div>
</div>
<div class="modal fade" id="modal_confirm" role="dialog">
    <div class="modal-dialog" style="width: 80%">

        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class=" modal-body d-flex justify-content-center" >
                <div class="wait overlay">
                    <div class="loader"></div>
                </div>
                <div class="container-fluid">
                    <div class="login-marg">
                        <form onsubmit="return false" id="confirmation">
                            <div style="background: #e3e3e3;direction: rtl;border-radius: 0.5rem; position: relative">
                                <div  class="login100-form-title" style="padding-bottom: 20%" >
                                    <h2 >تایید هویت</h2>
                                </div>
                                <div  style="">
                                    <label for="email-confirm">آدرس ایمیل</label>
                                    <input class="input input-borders" type="email" name="email-confirm" placeholder="ایمیل" id="email-confirm" required>
                                </div>
                                <div >
                                    <label for="password-confirm">رمزعبور</label>
                                    <input class="input input-borders" type="password" name="password-confirm" placeholder="رمزعبور" id="password-confirm" required>
                                </div>
                                <input class="primary-btn btn-block"   type="submit"  Value="تایید">
                                <div class="panel-footer" id = 'place' style="display: none; text-align: center"><div class="alert alert-danger"><h4 id="e_msg"></h4></div></div>

                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include "../html files/Footer.html"?>