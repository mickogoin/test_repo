<?php
	include('database/db_config.php');

	$id = $_GET['product_id'];

	$prod_delete_sql="UPDATE menu SET hidden=1 WHERE menu_id='$id'";
	$connection->query($prod_delete_sql);

	header('location:product_view.php');
?>