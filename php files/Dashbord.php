<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1">-->
<!--    <link rel="stylesheet" href="--><?//=site_url ?><!--/assets/style.css">-->
<!--    <link rel="stylesheet" href="--><?//=site_url ?><!--/assets/css/font-awesome.min.css">-->
<!--    <link rel="stylesheet" href="--><?//=site_url ?><!--/assets/css/Dashbord_Black_Theme.css">-->
<!---->
<!--</head>-->
<!--<body>-->
<?php include "../html files/Header.html"?>

    <div id="wrapper">
        <nav class="sidebar_menu ccfg_main_primary">
            <div class="uper_sidebar_menu">
<!--                <a href="../php files/Dashbord.php" class="brand-link">-->
<!--                    <img src="--><?//=site_url ?><!--/assets/img/Logo.png" alt="AdminLTE Logo" class="brand-image"/>-->
<!--                    <spam class="brand-text v1">سامانه  </spam>-->
<!--                    <spam class="brand-text v2"> قرارداد ها </spam>-->
<!--                </a>-->
                <!-- Sidebar user panel (optional) -->
                <div style="clear:both;"></div>
            </div>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <div class="user-panel">
                    <div class="info">
                        <a href="#" target="main_page" class="d-block">naghme@gmail.com</a>
                    </div>
                </div>
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a target="main_page" href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>
                            تقویم
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a target="main_page" href="../php files/CreateContract.php" class="nav-link">
                        <i class="nav-icon fa fa-envelope-o"></i>
                        <p>
                            قرارداد‌ها
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a target="main_page" href="pages/mailbox/mailbox.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>منتظر امضا من</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="main_page" href="pages/mailbox/compose.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>منتظر امضا طرفین</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="main_page" href="pages/mailbox/read-mail.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>واگذاری شده برای بعد</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="main_page" href="pages/mailbox/compose.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>کامل شده</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a target="main_page" href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon fa-group"></i>
                        <p>
                            دوستان
                        </p>
                    </a>
                </li>


                <li class="nav-item has-treeview">
                    <a target="main_page" href="/profile" class="nav-link">
                        <i class="nav-icon fa fa-book"></i>
                        <p>
                            پروفایل
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a target="main_page" href="pages/examples/invoice.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>نغییر امضا</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="main_page" href="pages/examples/profile.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>تغییر اطلاعات شخصی</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="main_page" href="pages/examples/login.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>تغییر رمز عبور</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a target="main_page" href="pages/examples/login.html" class="nav-link">
                                <i class="fa fa-circle-o nav-icon"></i>
                                <p>تغییر کلید‌ها</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a target="main_page" href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon fa-group"></i>
                        <p>
                            قرارداد‌های حذف شده
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a target="main_page" href="pages/calendar.html" class="nav-link">
                        <i class="nav-icon fa-group"></i>
                        <p>
                            خروج از سایت
                        </p>
                    </a>
                </li>

            </ul>
            <div class="help">
                <a title="eversign Help Center" target="_blank" href="" class="icon_link business_settings">
                    <span class="sidebar_menu_link_text"><span class="hide_compact">Help Center</span></span>
                </a>
            </div>
        </nav>
<!--        <main>-->
<!--            <iframe src="../php files/CreateContract.php" name="main_page"></iframe>-->
<!--        </main>-->
    </div>
<!--</body>-->
<!--</html>-->

<?php include "../html files/Footer.html"?>