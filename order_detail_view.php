<?php
include_once 'header.php';
// include_once 'timeout.php';
include 'navbar.php';


if(isset($_GET['order_id']))
{
    $ord_id = $_GET['order_id'];
    $o_details_sql="SELECT menu.prod_name, menu.price, order_details.qty, order_details.qty_old, order_details.qty_status, category.category_name
                    FROM order_details 
                    LEFT JOIN menu ON menu.menu_id=order_details.menu_id 
                    LEFT JOIN category ON category.category_id=menu.category_id
                    WHERE order_id=$ord_id 
                    ORDER BY category.category_name ASC, menu.prod_name ASC";

    $o_details_result=$connection->query($o_details_sql);
}

$or_id = $_GET['order_id'];

if($_SESSION['role'] != 'admin'){
    //query for orders
    $outlet_filter = $_SESSION['branch'];
    $order_sql="SELECT * FROM orders
                JOIN outlet_users ON orders.user_id = outlet_users.user_id
                WHERE outlet_users.username = '$outlet_filter'
                AND orders.status != 'delivered' 
                AND orders.order_id = '$or_id'
                ORDER BY orders.purchased_at DESC";
    $order_result=$connection->query($order_sql);
    } else {
    //query for orders
    
    $order_sql="SELECT * FROM orders
                JOIN outlet_users ON orders.user_id = outlet_users.user_id
                WHERE orders.status != 'delivered' 
                AND orders.order_id = '$or_id'
                ORDER BY orders.purchased_at DESC";
    
    
    
    $order_result=$connection->query($order_sql);
}



if(!empty($_GET["action"])) {
  switch($_GET["action"]) {
      case "delivered":
          $ido = $_GET["order_id"];
          $sql="UPDATE orders SET status='delivered', delivered_at=NOW() WHERE order_id = '$ido'";
          $connection->query($sql);
          header('location:order_view.php');
      break;	

      case "in_transit":
          //initialize value from get
          $ido = $_GET["order_id"];
          $branch = $_GET["outlet"];
          //end initialize


          $sql="UPDATE orders SET status='In Transit', confirm_status=1 WHERE order_id = '$ido'";
          $connection->query($sql);
          // send notif to outlet
          $notif_sql = "INSERT INTO comments(send_to, comment_subject, comment_text)VALUES ('$branch','Order is on its way!', '')";
		      $connection->query($notif_sql);
          header('location:order_view.php');
      break;	

      case "confirm_delivery":
          //initialize value from get
          $ido = $_GET["order_id"];
          $branch = $_GET["outlet"];
          $notif_mes = ucfirst($branch)." has received their order.";
          //end initialize
          $sql="UPDATE orders SET confirm_status=2, status='delivered', delivered_at=NOW() WHERE order_id = '$ido'";
          $connection->query($sql);
          // send notif to commi
          $notif_sql = "INSERT INTO comments(send_to, comment_subject, comment_text)VALUES ('commi','$notif_mes', '')";
		      $connection->query($notif_sql);
          header('location:order_view.php');
      break;	
  }
  }

?>


  <div id="wrapper">

  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="order_view.php">Orders</a>
          </li>
          <li class="breadcrumb-item"> <a href="order_view.php"> Overview </a> </li>
          <li class="breadcrumb-item active"> Order Details </li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Orders Details
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_order">Create Order</button> -->
              <table class="table table-bordered table-hover getid" id="dataTable_modal" width="100%" cellspacing="0">
          
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                  </tr>
                </thead> 
                <tbody>
                <!-- START PHP SCRIPT CATERGORY -->
                <?php
                //order details query
                while($drow=$o_details_result->fetch_array()){ 
                ?>
                  <tr>
                    <td><?php echo $drow['prod_name']; ?></td>
                    <td><?php echo $drow['category_name']; ?></td>
                    <td><?php echo number_format($drow['price'], 2); ?></td>
                    <td>
                    <?php 
                    // condition if qty is out of stock
                    if($drow['qty'] > 0){ 
                      //condition if qty is updated by commissary then show that value
                      if($drow['qty_status'] == 0)
                      {
                        echo $drow['qty']; 
                      } else {
                        echo $drow['qty']." <label class='badge badge-info ml-1'> Previous qty ".$drow['qty_old']."</label>";
                      }
                      // end condition if qty is updated by commissary
                    }
                    else{
                      echo "<label class='badge badge-danger text-wrap'> out of stock </label>";
                    }
                    // end condition for out of stock status
                    
                    ?>
                    </td>
                    <td> &#8369;
                      <?php
                          $subt = $drow['price']*$drow['qty'];
                          echo number_format($subt, 2);
                      ?>
                    </td>
                  </tr>
                <?php } ?>
                <!-- END PHP SCRIPT CATEGORY -->
                <?php 
                while($row=$order_result->fetch_array()){
                $edit_id = $row['order_id'];
                $username_update = $row['username'];
                $ord_status = $row['status'];
                ?>
                <tr>
                    <td><b>TOTAL</b></td>
                    <td></td>
                    <td></td>
                        <!-- <td colspan="3"><b>TOTAL</b></td> -->
                      <td></td>
                      <td>&#8369; <?php echo number_format($row['total'], 2); ?></td>
                  </tr>
                  <tr>
                    <td> <b> Outlet: </b> </td>
                    <td> <?php echo ucfirst($row['username']); ?></td>
                    <td></td>
                        <!-- <td colspan="3"><b>TOTAL</b></td> -->
                      <td><b>Notes:</b></td>
                      <td> <?php echo $row['notes']; ?></td>
                  </tr>
                <?php } ?>
                </tbody>
            </table>
            </div>
          </div>
          <div class="card-footer small text-muted"> 
          <a href="order_view.php" class="btn btn-danger"><i class="fas fa-arrow-left">&nbsp;</i>  Go Back</a>
            <?php if($_SESSION['role'] != 'admin'){ ?>
            <?php if($ord_status == 'In Transit'){ ?>
                <a class="btn btn-success" href="order_detail_view.php?action=confirm_delivery&order_id=<?php echo $edit_id;?>&outlet=<?php echo $username_update;?>"> <i class="fas fa-check">&nbsp;</i> Confirm Delivered Goods</a>
            <?php } ?>
            <?php } else { ?>
            <a href="outlet_order_edit.php?order_id=<?php echo $edit_id;?>" class="btn btn-primary"> <i class="fas fa-edit">&nbsp;</i>Update</a>
            <a class="btn btn-success" href="order_detail_view.php?action=in_transit&order_id=<?php echo $edit_id;?>&outlet=<?php echo $username_update;?>"> <i class="fa fa-truck">&nbsp;</i>Deliver Order</a>
            <?php } ?>
          </div>
        </div>



<?php 
include 'footer.php';

include 'scripts.php'; 
?>

<script>
$('#dataTable_modal').DataTable({
  "ordering": false,
  dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'csv'
        ]
});
</script>

<script>
// for (i = 0 ; i <= <?php echo $number_of_orders ?>; i++) { 
// $('#dataTable_modal'+i).DataTable({
//   "ordering": false,
//   dom: 'Bfrtip',
//         buttons: [
//             'print', 'copy', 'csv'
//         ]
// });

// }
</script>




</body>

</html>
