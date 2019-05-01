<?php
session_start();
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
            <h1><i class="fa fa-newspaper"></i> &nbsp;Views all category</h1> 
              <strong><i class="fa fa-user-tie"></i>&nbsp; Welcome: <?= ucfirst($_SESSION['logged_user']['name']); ?> </strong>  &nbsp; &nbsp; 
            <?php 
                        $count_categories ="SELECT * FROM `categories` ORDER BY  `id` DESC ";
                        $stmt = $conn->prepare($count_categories);
                        $stmt->execute();
                        $category_count = $stmt->rowCount();
             ?>
            <strong><i class="fa fa-newspaper"></i>&nbsp; total categories <span class="badge badge-info">
              <?= $category_count ; ?>
            </span> </strong>
          </div>
          <hr>


          <br><hr>
          <h1>Available categories</h1>
          <div class="row">
            <div class="col-md-12">
              <?php if (isset($_SESSION['message'])): ?>
                <p class="text-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
              <?php endif ?>
              <a href="insert-category.php" style="float: right; margin: 5px;" class="btn btn-sm btn-success">Add  category </a>
              <table class="table table-striped table-bordered table-hover">
                <thead >
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th> 
                    <th colspan="3" scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  
                  <?php 
   $query ="SELECT * FROM `categories` ORDER BY  `id` DESC ";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        if ($stmt->rowCount()>0) {
                             $id =1;
                           foreach ($rows = $stmt->fetchAll(PDO::FETCH_ASSOC) as $key=> $value) {


                             
                        
                   ?>

                  
                  <tr>
                    <th scope="row"><?= $id++; ?> </th> 
                    <td><?= $rows[$key]['name']; ?></td>
                    <td>
                      <a href="insert-category.php?update_category_id=<?= $rows[$key]['id'];?>" class="btn btn-primary">edit</a>
                      <a href="delete.php?category_id=<?= $rows[$key]['id'];?>" class="btn btn-danger">delete </a>
                    </td>
                  </tr>
                <?php }
              } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
      </div>
    </div>


    <?php include_once 'assets/includes/footer.php'; ?>