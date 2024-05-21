<?php
include 'header.php';
?>
<div class="jumbotron">
  <h1>Hi Guest,<br> Welcome to <span style="color:green;">THE LOCAL TAPHOUSE MELBOURNE AIRPORT</span></h1>
  <p class="pt-3" style="font-size: 21px;">Kindly LOGIN to continue.</p>
</div>

<div class="container">
  <div class="row">
    <div class="login col-md-6">

    <?php
       if (isset($_GET['login'])) {
         $logincheck = $_GET['login'];
         if ($logincheck == "invalidentry") {
          echo "<p class='text-center alert alert-danger'>Kindly Check Your Username & Password</p>";
        }
        elseif ($logincheck == "emptyfields") {
          echo "<p class='text-center alert alert-danger'>You'll Need To Fill Up All The Details Inorder to Login</p>";
        }
        elseif ($logincheck == "invalidaccess") {
          echo "<p class='text-center alert alert-danger'>invalid access</p>";
        }
       }  
    ?>

  
    <?php
          if (isset($_GET['signup'])) {
            $errorcheck = $_GET['signup'];
            if ($errorcheck == "success"){
              echo "<p class='text-center alert alert-success'> Signed up successfully </p>";
            }
          }
    ?>  

  
      <form method="POST" action="inc/login.inc.php" class="pb-5">
        <legend style="border: 1px solid black; border-radius: 6px; color: black; font-size: 20px; font-weight: 500; margin: 0 auto;" class="pl-3 pr-3 pb-3 pt-1" >Login
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="uname" autocomplete="off" placeholder="username" class="form-control">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="pwd" autocomplete="off" placeholder="password" class="form-control">
          </div>
          <button class="btn btn-default btn-md" name="submit">Login</button>
          <span class="pl-2 pr-2" style="font-weight: 700; font-size: 15px;">Or</span>
          <a href= "gmaillogin/login.php"><img src="uploads/sign-in-with-google.png" style="height: 40px; width: 130px;"/></a>
          <span class="pl-2 pr-2" style="font-weight: 700; font-size: 15px;">Or</span>
          <a class="btn btn-default btn-md" href="signup.php">SignUp</a>
          <span class="pl-2 pr-2" style="font-weight: 700; font-size: 15px;">Or</span>
          <a class="btn btn-default btn-md" href="payment.php">Guest</a>
        </legend>
      </form>
    </div>
  </div>
</div>

<!---login with Google----->
  <div class="container">
   
   <!-- <a class="btn btn-default btn-md">Login with Google</a> -->
   <!-- <h2 align="center">Login using Google Account with PHP</h2>  -->
  
   <!-- <div class="panel panel-default">
   <?php
   /* if(!empty($_SESSION['access_token']))
   {
    echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
    echo '<img src="'.$_SESSION['profile_picture'].'" class="img-responsive img-circle img-thumbnail" />';
    echo '<h3><b>Name : </b>'.$_SESSION["first_name"].' '.$_SESSION['last_name']. '</h3>';
    echo '<h3><b>Email :</b> '.$_SESSION['email_address'].'</h3>';
    echo '<h3><a href="logout.php">Logout</h3></div>';
   }
   else
   {
    echo '<div align="center">'.$login_button . '</div>';
   } */
   ?>
   </div>
  </div> -->
<!---login with Google----->


          <!--script-->
 <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/fontawesome.min.js">
    </script>
    <!--end script-->





          









<?php
/* include 'footer.php'; */
?>