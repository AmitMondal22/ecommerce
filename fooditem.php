<?php
session_start();

if (!isset($_SESSION['u_name'])) {
}
include "inc/dbh.inc.php";
?>

<?php
if (isset($_GET['order'])) {
  $store = $_GET['order'];

  if ($store == "submitted") {
    if (isset($_SESSION['cart'])) {
      foreach ($_SESSION['cart'] as $key => $value) {
        unset($_SESSION['cart'][$key]);
      }
    }
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1">
  <title>THE TAPHOUSE CLUB </title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <script src="https://kit.fontawesome.com/041a644664.js" crossorigin="anonymous"></script>
</head>

<body>
  <!--navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="height: 60px;">

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="aboutus.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="index.php?#contact">Contact Us</a>
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
        <?php if (isset($_SESSION['u_name'])) { ?>
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
              <a class="dropdown-item" href="userprofile.php">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Profile
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#orderModal">
                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                Orders
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
              </a>
            </div>
          </li>
        <?php } else { ?>
          <li class="" nav-item pr-1">
            <a href="./login.php" class="btn btn-light btn-outline-success btn-md" name="submit-search">Login
            </a>
          </li>

        <?php } ?>

      </ul>
    </div>
  </nav>
  <!--end navigation-->

  <?php if (isset($_SESSION['u_name'])) { ?>
  <!--logout model-->
  <div class="modal fade" id="orderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Your Order Lists</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Your Order details</div>
        <?php
        $user = $_SESSION['u_name'];
        $sql = "SELECT * FROM foodorders WHERE ordereduser = '$user' ORDER BY orderid DESC LIMIT 10;";
        $result = mysqli_query($con, $sql);
        $resultcheck = mysqli_num_rows($result);
        if ($resultcheck > 0) {
        ?>

          <table class="table table-responsive-md table-striped">
            <thead>
              <tr>
                <th>
                  Food name
                </th>
                <th>
                  Price
                </th>
                <th>
                  Quantity
                </th>
                <th>
                  Track
                </th>
              </tr>
            </thead>
            <tbody>
              <?php
              while ($row = mysqli_fetch_assoc($result)) {
              ?>
                <tr>
                  <td><?php echo $row['fname']; ?></td>
                  <td><?php echo $row['fprice']; ?></td>
                  <td><?php echo $row['qty']; ?></td>
                  <td><a href="trackorder.php?user=<?php echo $row['ordereduser']; ?>&orderid=<?php echo $row['orderid']; ?>" class="btn btn-success btn-sm">Track Order</a></td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        <?php
        }
        ?>
      </div>
    </div>
  </div>

  <?php } ?>
  <!--logout model-->

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

  <!--carasole code-->
  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/slide001.jpg" class="d-block w-100 img-responsive" alt="slider1" style="height: 250px;">
        <div class="carousel-caption d-none d-md-block">
          <h5><button>Play Game</button></h5>
          <p>To win exciting offers and Vouchers</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/slide002.jpg" class="d-block w-100 img-responsive" alt="slider2" style="height: 250px;">
        <div class="carousel-caption d-none d-md-block">
          <h5><button>Play Game</button></h5>
          <p>To win exciting offers and Vouchers</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/slide003.jpg" class="d-block w-100 img-responsive" alt="slider3" style="height: 250px;">
        <div class="carousel-caption d-none d-md-block">
          <h5><button>Play Game</button></h5>
          <p>To win exciting offers and Vouchers</p>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <!--carasole code-->

  <!--jumbotron code-->
  <div class="jumbotron text-center">
    <h1>Welcome To Food Court <i class="fas fa-utensils"></i></h1>

    <div id="grid">
      <div class="container-fluid">
        <h2>What would you like to have today?</h2>
        <div class="row justify-content-center pt-2 pb-5">

          <a class="btn btn-default btn-lg" href="fooditem.php"><i class="fas fa-utensils"></i> FOOD</a>
          <a class="btn btn-default btn-lg" href="beerlist.php"><i class="fas fa-beer"></i> BEER</a>
          <a class="btn btn-default btn-lg" href="winelist.php"><i class="fas fa-wine-bottle"></i> WINE</a>
          <a class="btn btn-default btn-lg" href="drinklist.php"><i class="fas fa-glass-water"></i> COLD DRINKS</a>
        </div>
      </div>
    </div>
    <!--jumbotron code-->

    <!--cart-->
    <div class="container-fluid">
      <?php
      //if (isset($_GET['order'])) {
      //  $store = $_GET['order'];
      // if ($store == "submitted") {
      //   echo "<p class='text-center alert alert-success'>Your Order Has Been Placed Successfully.</p>";
      // }
      //}
      ?>
      <div class="row">
        <?php
        $sql = "select * from foodlist where ftype = 'food' order by fid desc;";
        $result = mysqli_query($con, $sql);
        $resultcheck = mysqli_num_rows($result);

        if ($resultcheck > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            $check = $row['foodstatus'];
            $res = $row['frestaurents'];
            //echo $res;

            $q = "select * from restaurents where rname = '$res';";
            $qresult = mysqli_query($con, $q);
            $qresultcheck = mysqli_num_rows($qresult);
            if ($qresultcheck > 0) {
              while ($qrow = mysqli_fetch_assoc($qresult)) {
                $status = $qrow['status'];
                //echo $status;
                if ($status == "enable") {

        ?>

                  <div class="col-md-2 pb-2">

                    <form method="POST" action="inc/cartcheck.inc.php?fid=<?php echo $row['fid']; ?>">
                      <div class="card">
                        <img class="card-img-top img-fluid" style="height:200px;" src="uploads/<?php echo $row['fimage']; ?>" alt="foodimage">
                        <div class="card-body text-center">
                          <h4 class="card-title" style="font-size:20px;"><?php echo $row['fname']; ?></h4>
                          <h6 class="card-text">&#8377; <?php echo $row['fprice']; ?></h6>
                          <p class="card-text" style="font-size: 14px;"><?php echo $row['fdescription']; ?></p>

                          <p style="font-size: 15px;">Quantity: <select name="qty">
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                              <option>6</option>
                              <option>7</option>
                              <option>8</option>
                              <option>9</option>
                              <option>10</option>
                            </select></p>
                          <input type="text" name="Special requests" placeholder="Special requests" style="width: 150px;">
                          <input type="hidden" name="hidden_fname" value="<?php echo $row['fname'] ?>">
                          <input type="hidden" name="hidden_img" value="<?php echo $row['fimage']; ?>">
                          <input type="hidden" name="hidden_fprice" value="<?php echo $row['fprice'] ?>">
                          <input type="hidden" name="hidden_frestaurent" value="<?php echo $row['frestaurents'] ?>">
                          <?php
                          if ($check == 'available') {
                          ?>
                            <button class="btn btn-success" name="submit"><i class="fa fa-cart-plus"></i> Add To Cart</button>


                          <?php
                          } else {
                          ?>
                            <button class="btn btn-success disabled" name="submit" disabled><i class="fa fa-cart-plus"></i> Out Of Stock</button>
                          <?php
                          }
                          ?>



                        </div>
                      </div>
                    </form>

                  </div>
        <?php }
              }
            }
          }
        } ?>
      </div>
    </div>

    <!--end cart-->
    <!--script-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/fontawesome.min.js">
    </script>
    <!--end script-->

    <?php
    //echo "<pre>";
    //print_r($_SESSION);
    /* include 'footer.php'; */
    ?>