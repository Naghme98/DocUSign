<?php include "../html files/Header.html";?>
<div class="container-fluid">
<div class="register-box">
  <div class="register-logo" style="text-align: center">
      <b>ثبت نام در سایت</b>
  </div>
  <div class="card">
    <div class="card-body register-card-body">

      <form action="../php%20files/RegisterLogic.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="نام و نام خانوادگی" name="fl_name" id = "fl_name" required>
          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" class="form-control" maxlength="10" minlength="10" name="citizen_id" id = "citizen_id" placeholder="شماره ملی" pattern="^\d{10}$" required>
          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="tel" class="form-control" maxlength="11" minlength="11" name="phone_number" id = "phone_number" placeholder=" تلفن همراه: 09xx-xxx-xxxx" pattern="^\d{11}$" required>
          <div class="input-group-append">
            <span class="fa fa-user input-group-text"></span>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" id = "email" placeholder="ایمیل" required>
          <div class="input-group-append">
            <span class="fa fa-envelope input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id = "password" placeholder="رمز عبور" required>
          <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="re_password" id = "re_password" placeholder="تکرار رمز عبور" required>
          <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
<!--            <div class="checkbox icheck">-->
<!--              <label>-->
<!--                <input type="checkbox" name="accept_rules" id="accept_rules" required> با <a href="#" style="color: #0c0c0c">شرایط</a> موافق هستم-->
<!--              </label>-->
<!--            </div>-->
          </div>
          <!-- /.col -->
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-block btn-block">ثبت نام</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-danger">
          <i class="fa fa-google-plus mr-2"></i>
          ثبت نام با گوگل
        </a>
      </div>

      <a href="Login.php" class="text-center">قبلا ثبت‌نام کرده‌ام</a>
    </div>
  </div>
</div>
</div>
<?php include "../html files/Footer.html";?>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- iCheck -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass   : 'iradio_square-blue',
      increaseArea : '20%' // optional
    })
  })
</script>


