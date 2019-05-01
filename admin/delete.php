<?php 
session_start();
require_once 'config/db.php';
/// if user not loggedd in
if (! isset($_SESSION['logged_user'] )) {
  header("Location: login.php");
}



// this code for delete the category

if (isset($_GET['category_id'])) {

	$category_id = $_GET['category_id'];
$query= "DELETE FROM `categories` WHERE `categories`.`id` = :cid";

				$stmt = $conn->prepare($query);

				$stmt->execute(array(':cid'=>$category_id));

				    if ($stmt->rowCount()>0) {
				    	header('Location:  view-insert-category.php');
				    	$_SESSION['message']="record deleted";
				    }
				   	
}





// this code for delete the news
if (isset($_GET['del_id'])) {
	$delete_id = $_GET['del_id'];

	$select_query = "SELECT * FROM `news` WHERE `news`.`id` = :sid";
		        
		$stmt = $conn->prepare($select_query);

		$stmt->execute(array(':sid'=>$delete_id));

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ( file_exists('images/'.$row['image']  ) ) {
			unlink('images/'.$row['image'] );

				$query= "DELETE FROM `news` WHERE `news`.`id` = :id";

				$stmt = $conn->prepare($query);

				$stmt->execute(array(':id'=>$delete_id));

				    if ($stmt->rowCount()>0) {
				    	header('Location:  view-insert-news.php');
				    	$_SESSION['message']="record deleted";
				    }
				   


		}
		else {
				    	header('Location:  view-insert-news.php?error=record not delete');
			}


}

 ?>