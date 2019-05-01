<?php 
/* pdo connection */
try {
	$conn = new PDO("mysql:host=localhost;dbname=newsportal;", "root","") ;
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	 
} catch (PDOException $e) {
	die('error'.$e->getMessage());
}