<?php
	include('database/db_config.php');

	$id = $_GET['category_id'];

	$category_delete_sql="UPDATE category SET hidden=1 WHERE category_id='$id'";
	$connection->query($category_delete_sql);

	header('location:category_view.php');
?>