<?php include "../html files/Header.html";?>
<div class=" login-page login-box">
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body">
<!--      onsubmit="return false "-->
      <form  action="../php%20files/LoginLogic.php" method="post" >
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" id = "email" placeholder="ایمیل">
          <div class="input-group-append">
            <span class="fa fa-envelope input-group-text"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id = "password" placeholder="رمز عبور">
          <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
          </div>
        </div>
          <div class="col-8">
            <div class="checkbox">
              <label>
                <input class="form-check-input" name="rememberCheck" id = "rememberCheck" type="checkbox">
                مرا به خاطر بسپار &nbsp
              </label>
            </div>
          </div>
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary btn-block  ">ورود</button>
          </div>
          <div class="col-md-12 social-auth-links text-center">
            <a href="#" class="btn btn-block btn-danger">
              <i class="fa fa-google-plus mr-2"></i> ورود با اکانت گوگل
            </a>
          </div>

      </form>

      <p class="mb-1">
        <a href="#">رمز عبورم را فراموش کرده‌ام.</a>
      </p>
      <p class="mb-0">
        <a href="Register.php" class="text-center">ثبت‌نام</a>
      </p>
    </div>
  </div>

</div>
<?php include "../html files/Footer.html";?>
<!--</html>-->
