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
              <li><a href="view-insert-category.php"> <i class="fas fa-chart-bar"></i> View / insert category</a> </li>
              <li class="active"><a href=""> <i class="fas fa-desktop"></i> Change password</a> </li>
              
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
            <h1><i class="fa fa-unlock-alt"></i> &nbsp;Change password</h1>
           
          </div>
          <hr>


          <br><hr>
        
          <div class="row">
            <div class="col-md-12">
          
              <form method="POST" action="change-password.php">

                    <div class="form-group">
                      <label for="oldpassword">type current password</label>
                      <input type="text" name="oldpassword" class="form-control" id="oldpassword" placeholder="current password">
                    </div>

                     <div class="form-group">
                      <label for="newpassword">type new password</label>
                      <input type="text" name="newpassword" class="form-control" id="newpassword" placeholder="new password">
                    </div>

                       <div class="form-group">
                      <label for="confirmednewpassword">type confirm new password</label>
                      <input type="text" name="confirmednewpassword" class="form-control" id="confirmednewpassword" placeholder="confirm new password">
                    </div>

                    <input type="submit" name="savepassword" class="btn btn-success"  value="save changes">
                    
                    <output id="password_error" class="text-primary" style="position: absolute;left: 50%; font-size: 22px; font-weight: bold;">  </output>


                  
                  </form>

          </div>
        </div>
        
      </div>
    </div>
 

    <?php include_once 'assets/includes/footer.php'; ?>

    <?php 
 if (isset($_POST['savepassword'])) {
             $oldpassword = htmlspecialchars(strip_tags($_POST['oldpassword']));
             $newpassword = htmlspecialchars(strip_tags($_POST['newpassword']));
             $confirmednewpassword = htmlspecialchars(strip_tags($_POST['confirmednewpassword']));

             if (  ! empty($oldpassword) && ! empty($newpassword) && ! empty($confirmednewpassword)   ) {
               
             $stmt = $conn->prepare("SELECT * FROM `admin`  WHERE `admin`.`id` =:id");
             $admin_id = $_SESSION['logged_user']['id'];

             $stmt->execute([':id'=>$admin_id]);

                   if ( $stmt->rowCount()>0 ) {
                              $row = $stmt->fetch(PDO::FETCH_ASSOC);
                               
                               // check existing pwd
                              if ( password_verify($oldpassword,$row['password'])  ) {
                                     
                                     // Againn check new or confirm passwrd
                                  if ( $newpassword != $confirmednewpassword ) {
                                       echo '<script>
                                        document.getElementById("password_error").innerHTML =" new password did not matched";
                                    </script>';
                                  } else {
                                        // check pwd length
                                        
                                        if (strlen($newpassword)< 8 ) {
                                          echo '<script>
                                        document.getElementById("password_error").innerHTML ="your password should be 8 characters long to secure your account";
                                    </script>';
                                        } else {
                                          // finally save intto db
                                            $pwd_query = "UPDATE `admin` SET `password`=:admin_new_password WHERE `admin`.`id` = :id ";

                                            $stmt = $conn->prepare($pwd_query);
                                            $hash_password = password_hash($newpassword, PASSWORD_BCRYPT );
                                            $stmt->bindParam(':admin_new_password', $hash_password, PDO::PARAM_STR);
                                             $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);

                                            $stmt->execute();

                                            if ($stmt->rowCount()>0) {
                                                echo '<script>
                                        document.getElementById("password_error").innerHTML ="your password successfully changed";
                                    </script>';
                                            } else {
                                                echo '<script>
                                        document.getElementById("password_error").innerHTML ="something went wrong.......please try again after some time";
                                    </script>';
                                            }


                                        }

                                  }
                              } else {
                                echo '<script>
                                    document.getElementById("password_error").innerHTML =" Invalid old password";
                                </script>';
                              }
                   } else {
                     header("Location: index.php");
                   }

             } else {
               echo '<script>
                              document.getElementById("password_error").innerHTML ="All fields are required to proceed......";
                          </script>';
             }


  }
     ?>