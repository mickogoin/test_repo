<?php
	include('database/db_config.php');
	if(isset($_POST['menu_id'])){
 
        $order_id = $_POST['order_id'];
 
		$total=0;

		$noti_mes = '';
 
		foreach($_POST['menu_id'] as $menu):
		$proinfo=explode("||",$menu);
		$menu_id=$proinfo[0];
		$iterate=$proinfo[1];
		$sql="SELECT * FROM menu WHERE menu_id='$menu_id'";
		$query=$connection->query($sql);
		$row=$query->fetch_array();
 
		if (isset($_POST['quantity_'.$iterate])){
			$subt=$row['price']*$_POST['quantity_'.$iterate];
			$total+=$subt;

			//compare if editted or not 
			$sql_check_status = "SELECT * FROM order_details WHERE order_id=$order_id AND menu_id = $menu_id";
			$query_cs=$connection->query($sql_check_status);
			$row_cs=$query_cs->fetch_array();
			if($_POST['quantity_'.$iterate] == $row_cs['qty']){
				$q_status = 0;
			} else {
				$q_status = 1;
			}
			// end compare if editted or not
			
			//$combined = $_POST['quantity_'.$iterate];
			
			

			$sql="UPDATE order_details SET qty_old = '".$row_cs['qty']."', qty = '".$_POST['quantity_'.$iterate]."', qty_status = $q_status WHERE order_id='$order_id' AND menu_id='$menu_id'";
			$connection->query($sql);
		}
		endforeach;
 		
 		$sql="UPDATE orders SET total='$total', status='updated' WHERE order_id='$order_id'";
		$connection->query($sql);
		//select a recepient
		// old query
		// $send_sql="SELECT * FROM orders WHERE order_id='$order_id'";
		$send_sql = "SELECT * FROM orders
					 JOIN outlet_users ON orders.user_id = outlet_users.user_id
					 WHERE orders.order_id = '$order_id'";

		$send_query=$connection->query($send_sql);
		$send_row=$send_query->fetch_array();
		$branch=$send_row['username'];
		
		// send notification
		$notif_sql = "INSERT INTO comments(send_to, comment_subject, comment_text)VALUES ('$branch','Order has been updated!', '')";
		$connection->query($notif_sql);

		header('location:order_view.php');		
	}
	else{
		?>
		<script>
			window.alert('Please select a menu');
			window.location.href='outlet_order_edit.php';
		</script>
		<?php
	}
?>