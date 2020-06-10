<?php
	include('database/db_config.php');

	$id=$_GET['product_id'];

	$pname=$_POST['product_name'];
	$pcat=$_POST['category'];
	$pprice=$_POST['price'];
    $prod_code=$_POST['prod_code'];

	$update_product_sql="UPDATE menu SET category_id='$pcat', prod_name='$pname', prod_code='$prod_code', price='$pprice' WHERE menu_id='$id'";
	$connection->query($update_product_sql);

	header('location:product_view.php');
?>