<?php
session_start();
if (!isset($_SESSION['u_name'])) {
  /*  header("location: login.php");  */
}
include "inc/dbh.inc.php";
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1">
  <title>The local Taphouse </title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <script src="https://kit.fontawesome.com/041a644664.js" crossorigin="anonymous"></script>
</head>

<body>
  <!--navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">
    <!-- <a class="navbar-brand" href="index.php">The local Taphouse </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button> -->

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="aboutus.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="#contact">Contact Us</a>
        </li>

      </ul>
      <a class="navbar-brand" href="index.php"><img src="images/logo.png" style="height: 50px;" class="img-fluid" alt="logo"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item pr-1">
          <form method="POST" class="form-inline mt-1" action="search.php">
            <input type="text" name="search" placeholder="search" class="form-control mr-1">
            <button class="btn btn-light btn-outline-success btn-md" name="submit-search"><i class="fas fa-search"></i>
            </button>
          </form>
        </li>
        </li>
        <li class="nav-item pr-1">
          <form method="POST" class="form-inline mt-1" action="cart.php">
            <button class="btn btn-light btn-outline-success btn-md"><a href='cart.php'><i class="fas fa-cart-plus"></i></a>
              <?php
              $total_quantity = 0;
              if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item) {
                  $total_quantity += $item['item_qty'];
                }
              }
              ?>
              <span class="badge badge-danger"><?php echo $total_quantity; ?></span>
            </button>
          </form>
        </li>

        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
              <?php if (isset($_SESSION['u_name'])) {
                echo $_SESSION['u_name'];
              } ?>
            </span>
            <?php if (isset($_SESSION['profile'])) { ?>
              <img class="img-profile rounded-circle" src="./uploads/<?php echo $_SESSION['profile']; ?>" style="height: 2rem; width: 2rem;">

            <?php } ?>
          </a>

          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="admin_profile.php">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!--end navigation-->

  <!--orderdetails model-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below to end your current session</div>

        <form method="POST" action="inc/logout.inc.php">
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <button class="btn btn-danger" name="submit">Logout</button>
          </div>
        </form>

      </div>
    </div>
  </div>
  <!--orderdetails model-->

  <div class="jumbotron pt-3" style="height: 110px;">
    <h1>Your Shopping Cart</h1>
    <p>Looks Tasty!!!</p>
  </div>

  <div class="container">
    <table class="table table-responsive-md table-striped justify-content-center mb-5">
      <thread>
        <tr>
          <th>Food Name</th>
          <th>Food Image</th>
          <th>Quantity</th>
          <th>Price</th>
          <th>Order Total</th>
          <th>Action</th>
        </tr>
      </thread>
      <tbody class="mytbl">
        <?php
        if (!empty($_SESSION['cart'])) {
          if (!empty($_SESSION['u_name'])) {
          $total = 0;
          foreach ($_SESSION['cart'] as $key => $value) {
        ?>

            <tr>
              <td><?php echo $value['item_fname']; ?><br>
              <td><img src="uploads/<?php echo $value['item_img']; ?>" height='50px'></td>
              <td><?php echo $value['item_qty']; ?></td>
              <td>&#8377; <?php echo $value['item_fprice']; ?></td>
              <td>&#8377; <?php echo number_format($value['item_qty'] * $value['item_fprice'], 2); ?></td>
              <td><a class="btn btn-danger btn-sm" href="inc/deletecart.inc.php?cart=delete&id=<?php echo $value['item_fid']; ?>"><i class="fa fa-trash-alt"></i> Remove</a></td>
            </tr>

          <?php
            $total = $total + ($value['item_qty'] * $value['item_fprice']);
          }
          ?>

          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>Total - </b>&#8377; <?php echo number_format($total, 2); ?></td>

          </tr>
          <tr>
            <td><a href="foodlist.php" class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Add More</a></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>


            <?php
            $img = $_SESSION['u_name'];
            $avatar = "select profile from users where username = '$img';";
            $result = mysqli_query($con, $avatar);
            if ($row = mysqli_fetch_assoc($result)) {
            ?>

              <td><a class="btn btn-success btn-sm" href="payment.php" data-toggle="modal" data-target="#add-onModal">
                  <i class="fas fa-cart-arrow-down"></i>
                  Checkout
                </a></td>
              <!-- <td><a href="recommendations.php" class="btn btn-success btn-sm"><i class="fas fa-cart-arrow-down"></i> CheckOut</a></td>
                     -->
              <div class="modal fade" id="add-onModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title text-center" id="exampleModalLabel">People also ordered</h5>
                      <button class="close" type="button" data-dismiss="modal" href="payment.php" aria-label="Close">

                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <?php
                      // Sample data for recommendations

                      $recommendations = [
                        [
                          'id' => 1,
                          'name' => 'Swell Season Rose',
                          'image' => '8.avif',
                          /* 'description' => 'Delicious pizza with your choice of toppings.', */
                          'price' => 10.99,
                        ],
                        [
                          'id' => 2,
                          'name' => 'Coke',
                          'image' => '10.avif',
                          /*  'description' => 'Juicy burger with your choice of toppings.', */
                          'price' => 2.00,
                        ],
                        [
                          'id' => 3,
                          'name' => 'Stomping Ground Big Sky Hazy P',
                          'image' => '6.avif',
                          'price' => 5.99,
                        ],
                      ];

                      // Render the recommendations page
                      ?>
                      <form method="POST" action="inc/cartcheck.inc.php?fid=<?php //echo $row['fid']; 
                                                                            ?>">

                        <div class="recommendations">
                          <h4 class="text-center">Try these!!</h4>
                          <ul>
                            <?php foreach ($recommendations as $recommendation) : ?>
                              <!-- <li> -->
                              <img style="height:50px;" src="uploads/<?= $recommendation['image']; ?>" alt="<?= $recommendation['name']; ?>">
                              <p><b><?= $recommendation['name']; ?></b>
                                $<?= $recommendation['price']; ?></p>


                              <!-- </li> -->
                            <?php endforeach; ?>
                            <a href="foodlist.php" class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Add Sides</a>
                            <a href="Payment.php" class="btn btn-danger"> Skip and Checkout</a>
                          </ul>
                        </div>
                      </form>
                    </div>

                  </div>

                </div>
              </div>
              <!-- Add-on Modal -->

            <?php
            } else {
            ?>
              <!-- <td><a href="login.php" class="btn btn-success btn-sm"><i class="fas fa-cart-arrow-down"></i> CheckOut</a></td> -->
              <td><a class="btn btn-success btn-sm" href="#" data-toggle="modal" data-target="#login-Modal">
                  <i class="fas fa-cart-arrow-down"></i>
                  Checkout
                </a></td>

              <!-- login-modal -->

              <div class="modal fade" id="login-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title text-center" id="exampleModalLabel">Login to see best offers</h3>
                      <button class="close" type="button" data-dismiss="modal" href="#" aria-label="Close">

                        <span aria-hidden="true">×</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="inc/login.inc.php" class="pb-2">
                        <legend style="border: 1px solid black; border-radius: 6px; color: black; font-size: 20px; font-weight: 500; margin: 0 auto;" class="pl-3 pr-3 pb-3 pt-6">
                          <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="uname" autocomplete="off" placeholder="username" class="form-control">
                          </div>
                          <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="pwd" autocomplete="off" placeholder="password" class="form-control">
                          </div>
                          <button class="btn btn-default btn-md" name="submit"><a href="cart.php">Login</a></button>
                          <span class="pl-2 pr-2" style="font-weight: 700; font-size: 15px;">Or</span>
                          <a href="gmaillogin/login.php"><img src="uploads/sign-in-with-google.png" style="height: 40px; width: 130px;" /></a>
                          <span class="pl-2 pr-2" style="font-weight: 700; font-size: 15px;">Or</span>
                          <a class="btn btn-default btn-md" href="signup.php">SignUp</a>
                          <span class="pl-2 pr-2" style="font-weight: 700; font-size: 15px;">Or</span>
                          <a class="btn btn-default btn-md" href="payment.php">Guest</a>
                        </legend>

                      </form>
                    </div>
                  </div>
                </div>


                <!-- end login-modal -->
              <?php
            }
              ?>





          </tr>
        <?php
        } else {
          echo "<script>alert('Oops! your shopping cart is empty. Try Add Some Items')</script>";
          echo "<script>window.location='login.php'</script>";
        }
        } else {
          echo "<script>alert('Oops! your shopping cart is empty. Try Add Some Items')</script>";
          echo "<script>window.location='foodlist.php'</script>";
        }
        ?>
      </tbody>
    </table>

  </div>
  </div>
  <!--script-->
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/fontawesome.min.js">
  </script>
  <!--end script-->

  <?php
  //echo '<pre>';
  //print_r($_SESSION);
  /* include "footer.php"; */
  ?>