<?php


    
	if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
		include "dbh.inc.php";
		session_start();
		$grandtotal = 0;
		 foreach ($_SESSION['cart'] as $key => $value) {
	
    $fid = $_POST['item_fid'];
 		$fname = $_POST['item_fname'];
 		$fprice = $_POST['item_fprice'];
 		$fqty = $_POST['item_qty'];
 		$frestaurent = $_POST['item_frestaurent'];
 		$total = ($value['item_fprice'] * $value['item_qty']);
 		$user = $_SESSION['u_name'];
 		$orderdate = date('y-m-d');
 		$payment_type = 'online';
 		$res_status = 'waiting';

 		$grandtotal = $grandtotal + ($value['item_qty'] * $value['item_fprice']);        
        
            $run = "insert into foodorders (fid, fname, fprice, frestaurent, qty, ordereduser, totalprice, ordered_date, payment_type, res_status) 
 		    values ('$fid', '$fname', '$fprice', '$frestaurent', '$fqty', 
 	 	    '$user', '$total', '$orderdate', '$payment_type', '$res_status');";

 	 	     mysqli_query($con,$run);
		 }
		}