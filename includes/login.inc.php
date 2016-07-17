<?php
// Include required MySQL configuration file and functions
require_once('config.inc.php'); 
require_once('functions.inc.php');

// Start session 
session_start();

// Check if user is already logged in 
if ($_SESSION['logged_in'] == true) {
	// If user is already logged in, redirect to main page
	redirect('../user.php'); 
} else {
	// Make sure that user submitted a username/password and username only consists of alphanumeric chars
	if ( (!isset($_POST['username'])) || (!isset($_POST['password'])) OR 
		(!ctype_alnum($_POST['username'])) ) {
		redirect('../login.php'); }
	// Connect to database
	$mysqli = @new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	// Check connection
	if (mysqli_connect_errno()) {
	printf("Unable to connect to database: %s", mysqli_connect_error());
	exit(); }

	// Escape any unsafe characters before querying database
	$username = $mysqli->real_escape_string($_POST['username']); 
	$password = $mysqli->real_escape_string($_POST['password']);
	// Construct SQL statement for query & execute
	$sql = "SELECT * FROM admin WHERE username = '" . $username . "' AND password = '" . md5($password) . "'";
	$result = $mysqli->query($sql);

	// If one row is returned, username and password are valid 
	if (is_object($result) && $result->num_rows == 1) {
		// Set session variable for login status to true 
		$_SESSION['logged_in'] = true; 
		$_SESSION['user'] = $username;
		redirect('../user.php');
		} else {
		// If number of rows returned is not one, redirect back to login screen 
			redirect('../login.php');
		} }
		?>