<?php
include('database/db_config.php');
include('session.php');


// $s_date = date('Y-m-d h:i:s',strtotime($_POST['start_date']));
// $e_date = date('Y-m-d h:i:s',strtotime($_POST['end_date']));



$date_s=date_create($_SESSION['start_date']);
$date_e=date_create($_SESSION['end_date']);


$s_date = date_format($date_s,'Y-m-d');
$e_date = date_format($date_e,'Y-m-d');

//echo 'start date'.$s_date.' end date '.$e_date;



if(isset($_POST['view_report'])){
//$query = "SELECT * FROM orders WHERE purchased_at BETWEEN '$s_date' AND '$e_date'";
$query = "SELECT orders.status, order_details.menu_id, menu.prod_name, orders.purchased_at, SUM(order_details.qty) AS qty_sum, menu.price, outlet_users.username 
FROM orders 
JOIN order_details ON orders.order_id = order_details.order_id 
JOIN menu ON order_details.menu_id = menu.menu_id 
JOIN outlet_users ON orders.user_id = outlet_users.user_id 
WHERE orders.purchased_at >= '$s_date' 
AND orders.purchased_at < '$e_date' 
AND outlet_users.username = 'lm_makati' 
GROUP BY menu.prod_name";

$result = mysqli_query($connection, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_array($result))
{
  $output .= '
  <tr>
  <td>'.$row["prod_name"].'</td>
  <td>'.$row["prod_name"].'</td>
  <td>'.$row["qty_sum"].'</td>
  </tr>
  ';
}
}
else{
    $output .= '<td colspan=3 align=center>Record not found.</td>';
}
$data = array(
   'gen_report' => $output
);
echo json_encode($data);
}
?>