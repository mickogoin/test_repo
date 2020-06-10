<?php

include_once 'header.php';



include 'navbar.php';
$outletUser = $_SESSION['branch'];
$s_date = 'Please choose';
$e_date = 'a date range';
$endgame_date = '';
$sum = 0;



if(isset($_POST['add']))
{

$date_s=date_create($_POST['start_date']);
$date_e=date_create($_POST['end_date']);
$s_date = date_format($date_s,'Y-m-d');
$e_date = date_format($date_e,'Y-m-d');
//query for category
$endgame_date = $e_date." 23:59:59";
$category_sql="SELECT orders.status, order_details.menu_id, menu.prod_name, orders.purchased_at, SUM(order_details.qty) AS qty_sum, menu.price, outlet_users.username 
                FROM orders 
                JOIN order_details ON orders.order_id = order_details.order_id 
                JOIN menu ON order_details.menu_id = menu.menu_id 
                JOIN category ON menu.category_id = category.category_id
                JOIN outlet_users ON orders.user_id = outlet_users.user_id 
                WHERE orders.purchased_at BETWEEN '$s_date' 
                AND '$endgame_date' 
                AND orders.status = 'delivered'
                --AND outlet_users.username = '$outletUser' 
                GROUP BY menu.prod_name";
}

if($outletUser != 'commi'){
  $category_sql="SELECT orders.status, order_details.menu_id, menu.prod_name, category.category_name, orders.purchased_at, SUM(order_details.qty) AS qty_sum, menu.price, outlet_users.username 
                FROM orders 
                JOIN order_details ON orders.order_id = order_details.order_id 
                JOIN menu ON order_details.menu_id = menu.menu_id 
                JOIN category ON menu.category_id = category.category_id
                JOIN outlet_users ON orders.user_id = outlet_users.user_id 
                WHERE orders.purchased_at BETWEEN '$s_date' 
                AND '$endgame_date' 
                AND orders.status = 'delivered'
                AND outlet_users.username = '$outletUser' 
                GROUP BY menu.prod_name";

$category_result=$connection->query($category_sql);

} else {
$category_sql="SELECT orders.status, order_details.menu_id, menu.prod_name, category.category_name, orders.purchased_at, SUM(order_details.qty) AS qty_sum, menu.price, outlet_users.username 
                FROM orders
                JOIN order_details ON orders.order_id = order_details.order_id 
                JOIN menu ON order_details.menu_id = menu.menu_id 
                JOIN category ON menu.category_id = category.category_id
                JOIN outlet_users ON orders.user_id = outlet_users.user_id 
                WHERE orders.purchased_at BETWEEN '$s_date'
                AND '$endgame_date'
                AND orders.status = 'delivered'
                GROUP BY menu.prod_name";

$category_result=$connection->query($category_sql);
}
?>


  <div id="wrapper">

  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Reports</a>
          </li>
          <li class="breadcrumb-item active"> 
          <?php 
          if($s_date != "Please choose" && $e_date != "a date range"){
            echo $date_created = date_format(date_create($s_date),"M d, Y")." to ".date_format(date_create($e_date), "M d, Y");
          } else {
            echo $s_date." ".$e_date;
          }
          ?>
          
          
          </li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Report Summary
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_category"><i class="fas fa-plus">&nbsp;</i> Generate Report</button>
              <table class="table table-bordered table-hover" id="dataTable_reports" width="100%" cellspacing="0">
                <thead>
                  <tr>
                  <th>Product Name</th>
                  <th>Category Name</th>
                  <th>Qty</th>
                  </tr>
                </thead>
                <!-- <tfoot>
                  <tr>
                  <th>Category Name</th>
                  <th>Category Name</th>
                  <th>Category Name</th>
                  </tr>
                </tfoot> -->
                <tbody>
                <!-- START PHP SCRIPT CATERGORY -->
                <?php while($row=$category_result->fetch_array()){
                  $sum += $row['qty_sum']; ?>
                  <tr>
                  <td><?php echo $row['prod_name']; ?></td>
                  <td><?php echo $row['category_name']; ?></td>
                  <td><?php echo $row['qty_sum']; ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td><b>Total quantity of :</b></td>
                    <td><b><?php echo $sum; ?></b></td>
                </tr>

                <!-- END PHP SCRIPT CATEGORY -->
                </tbody>
              </table>
              <h2>Total quantity of : <?php echo $sum; ?></h2>
            </div>
          </div>
          <div class="card-footer small text-muted"></div>
        </div>




  <!-- Add Category Modal-->
  <div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Report</h5>
      </div>
      <div class="modal-body">

      <form method="POST" class="form-inline">
      <label for="email" class=" mr-2"> Start Date </label> 
      <input type="text" id="startDate" class="form-control" width="150" name='start_date'  />
      <label for="email" class=" ml-2 mr-2"> End Date </label>  
      <input type="text" id="endDate" class="form-control" width="150" name='end_date'/>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i>Close</button>
      <button type="submit" name="add" class="btn btn-success"><i class="fa fa-redo">&nbsp;</i> Process Report </button>
      </form>
      </div>
    </div>
  </div>
</div>


<?php 
include 'footer.php';

include 'scripts.php'; 
?>

<script>
$('#dataTable').DataTable( {
  dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'csv', 'pdf'
        ]
} );
</script>

<script>
        var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
        $('#startDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            maxDate: function () {
                return $('#endDate').val();
            }
        });
        $('#endDate').datepicker({
            uiLibrary: 'bootstrap4',
            iconsLibrary: 'fontawesome',
            minDate: function () {
                return $('#startDate').val();
            }
        });
    </script>

<script>
$('#dataTable_reports').DataTable({
  "ordering": false,
  dom: 'Bfrtip',
        buttons: [
            'print', 'copy', 'csv'
        ]
});
</script>


</body>

</html>
