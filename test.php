<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
include_once 'header.php';

// include_once 'timeout.php';

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

//query for product
//$product_sql="SELECT * FROM menu WHERE hidden=0 ORDER BY menu_id ASC";
$product_sql="SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 ORDER BY category.category_name ASC, menu.prod_name ASC";
$product_result=$connection->query($product_sql);

//query for orders
//$product_sql="SELECT * FROM menu WHERE hidden=0 ORDER BY menu_id ASC";
// $order_sql="SELECT * FROM orders";
// $order_result=$connection->query($order_sql);


if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 AND menu_id='" . $_GET["menu_id"] . "' ORDER BY category.category_name ASC, menu.prod_name ASC");



                $itemArray = array($productByCode[0]["menu_id"]=>array('menu_id'=>$productByCode[0]["menu_id"],'prod_name'=>$productByCode[0]["prod_name"], 'category_name'=>$productByCode[0]["category_name"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));
                
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["menu_id"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode[0]["menu_id"] == $k) {
                                    if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                    }
                                    $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                                    
                                }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
        break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["menu_id"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;
        case "checkout":
            // if(!empty($_SESSION["cart_item"])) {

            //                 $outlet=$_SESSION['userid'];
            //                 $sql="INSERT INTO orders (user_id, purchased_at) VALUES ($outlet, NOW())";
            //                 $connection->query($sql);
            //                 $pid=$connection->insert_id;

            //                 $total=0;

            //     foreach($_SESSION["cart_item"] as $k => $v) {


            //                 $sql="SELECT * FROM menu WHERE menu_id='".$v["menu_id"]."'";
            //                 $query=$connection->query($sql);
            //                 $row=$query->fetch_array();
                            

            //                 $subt=$row['price']*$v["quantity"];
            //                 $total+=$subt;


            //                 $db_handle->storeProd("INSERT INTO order_details (order_id, menu_id, qty, qty_old) VALUES ('$pid', '".$v["menu_id"]."', '".$v["quantity"]."', '".$v["quantity"]."')");

            //                 // $connection->query($sql);		
            //             // if(empty($_SESSION["cart_item"]))
            //             // 	unset($_SESSION["cart_item"]);
            //     } //end foreach
            //                 $sql="UPDATE orders SET total='$total', status='pending' WHERE order_id='$pid'";
            //                 $connection->query($sql);
                            
            //                 // send notification
            //                 $branch = $_SESSION['branch'];
            //                 $message = ucfirst($branch).' sent you an order!';
            //                 $notif_sql = "INSERT INTO comments(send_to, comment_subject, comment_text)VALUES ('commi','$message', '')";
            //                 $connection->query($notif_sql);
            //                 header('location:order_view.php');	
            // }
            unset($_SESSION["cart_item"]);

        break;
        case "empty":
            unset($_SESSION["cart_item"]);
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
            <a href="#">Orders</a>
          </li>
          <li class="breadcrumb-item active">Create Order</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Outlet Ordering Page <?php print_r($_SESSION["cart_item"][$k]); ?>
          </div>
          <div class="card-body">




            <div class="table-responsive">
              <!-- <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_order">Create Order</button> -->

		<table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<th>Product Name</th>
				<th>Category</th>
				<th>Price</th>
        <th>Quantity</th>
        <th>Action</th>
			</thead>
			<tbody>
      <?php
	$product_array = $db_handle->runQuery("SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 ORDER BY category.category_name ASC, menu.prod_name ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
						<tr>
            <form method="post" action="test.php?action=add&menu_id=<?php echo $product_array[$key]["menu_id"]; ?>">
							<td><?php echo $product_array[$key]["prod_name"]; ?></td>
							<td><?php echo $product_array[$key]["category_name"]; ?></td>
							<td class="text-right">&#8369; <?php echo $product_array[$key]["price"]; ?></td>
              <td><input type="text" class="form-control" name="quantity" size="2" /></td>
              <td><input type="submit" value="Add to Cart" class="btn btn-primary" /></td>
            </form>
            </tr>
            <?php
		}
	}
	?>
			</tbody>
		</table>
		
			<div class="row">
            <div class="col-md-3">
              <input type="hidden" name="outlet" class="form-control" value="<?php echo ucfirst($_SESSION['branch']); ?>">
            </div>
            <div class="col-md-2" style="margin-left:-20px;">
            <button data-toggle="modal" onclick="history.go(-1);" class="btn btn-primary btn-sm"><i class="fas fa-times">&nbsp;</i>Cancel</button>
            </div>
            <div class="col-md-2">

            
            </div>
          </div>
          
          
      </div>
    </div>
    <div class="card-footer small text-muted"></div>
    
  </div>

  


<!-- TEST MODAL HERE  -->

<!-- Order Details Modal-->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order</h5>
      </div>
      <div class="modal-body" id="printSection">


<!-- <a class="btn btn-success" href="test.php?action=checkout">Checkout</a> -->
<!-- <a class="btn btn-danger" href="test.php?action=empty">Empty Cart</a> -->
<?php
if(isset($_SESSION["cart_item"])){
    $total_quantity = 0;
    $total_price = 0;
?>	
<table class="table table-striped table-bordered table-hover mt-3" >
<tbody>
<tr>
<th >Name</th>
<th >Category</th>
<th >Quantity</th>
<th >Product Price</th>
<th >Total Price</th>
<th >Remove</th>
</tr>	
<?php		
    foreach ($_SESSION["cart_item"] as $item){
        $item_price = $item["quantity"]*$item["price"];
		?>
				<tr>
				<td><?php echo $item["prod_name"]; ?></td>
				<td><?php echo $item["category_name"]; ?></td>
				<td style="text-align:right;"><?php echo $item["quantity"]; ?></td>
				<td  style="text-align:right;">&#8369; <!-- PESO SIGN --><?php echo $item["price"]; ?></td>
				<td  style="text-align:right;">&#8369; <!-- PESO SIGN --><?php echo number_format($item_price,2); ?></td>
				<td style="text-align:center;"><a href="test.php?action=remove&menu_id=<?php echo $item["menu_id"]; ?>" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></a></td>
				</tr>
				<?php
				$total_quantity += $item["quantity"];
				$total_price += ($item["price"]*$item["quantity"]);
		}
		?>

<tr>
<td colspan="2" align="right">Grand Total:</td>
<td align="right"><?php echo $total_quantity; ?></td>
<td align="right" colspan="2"><strong> &#8369; <!-- PESO SIGN --> <?php echo number_format($total_price, 2); ?></strong></td>
<td></td>
</tr>
</tbody>
</table>		
  <?php
} else {
?>
<div class="no-records">Your Cart is Empty</div>
<?php 
}
?>


			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-arrow-left">&nbsp;</i>  Go back </button>
      <a class="btn btn-warning" href="test.php?action=empty">Empty Cart</a>
			<a class="btn btn-success" href="test.php?action=checkout">Checkout</a>
      	</form>
      <!-- <button type="submit" name="add" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> Add</button> -->
      </div>
    </div>
  </div>
</div>


<?php 
include 'footer.php';
include 'scripts.php'; 
?>


<button data-toggle="modal"  data-target="#preview" class="btn btn-primary btn-sm float"><i class="fas fa-shopping-cart">&nbsp;</i>Cart</button>



</body>
</html>
