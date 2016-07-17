<?php
// Start session 
session_start();

// Include required functions file 
require_once('functions.inc.php');

// If not logged in, redirect to login screen
// If logged in, unset session variable and display logged-out message 
if (check_login_status() == false) {
	// Redirect to
	redirect('../login.php'); } 
else {
	// Kill session variables 
	unset($_SESSION['logged_in']); 
	unset($_SESSION['us ername']);
	
	// Destroy session 
	session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1- s trict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
	   <title>Logout</title> 
	<!-- Bootstrap Core CSS -->
    <link href="../theme/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../theme/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	</head>
<body style="background: #032a47">
  <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <img src="http://mycourse.atilal.com/2013/egci423/dbproject/web/images/logo.png" alt="Mahidol" style="width:100%;height:100%">
                        <h3 class="panel-title">Log out</h3>
                    </div>
<p style="margin-left: 2%">You have successfully logged out. Back to <a href="../login.php">login</a> screen.</p> 
</div>
            </div>
        </div>
    </div>


</body>
</html>