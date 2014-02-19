<?php
if (isset($_COOKIE[session_name()])){
	session_start();
	setcookie(session_name(), '', time()-42000, '/');
	$_SESSION = array();
	session_destroy();
}
header("Location:/");
?>