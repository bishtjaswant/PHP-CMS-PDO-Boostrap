<?php
session_start();

 include_once 'assets/includes/header.php'; 
require_once 'config/db.php';

/// if user not loggedd in
if (! isset($_SESSION['logged_user']['name'] )) {
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
              <li class="active"><a href="index.php"> <i class="fas fa-tachometer-alt"></i> Dashboard</a> </li>
              <li><a href="view-insert-news.php"> <i class="fas fa-edit"></i> View / insert news</a> </li>
              <li><a href="view-insert-category.php"> <i class="fas fa-chart-bar"></i> View / insert  category</a> </li>
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
            <h1><i class="fa fa-tachometer-alt"></i> &nbsp;Admin Dashboard</h1>
            <strong><i class="fa fa-user-tie"></i>&nbsp; Welcome: <?= ucfirst($_SESSION['logged_user']['name']); ?> </strong>
          </div>
          <hr>
          <div class="row">
            <div  class="col-md-4">
              <div class="card" style="width: 18rem;">
                <div class="icon">
                  <i class="fa fa-chart-bar"></i>
                </div>
                <div class="card-body">
                  <?php 
                    $post_count ="SELECT * FROM `news` ";
                    $stmt = $conn->prepare($post_count);
                    $stmt->execute();
                    $count_posts = $stmt->rowCount();
                   ?>
                  <h5 class="card-title" style="font-size: 22px;text-align: center; text-transform: capitalize;" >posts</h5>
                  <p style="font-size: 1.7rem;text-align: center;background-color: #283c86; border-radius: 100%; color: white; "><?php echo $count_posts; ?>  </p>
                  
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
                <div class="icon">
                  <i class="fa fa-phone"></i>
                </div>
                <div class="card-body">
                      <?php 
                    $contact_count ="SELECT * FROM `contacts` ";
                    $stmt = $conn->prepare($contact_count);
                    $stmt->execute();
                    $count_contact = $stmt->rowCount();
                   ?>
                  <h5 class="card-title" style="font-size: 22px;text-align: center; text-transform: capitalize;" >contacts</h5>
                  <p style="font-size: 1.7rem;text-align: center;background-color: #E100FF; border-radius: 100%; color: white; "><?= $count_contact; ?></p>
                  
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
                <div class="icon">
                  <i class="fa fa-pencil-alt"></i>
                </div>
                <div class="card-body">
                   <?php 
                    $categories_count ="SELECT * FROM `categories` ";
                    $stmt = $conn->prepare($categories_count);
                    $stmt->execute();
                    $count_categories = $stmt->rowCount();
                   ?>
                  <h5 class="card-title" style="font-size: 22px;text-align: center; text-transform: capitalize;" >categories</h5>
                  <p style="font-size: 1.7rem;text-align: center;background-color: #0f9b0f; border-radius: 100%; color: white; "><?= $count_categories; ?></p>
                  
                </div>
              </div>
            </div>
          </div>
          <br><hr>
          <h1>Contact List</h1>
          <div class="row">
            <div class="col-md-12">
              
              <table class="table table-striped table-bordered table-hover">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Message</th>
                    <th scope="col">Phone</th>
                  </tr>
                </thead>
                <tbody>
                     <?php 
                        $contact_count ="SELECT * FROM `contacts` ";
                        $stmt = $conn->prepare($contact_count);
                        $stmt->execute();
                        if ($stmt->rowCount()>0) {
                           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                           $id =1;
                           foreach ($rows as $key=> $value) {
                             
                        
                   ?>
                  
                  <tr>
                    <th scope="row"><?= $id++; ?></th>
                    <td><?= $rows[$key]['name']; ?></td>
                    <td><?= $rows[$key]['email']; ?></td>
                    <td><?= $rows[$key]['message']; ?></td>
                    <td><?= $rows[$key]['phone']; ?></td>
                  </tr>
                  <?php 
                     }
                        } else {
                          echo '<tr>
                                  <td colspan="4" class="text-danger text-center"> no messages to read </td>
                          </tr>';
                        }

                         ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
      </div>
    </div>


    <?php include_once 'assets/includes/footer.php'; ?>

    