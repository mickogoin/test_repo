<?php

include_once 'header.php';

// include_once 'timeout.php';

include 'navbar.php';

//query for product
$product_sql="SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 ORDER BY menu.category_id ASC, prod_name ASC";
$product_result=$connection->query($product_sql);


if($_SESSION['role'] != 'admin'){
//query for orders
$outlet_filter = $_SESSION['branch'];
$order_sql="SELECT * FROM orders
            JOIN outlet_users ON orders.user_id = outlet_users.user_id
            WHERE outlet_users.username = '$outlet_filter'
            AND orders.status != 'delivered'
            ORDER BY orders.purchased_at DESC";
$order_result=$connection->query($order_sql);
} else {
//query for orders

$order_sql="SELECT * FROM orders
            JOIN outlet_users ON orders.user_id = outlet_users.user_id
            WHERE orders.status != 'delivered' 
            ORDER BY orders.purchased_at DESC";



$order_result=$connection->query($order_sql);
$number_of_orders = mysqli_num_rows($order_result);
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
          <li class="breadcrumb-item active">Overview</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Orders List
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_order">Create Order</button> -->
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Issuing Outlet</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Order Submitted</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Issuing Outlet</th>
                    <th>Notes</th>
                    <th>Status</th>
                    <th>Order Submitted</th>
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
                    <td <?php if($row['confirm_status'] == 1) { ?>  data-toggle="tooltip" data-placement="top" title="Order is on its way. Awaiting outlet's confirmation." <?php } ?>>
               
                    <?php if($row['confirm_status'] != 2) {?>
                    <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?php if($row['confirm_status'] == 0) { echo '0%'; } elseif($row['confirm_status'] == 1) { echo '50%'; } elseif($row['confirm_status'] == 2) { echo '100%'; }?>"aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>

                    <?php 
                    }

                    if($row['status'] == 'pending'){
                      echo "<label class='badge badge-warning '>".ucfirst($row['status'])."</label>"; 
                    } elseif($row['status'] == 'updated') {
                      echo "<label class='badge badge-info '>".ucfirst($row['status'])."</label>"; 
                    } elseif($row['status'] == 'In Transit') {
                      echo "<label class='badge badge-primary '>".$row['status']."</label>"; 
                    } elseif($row['status'] == 'delivered') {
                      echo "<label class='badge badge-success '>".$row['status']."</label>"; 
                    }
                    ?>

                    </td>
                    <td>
                    <?php 
                    $date_created = date_create($row['purchased_at']); 
                    echo date_format($date_created, "Y-m-d H:i:s");
                    ?>
                    </td>
                    <td>
                    <!-- <a href="#" data-toggle="modal" onclick="copyId()" data-target="#order_details<?php echo $row['order_id'];?>" class="btn btn-success btn-sm"><i class="far fa-calendar">&nbsp;</i>Details <?php echo $row['order_id'];?></a>  -->
                    <a href="order_detail_view.php?order_id=<?php echo $row['order_id'];?>" class="btn btn-success btn-sm"><i class="far fa-calendar">&nbsp;</i>Details</a>
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
