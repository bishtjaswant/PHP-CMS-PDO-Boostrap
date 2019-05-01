<?php
session_start() ;
require_once 'config/db.php';
 include_once 'assets/includes/header.php';  
    
    /// if user not loggedd in
if (! isset($_SESSION['logged_user'] )) {
  header("Location: login.php");
}
?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="heading">
            <h2 class="text-center">Admin Panel</h2>
          </div>
                   <div class="profile">

            <?php 
               $sql = "SELECT `admin`.`image` FROM  `admin` WHERE `admin`.`id` = :id";
               $admin_id =  $_SESSION['logged_user']['id'];
               $stmt = $conn->prepare($sql);
               $stmt->execute([':id'=> $admin_id]);

               if ($stmt->rowCount()>0) {
                 $row = $stmt->fetch(PDO::FETCH_ASSOC);
               

             ?>
            <img src="admin_image/<?= $row['image'];  ?>" class="img img-fluid">

          <?php } ?>
          </div>
          <div class="menu">
            <ul>
              <li ><a href="index.php"> <i class="fas fa-tachometer-alt"></i> Dashboard</a> </li>
              <li><a href="view-insert-news.php"> <i class="fas fa-edit"></i> View / insert news</a> </li>
              <li class="active"><a href="view-insert-category.php"> <i class="fas fa-chart-bar"></i> View / insert category</a> </li>
              <li><a href="change-password.php"> <i class="fas fa-desktop"></i> Change password</a> </li>
              
            </ul>
          </div>
        </div>
        <div class="col-md-9 mycontainer">
          <div class="container-fluid">
            <div class="d-flex justify-content-end">
              <a href="logout.php" class="btn btn-info m-4">Logout</a>

            </div>
          </div>
          <div class="container">
            <h1><i class="fa fa-newspaper"></i> &nbsp;Add category </h1>
              <strong><i class="fa fa-user-tie"></i>&nbsp; Welcome: <?= ucfirst($_SESSION['logged_user']['name']); ?> </strong> 
          </div>
          <hr>


          <br><hr>
          <h1>Insert category</h1>
          <div class="row">
            <?php if (isset($_SESSION['messages'])): ?>
              <p class="text-primary"> <?= $_SESSION['messages']; unset($_SESSION['messages'] ); ?> </p>
            <?php endif ?>
            <div class="col-md-12">

              <?php 
                  // get the data for update
               if (isset($_GET['update_category_id'])) {
                   $update_category_id = $_GET['update_category_id'];
                   $stmt = $conn->prepare("SELECT * FROM `categories` WHERE `categories`.`id` =  :cid");
                   $stmt->execute(array(':cid'=>$update_category_id));
                   $row = $stmt->fetch(PDO::FETCH_ASSOC);
               }


               ?>
              <form action="insert-category.php" method="POST" >
                <div class="form-group">
                  <label for="categoryname">Category name</label>
                  <input type="hidden" name="updte_category_id" value="<?= @$row['id'];  ?>">
                  <input type="text" class="form-control" name="categoryname" placeholder="write your category title" id="categoryname" value="<?= @$row['name']; ?>" required >
                  
                </div>
           
               <?php if (isset($_GET['update_category_id'])): ?>
                  <button type="submit" name="update_category" style="float: right;" class="btn btn-primary"> Update category</button>
                  <?php else: ?>
                      <button type="submit" name="add_category" style="float: right;" class="btn btn-primary">Add category</button>
                <?php endif ?> 
               
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <?php include_once 'assets/includes/footer.php'; ?>


    <?php 

// add the new category
    if ( isset($_POST['add_category'])) {
           $categoryname = htmlspecialchars(strip_tags( $_POST['categoryname'] ));
             
             $query = "INSERT INTO `categories`( `name` )
                       VALUES ( :name )";
                       $stmt = $conn->prepare($query);

                       $stmt->bindParam(':name', $categoryname,PDO::PARAM_STR);   
                          
                        $stmt->execute();

                        if ($stmt->rowCount()>0) {
                              header('Location: insert-category.php');
                              $_SESSION['messages']="category  added"; 
                        }

    }

// update old catefory
    if (isset($_POST['update_category'])  &&  $_POST['updte_category_id']) {
           $categoryname = htmlspecialchars(strip_tags( $_POST['categoryname'] ));

      $update_category_id = $_POST['updte_category_id'];
      $sql = "UPDATE `categories` SET `name`=:name WHERE `categories`.`id` = :id ";
      $stmt = $conn->prepare($sql);
      $stmt->execute([
        ':id'=>$update_category_id,
        ':name'=>$categoryname
      ] ) ;

         if ($stmt->rowCount()>0) {
                header('Location: view-insert-category.php'); 
         }
    }


     ?>