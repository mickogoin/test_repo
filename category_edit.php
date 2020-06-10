<?php
	include('database/db_config.php');

	$id=$_GET['category_id'];

	$cname=$_POST['category_name'];

	$update_category_sql="UPDATE category SET category_name='$cname' WHERE category_id='$id'";
	$connection->query($update_category_sql);

	header('location:category_view.php');
?>