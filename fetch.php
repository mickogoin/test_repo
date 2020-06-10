<?php
include('database/db_config.php');
include('session.php');

$branch = $_SESSION['branch'];

if(isset($_POST['view'])){
// $con = mysqli_connect("localhost", "root", "", "notif");
if($_POST["view"] != '')
{
   $update_query = "UPDATE comments SET comment_status = 1 WHERE comment_status=0 AND send_to='$branch'";
   mysqli_query($connection, $update_query);
}
$query = "SELECT * FROM comments WHERE send_to='$branch' ORDER BY comment_id DESC LIMIT 5";
$result = mysqli_query($connection, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_array($result))
{
  $output .= '
  <a a class="dropdown-item" href="order_view.php">
  <strong>'.$row["comment_subject"].'</strong><br />
  <small>'.date('M d, Y h:i A', strtotime($row["created_at"])).'</small>
  </a>
  ';
}
}
else{
    $output .= '<li><a href="#" class="text-bold text-italic">No Noti Found</a></li>';
}
$status_query = "SELECT * FROM comments WHERE comment_status=0 AND send_to='$branch'";
$result_query = mysqli_query($connection, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);
echo json_encode($data);
}
?>