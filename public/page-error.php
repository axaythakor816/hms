<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="keywords" content="hospital, health, clinic, doctor, medical, 404, page not found">
<title>404 - Page Not Found | Karn Hospital</title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/theme-color.css">
<link rel="stylesheet" href="assets/css/responsive.css">
<link href="assets/images/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<style>
  body {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    height: 100%;
    overflow: hidden; /* Scroll disable */
}

html {
    height: 100%;
    overflow: hidden; /* Scroll disable */
}


    /* Top section with error message */
    .ulockd-inner-home {
        padding: 120px 20px;
        text-align: center;
    }

    .ulockd-inner-home h1.error-code {
        font-size: 120px;
        font-weight: 900;
        color: #fff;
        margin-bottom: 20px;
        text-shadow: 2px 2px 15px rgba(0,0,0,0.3);
        animation: bounce 1.5s infinite;
    }

    .ulockd-inner-home h2.error-title {
        font-size: 60px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 20px;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    }

    .ulockd-inner-home p {
        font-size: 20px;
        color: #e0f7fa;
        margin-bottom: 30px;
    }

    .btn-home {
        display: inline-block;
        padding: 12px 35px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 50px;
        color: #0072ff;
        background: #fff;
        text-decoration: none;
        transition: 0.4s;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .btn-home:hover {
        background: #e6f0ff;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.3);
    }

    .breadcrumb {
        margin-top: 30px;
        text-align: center;
    }

    .breadcrumb a {
        color: #e0f7fa;
        text-decoration: none;
        font-weight: 500;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }

    @media(max-width:576px){
        .ulockd-inner-home h1.error-code { font-size: 80px; }
        .ulockd-inner-home h2.error-title { font-size: 40px; }
        .ulockd-inner-home p { font-size: 16px; }
    }
</style>
</head>
<body>

<!-- Top Error Section with Background -->
<div class="ulockd-inner-home">
    <div class="container">
        <h1 class="error-code">404</h1>
        <h2 class="error-title">ERROR</h2>
        <p>Oops! The page you are looking for does not exist.<br>It might have been moved or deleted.</p>
        <a href="index.php" class="btn-home">Back to Home</a>        
    </div>
</div>

<script src="assets/js/jquery-1.12.4.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/bootsnav.js"></script>
<script src="assets/js/script.js"></script>

</body>
</html>
