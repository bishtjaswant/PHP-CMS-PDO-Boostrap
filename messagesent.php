<?php 
require_once 'admin/config/db.php';
 
     if ( $_SERVER['REQUEST_METHOD']=="POST" ) {
     	$name =  htmlspecialchars(strip_tags(ucfirst(trim($_POST['name']))) );
     	$email =  htmlspecialchars(strip_tags(trim($_POST['email'])));
     	$phone =  htmlspecialchars(strip_tags(trim($_POST['phone'])));
     	$message =  htmlspecialchars(strip_tags(trim($_POST['message'])));



         $query = "INSERT INTO `contact`(`name`, `email`, `phone`, `message`) VALUES ( :name,  :email, :phone, :message  )";
         $stmt = $conn->prepare($query);

         $stmt->bindParam(":name", $name, PDO::PARAM_STR);
         $stmt->bindParam(":email", $email, PDO::PARAM_STR);
         $stmt->bindParam(":phone", $phone, PDO::PARAM_INT);
         $stmt->bindParam(":message", $message, PDO::PARAM_STR); 
         $stmt->execute();

         if ($stmt->rowCount()>0) {
         	echo json_encode(['status'=>true, 'message'=>'message sent <br/> we will contact to you soon as posible']);
         } else {
         	echo json_encode(['status'=>false, 'message'=>'message not sent. network problum occured']);
         }

     }

 ?>
