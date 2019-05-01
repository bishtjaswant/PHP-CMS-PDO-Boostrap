<?php 
session_start();
 

// if user  loggedd in then redirect to dashboarsd
if ( isset($_SESSION['logged_user'] )) {
  header("Location: index.php");
}



if (isset($_POST['login'])) {
  /*Array ( [email] => SDHJ@GMAIL.IN [password] => QWEDF [login] => )*/
  $email = htmlspecialchars(strip_tags(trim( $_POST['email']  )));
  $password = htmlspecialchars(strip_tags(trim( $_POST['password']  )));
  $login_error =[];


    if ( ! empty($email) &&  ! empty($password)) {
         require_once 'config/db.php';
         $sql = "SELECT * FROM `admin` WHERE `admin`.`email` = :email";
         $stmt = $conn->prepare($sql);
         $stmt->execute([':email'=> $email]);
           if ($stmt->rowCount()>0) {
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password, $rows['password'])) {
                  // create login session
                  $_SESSION['logged_user']= [
                    'name'=> $rows['name'],
                    'id'=> $rows['id']
                  ];


                  session_regenerate_id(true);
                  header("Location: index.php");
                
                } else {
                  $login_error[]="incorrect password";
                }
             } else {
               $login_error[]=  'invalid email address';
             }
    } else {
      $login_error[]="please enter your email or password";
    }
}

 ?>

<html>
  <head>
<link rel="stylesheet" type="text/css" href="assets/css/login.css">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
  </head>
<body id="LoginForm">
<div class="container">
<h1 class="form-heading">Admin Panel</h1>
<div class="login-form">
<div class="main-div">
    <div class="panel">
   <h2>Admin Login</h2>
   <p>Please enter your email and password</p>
   </div>
    <form id="Login" action="login.php" method="POST">

        <div class="form-group">


            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email Address">

        </div>

        <div class="form-group">

            <input type="password"  name="password" class="form-control" id="inputPassword" placeholder="Password">

        </div>
        
        <button type="submit" name="login" class="btn btn-primary">Login</button>

        <?php if (isset($login_error)): ?>
              <?php foreach ($login_error as $error): ?>
              <p class="text-center text-danger"> <?= $error; ?> </p>
              <?php endforeach ?>
        <?php endif ?>

    </form>
    </div> 
</div></div></div>


</body>
</html>
