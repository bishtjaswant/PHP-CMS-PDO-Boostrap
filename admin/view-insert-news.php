<?php
session_start();
 include_once 'assets/includes/header.php'; 
require_once 'config/db.php'; 

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
              <li class="active"><a href="view-insert-news.php"> <i class="fas fa-edit"></i> View / insert news</a> </li>
              <li><a href="view-insert-category.php"> <i class="fas fa-chart-bar"></i> View / insert category</a> </li>
              <li><a href="insert-category.php"> <i class="fas fa-desktop"></i> Change password</a> </li>
              
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
            <h1><i class="fa fa-newspaper"></i> &nbsp;Views all news</h1>
              <strong><i class="fa fa-user-tie"></i>&nbsp; Welcome: <?= ucfirst($_SESSION['logged_user']['name']); ?> </strong>  &nbsp; &nbsp; 
            <?php 
              $post_count ="SELECT * FROM `news` ";
                    $stmt = $conn->prepare($post_count);
                    $stmt->execute();
                    $count_posts = $stmt->rowCount();
                     ?>
            <strong><i class="fa fa-newspaper"></i>&nbsp; total news <span class="badge badge-info">
              <?= @$count_posts; ?>
            </span> </strong>
          </div>
          <hr>


          <br><hr>
          <h1>Available news</h1>
          <div class="row">
            <div class="col-md-12">
              
              <a href="insert-news.php" style="float: right; margin: 5px;" class="btn btn-sm btn-success">Add  news</a>
              <?php if (isset($_SESSION['message'])): ?>
                    <p style="float: left;" class="text-success"> <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>  </p>
              <?php endif ?>
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
                   $news ="SELECT * FROM `news` ORDER BY `id` DESC";
                    $stmt = $conn->prepare($news);
                    $stmt->execute();
                      if ($stmt->rowCount()>0) {
                           $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                           $id =1;
                           foreach ($rows as $key=> $value) {
                      
                   ?>
                  <tr>
                    <th scope="row"><?= $id++; ?></th> 
                    <td><?= $rows[$key]['title']; ?></td>
                    <td>
                      <a href="insert-news.php?edit_id=<?= $rows[$key]['id']; ?>" class="btn btn-primary">edit</a>
                      <a href="delete.php?del_id=<?= $rows[$key]['id']; ?>"  class="btn btn-danger">delete </a>
                     
                    </td>
                  </tr>

                  <?php 
                       }
                         }else {
                           echo ' <tr>
                                
                                <td colspan="4"> <h1 class="text-center text-capitalize "> no news </h1> </td>
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
 