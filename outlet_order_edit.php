<?php

include_once 'header.php';

include 'navbar.php';

if(isset($_POST['add']))
{
    $pname=$_POST['product_name'];
    $category=$_POST['category'];
    $price=$_POST['price'];
	

    $product_add_sql="INSERT INTO menu (prod_name, category_id, price) VALUES ('$pname', '$category','$price')";
    $connection->query($product_add_sql);
    header('location:product_view.php');
}






//query for orders
//$product_sql="SELECT * FROM menu WHERE hidden=0 ORDER BY menu_id ASC";
$order_sql="SELECT * FROM orders";
$order_result=$connection->query($order_sql);

if(isset($_GET['order_id']))
{
	$o_details_sql="SELECT * FROM order_details LEFT JOIN menu ON menu.menu_id=order_details.menu_id WHERE order_id=".$_GET['order_id'];
	$o_details_result=$connection->query($o_details_sql);
}








?>


  <div id="wrapper">

  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Orders</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Edit Ordering Page
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_order">Create Order</button> -->
	<form method="POST" action="order_update.php">
		<table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<th class="text-center" style="display:none;"><input type="checkbox" id="checkAll" checked ></th>
				<th>Prod Name</th>
				<th>Price</th>
				<th>Preferred Quantity</th>
				<th>Given Quantity</th>
			</thead>
			<tbody>
				<?php 
					$iterate=0;
					while($row=$o_details_result->fetch_array()){ 
						?>
						<tr>
							<input type="hidden" name="order_id" value="<?php echo $_GET['order_id'];?>">
							<td class="text-center" style="display:none;"><input type="checkbox" value="<?php echo $row['menu_id']; ?>||<?php echo $iterate; ?>" name="menu_id[]" checked style="display:none;"></td>
							<td><?php echo $row['prod_name']; ?></td>
							<td><?php echo $row['price']; ?></td>
							<td><input type="text" class="form-control" name="quantity_<?php echo $iterate; ?>" value="<?php echo $row['qty']; ?>" disabled></td>
							<td><input type="text" class="form-control" name="quantity_<?php echo $iterate; ?>" value="<?php echo $row['qty']; ?>"></td>
						</tr>
						<?php
						$iterate++;
					}
				?>
			</tbody>
		</table>
		
		<div class="row">
			<div class="col-md-3">
			<button type="button" class="btn btn-danger" onclick="history.go(-1);" data-dismiss="modal"><i class="fas fa-arrow-left">&nbsp;</i>  Go back </button>
			</div>
			<div class="col-md-2" style="margin-left:-20px;">
				<button type="submit" class="btn btn-primary ml-5"><span class="far fa-file"></span> Submit</button>
			</div>
		</div>
	</form>
            </div>
          </div>
          <div class="card-footer small text-muted"></div>
        </div>







<?php 
include 'footer.php';

include 'scripts.php'; 
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#checkAll").click(function(){
	    	$('input:checkbox').not(this).prop('checked', this.checked);
		});
	});
</script>

<script>
$('#dataTable').DataTable({
  "ordering": false,
  "bLengthChange": false,
  "bPaginate": false,
  "bProcessing": true,
  "bFilter": false
});
</script>


</body>

</html>
