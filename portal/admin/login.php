<?php

require('config.php');

session_start();
session_destroy();
// redirect('admin/adminlogin.php');
redirect('/hospital/adminlog.php');

?>