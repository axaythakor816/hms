<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Reset Password | Karn Hospital</title>

<link rel="stylesheet" href="../assets/css/bootstrap.min.css">
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="stylesheet" href="../assets/css/theme-color.css">
<link rel="stylesheet" href="../assets/css/responsive.css">
<link href="../assets/images/favicon.ico" rel="shortcut icon">

<style>
#preloader{
    position: fixed;
    inset: 0;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 99999;
}
.ecg-loader{
    width:220px;
    height:60px;
}
.ecg-loader svg polyline{
    fill:none;
    stroke:#0a9fd9;
    stroke-width:3px;
    stroke-linecap:round;
    stroke-linejoin:round;
    stroke-dasharray:200;
    stroke-dashoffset:200;
    animation:heartbeat 2s infinite ease-in-out;
}
@keyframes heartbeat{
    0%{stroke-dashoffset:200;opacity:.3}
    40%{stroke-dashoffset:70;opacity:1}
    60%{stroke-dashoffset:20;opacity:1}
    100%{stroke-dashoffset:-200;opacity:.3}
}
.login-box {
    padding: 20px;
}
</style>
</head>

<body>
<div class="wrapper">

<div id="preloader">
    <div class="ecg-loader">
        <svg viewBox="0 0 100 30">
            <polyline points="0,15 20,15 30,5 40,25 50,15 70,15 100,15"/>
        </svg>
    </div>
</div>

<section class="ulockd-login bgc-snowshade2" style="padding:80px 0;">
    <div class="container">

        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center">
                <div class="ulockd-main-title">
                    <h2><span class="text-thm">Reset</span> Password</h2>
                    <p class="text-muted">
                        Create a new strong password for your account.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="login-box bgc-white ulockd-bdr-thm">

                    <form id="reset_form" method="POST" novalidate>

                        <input type="hidden" name="user_id" id="user_id" value="">

                        <div class="form-group text-left">
                            <label>
                                <i class="fa fa-lock text-thm"></i> New Password
                            </label>
                            <span class="error" id="new_password_error"></span>
                            <input type="password" name="new_password" id="new_password"
                                   class="form-control"
                                   placeholder="Enter new password" required>
                                   
                        </div>

                        <div class="form-group text-left">
                            <label>
                                <i class="fa fa-lock text-thm"></i> Confirm Password
                            </label>
                            <span class="error" id="confirm_password_error"></span>
                            <input type="password" name="confirm_password" id="confirm_password"
                                   class="form-control"
                                   placeholder="Confirm new password" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="reset_password"
                                    class="btn btn-lg ulockd-btn-thm2">
                                Reset Password <i class="fa fa-check"></i>
                            </button>
                        </div>

                        <div style="text-align:center; margin-top:15px;">
                            <a href="../page-login.php" class="text-thm">
                                <i class="fa fa-arrow-left"></i> Back to Login
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
</section>

<a class="scrollToHome" href="#"><i class="fa fa-home"></i></a>
</div>

<script src="../assets/js/jquery-1.12.4.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/script.js"></script>
<script src="../assets/ajax/helper.js"></script>
<script src="../assets/ajax/forgot_password.js"></script>


<script>
    $(window).on("load", function(){
        $("#preloader").fadeOut(600);
    });

    var token = "<?php echo $_GET['token'] ?? ''; ?>";
    console.log("Reset Token: ", token);

    verify_token(token);
    
</script>


</body>
</html>
