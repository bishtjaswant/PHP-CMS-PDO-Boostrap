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
              <li class="active"><a href="view-insert-news.php"> <i class="fas fa-edit"></i> View / insert news</a> </li>
              <li><a href="view-insert-category.php"> <i class="fas fa-chart-bar"></i> View / insert category</a> </li>
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
            <h1><i class="fa fa-newspaper"></i> &nbsp;Add new news</h1> 
              <strong><i class="fa fa-user-tie"></i>&nbsp; Welcome: <?= ucfirst($_SESSION['logged_user']['name']); ?> </strong>  &nbsp; &nbsp; 
             
          </div>
          <hr>


          <br><hr>
          <h1>Insert news</h1>
          <div class="row">
            <div class="col-md-6"> 
                <p class="text-danger"> 
                  <?php echo  @$_SESSION['insert_error']; 
                              unset($_SESSION['insert_error']); ?> </p>
            </div>
 
          </div>
          <div class="row">
            <div class="col-md-12">
              <form action="insert-news.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="newsname">News name</label>
                  <input type="text" class="form-control" name="title" placeholder="write your newws title" id="newsname"  required >
                  
                </div>
                <div class="form-group">
                   <div class="custom-file"> 
                      <input required type="file" name="image" class="custom-file-input" id="newsphoto">
                      <label class="custom-file-label" for="newsphoto">news photo</label>
                    </div>
                </div>
                 <div class="form-group">
                  <label for="newscategory">choose your category</label>
                   <select name="category" required id="newscategory" class="custom-select">
                       <option value="">select category </option> 

                     <?php  
                        $contact_count ="SELECT * FROM `categories` ORDER BY  `id` DESC";
                        $stmt = $conn->prepare($contact_count);
                        $stmt->execute();
                        foreach ($rows= $stmt->fetchAll(PDO::FETCH_ASSOC) as $key=>$value) {
                       ?>   
                        <option value="<?= $rows[$key]['id']; ?>"><?= $rows[$key]['name']; ?></option>
                        <?php   } ?>
                      </select>
                 </div>
                 <div class="form-group">
                   <label>News message</label>
                   <textarea style="margin-top: 0px; margin-bottom: 0px; height: 134px;resize: none;" class ="form-control" id="newsmessage" required placeholder="write relevent messsage for publish your news"  name="descriptions"></textarea>
                 </div>
                <button type="submit" name="add_news" style="float: right;" class="btn btn-primary">Add news</button>
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </div>

    <?php include_once 'assets/includes/footer.php'; ?>

    <?php 
/*Array ( [title] => gajab [category] => 3 [descriptions] => zsdrtyuikol [add_news] => )
Array ( [image] => Array ( [name] => beverage-3974294_1920.jpg [type] => image/jpeg [tmp_name] => /opt/lampp/temp/php4FmUAI [error] => 0 [size] => 533738 ) );
*/


          if (isset($_POST['add_news'])) {
             $title = htmlspecialchars(strip_tags($_POST['title']));
             $category = htmlspecialchars(strip_tags($_POST['category']));
             $descriptions = htmlspecialchars(strip_tags($_POST['descriptions']));

             /*fetching files*/
             $photo_name = $_FILES['image']['name']; 
             $photo_type = $_FILES['image']['type']; 
             $photo_temp_name = $_FILES['image']['tmp_name']; 
             $photo_size = $_FILES['image']['size']; 
             $photo_error = $_FILES['image']['error']; 
             // $max_size = 5242880 ;// 5 mb
             $max_size = 2097152 ; // 2 mb4

             if (isset($title) && isset($category)  && isset($descriptions)  && isset($photo_name)   ) {
                          // checkk the file size
              $get_extention  =  pathinfo($photo_name,PATHINFO_EXTENSION);
              
             
               // check file format
                if ( $get_extention==='jpg' or $get_extention==='jpeg' or  $get_extention==='png' ) {
                 

                   // file sise

                  if (  $photo_size > $max_size ) {
                          $_SESSION['insert_error']="your file size is too large";
                             
                  } else {
                      // upladed
                      $query = "INSERT INTO `news`( `title`, `descriptions`, `image`, `category` )
                       VALUES ( :title,:descriptions,:image,:category )";
                       $stmt = $conn->prepare($query);

                       $stmt->bindParam(':title', $title,PDO::PARAM_STR);               
                       $stmt->bindParam(':descriptions', $descriptions,PDO::PARAM_STR);               
                       $stmt->bindParam(':image', $photo_name,PDO::PARAM_STR);               
                       $stmt->bindParam(':category', $category,PDO::PARAM_INT);               
                    

                       if (    $stmt->execute() && move_uploaded_file($photo_temp_name, "images/".$photo_name) ) {
                          echo '<script>alert("your news has been published now");</script>';
                          header('Location: view-insert-news.php'); 
                                        
                                      } else {
                          $_SESSION['insert_error']="something  went wrong pls try again......./";
                                        
                                      }               

                  }

                      



                } else {
                  $_SESSION['insert_error']="invalid file format. file must be jpg,png,or jpeg";
                }
             }else {
               $_SESSION['insert_error']="all field are required";
             }


          }



     ?>