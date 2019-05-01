<?php 
session_start();
 
 /// if user  loggedd in
if ( isset($_SESSION['logged_user'] )) {
			   
			 
			$_SESSION['logged_user']= [];
			unset($_SESSION['logged_user']);
			session_destroy();
			header("Location: login.php");
} else {
	header("Location: login.php");
}


 ?>