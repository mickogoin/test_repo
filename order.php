<?php
	include('database/db_config.php');
	include('session.php');
	if(isset($_POST['menu_id'])){
 
		$outlet=$_SESSION['userid'];
		$sql="INSERT INTO orders (user_id, purchased_at) VALUES ($outlet, NOW())";
		$connection->query($sql);
		$pid=$connection->insert_id; //product_id
 
		$total=0;
 
		foreach($_POST['menu_id'] as $menu): // GET POST MENU_ID ARRAY
		$proinfo=explode("||",$menu); // DIVIDE THE ARRAY WITH || 
		$menu_id=$proinfo[0]; // MENU ID VALUE FROM DIVIDED ARRAY
		$iterate=$proinfo[1]; // ITERATE VALUE FROM DIVIDED ARRAY
		$sql="SELECT * FROM menu WHERE menu_id='$menu_id'";
		$query=$connection->query($sql);
		$row=$query->fetch_array();
 
		if (isset($_POST['quantity_'.$iterate])){
			$subt=$row['price']*$_POST['quantity_'.$iterate];
			$total+=$subt;

			$sql="INSERT INTO order_details (order_id, menu_id, qty, qty_old) VALUES ('$pid', '$menu_id', '".$_POST['quantity_'.$iterate]."', '".$_POST['quantity_'.$iterate]."')";
			$connection->query($sql);
		}
		endforeach;
 		
 		$sql="UPDATE orders SET total='$total', status='pending' WHERE order_id='$pid'";
		$connection->query($sql);
		
		// send notification
		$branch = $_SESSION['branch'];
		$message = ucfirst($branch).' sent you an order!';
		$notif_sql = "INSERT INTO comments(send_to, comment_subject, comment_text)VALUES ('admin','$message', '')";
		$connection->query($notif_sql);


		header('location:order_view.php');		
	}
	else{
		?>
		<script>
			window.alert('Please select a menu');
			window.location.href='order_view.php';
		</script>
		<?php
	}
?>