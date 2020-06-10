<?php

include_once 'header.php';

// include_once 'timeout.php';

include 'navbar.php';

//query for product
//$product_sql="SELECT * FROM menu WHERE hidden=0 ORDER BY menu_id ASC";
$product_sql="SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 ORDER BY menu.category_id ASC, prod_name ASC";
$product_result=$connection->query($product_sql);


if($_SESSION['role'] != 'admin'){
//query for orders
$outlet_filter = $_SESSION['branch'];
$order_sql="SELECT * FROM orders
            JOIN outlet_users ON orders.user_id = outlet_users.user_id
            WHERE outlet_users.username = '$outlet_filter'
            AND orders.status = 'delivered' 
            ORDER BY orders.delivered_at DESC";
$order_result=$connection->query($order_sql);
} else {
//query for orders
//$outlet_filter = $_SESSION['branch'];
// $order_sql="SELECT * FROM orders ORDER BY status ASC";

$order_sql="SELECT * FROM orders
            JOIN outlet_users ON orders.user_id = outlet_users.user_id
            WHERE orders.status = 'delivered' 
            ORDER BY orders.delivered_at DESC";



$order_result=$connection->query($order_sql);
}



if(!empty($_GET["action"])) {
  switch($_GET["action"]) {
      case "delivered":
          // unset($_SESSION["cart_item"]);
          $ido = $_GET["order_id"];
          $sql="UPDATE orders SET status='delivered' WHERE order_id = '$ido'";
          $connection->query($sql);
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
            <a href="#">History</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Order History List
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_order">Create Order</button> -->
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Issuing Outlet</th>
                    <th>Notes</th>
                    <th>Date Delivered</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Issuing Outlet</th>
                    <th>Notes</th>
                    <th>Date Delivered</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                <!-- START PHP SCRIPT CATERGORY -->
                <?php 
                while($row=$order_result->fetch_array()){
                ?>
                  <tr>
                    <td><?php echo ucfirst($row['username']); ?></td>
                    <td><?php echo $row['notes']; ?></td>
                    <td>
                    <?php 
                    $date_created = date_create($row['delivered_at']); 
                    // echo date_format($date_created, "M d, Y h:i:s A");
                    echo date_format($date_created, "Y-m-d H:i:s");
                    ?>
                    </td>
                    <td>
                    <a href="history_details_view.php?order_id=<?php echo $row['order_id'];?>" class="btn btn-success btn-sm"><i class="far fa-calendar">&nbsp;</i>Details</a> 

                    <?php
                    if($_SESSION['role'] == 'admin'){
                    ?>
                    <!-- | <a href="outlet_order_edit.php?order_id=<?php echo $row['order_id'];?>" class="btn btn-primary btn-sm"> <i class="fas fa-edit">&nbsp;</i>Update</a>  -->


                    <?php } ?>

                    <!-- OLD CONFIG  -->
                    <!-- <?php
                      if($row['status'] == 'updated')
                      {
                        if($_SESSION['role'] != 'admin'){
                    ?>
                          <button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="Order is updated by Commissary!">
                            Update
                          </button>

                        <?php } else { ?>

                          | <a href="outlet_order_edit.php?order_id=<?php echo $row['order_id'];?>" target="_blank"  class="btn btn-primary btn-sm">Update</a> 

                    <?php
                      } } else {
                    ?>
                    | <a href="outlet_order_edit.php?order_id=<?php echo $row['order_id'];?>" target="_blank"  class="btn btn-primary btn-sm">Update</a> 
                    |  <a href="#" data-toggle="modal" data-target="#delete_order<?php echo $row['order_id'];?>" class="btn btn-danger btn-sm">Delete</a>
                    <?php
                      } 
                    ?> -->

                    
                    
                    
                    <?php include 'order_history_modal.php'; ?>
                    </td>
                    
                  </tr>
                <?php } ?>
                <!-- END PHP SCRIPT CATEGORY -->
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted"></div>
        </div>



<?php 
include 'footer.php';

include 'scripts.php'; 
?>

<script>
$('#dataTable_modal').DataTable({
  "ordering": false,
  "searching": false,
  dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'csv'
        ]
});
</script>



</body>

</html>
