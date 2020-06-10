<?php
require_once("dbcontroller.php");
$db_handle = new DBController();
include_once 'header.php';

// include_once 'timeout.php';

include 'navbar.php';

if(isset($_POST['place_order']))
{
  if(!empty($_POST["notes"])) {
            if(!empty($_SESSION["cart_item"])) {

                            $outlet=$_SESSION['userid'];
                            $notes = $_POST['notes'];
                            $sql="INSERT INTO orders (user_id, purchased_at, notes) VALUES ($outlet, NOW(), '$notes')";
                            $connection->query($sql);
                            $pid=$connection->insert_id;

                            $total=0;

                foreach($_SESSION["cart_item"] as $k => $v) {


                            $sql="SELECT * FROM menu WHERE prod_code='".$v["prod_code"]."'";
                            $query=$connection->query($sql);
                            $row=$query->fetch_array();
                            

                            $subt=$row['price']*$v["quantity"]; 
                            $total+=$subt;


                            $db_handle->storeProd("INSERT INTO order_details (order_id, menu_id, qty, qty_old) VALUES ('$pid', '".$v["menu_id"]."', '".$v["quantity"]."', '".$v["quantity"]."')");

                } //end foreach
                            $sql="UPDATE orders SET total='$total', status='pending' WHERE order_id='$pid'";
                            $connection->query($sql);
                            
                            // send notification
                            $branch = $_SESSION['branch'];
                            $message = ucfirst($branch).' sent you an order!';
                            $notif_sql = "INSERT INTO comments(send_to, comment_subject, comment_text)VALUES ('commi','$message', '')";
                            $connection->query($notif_sql);
                            header('location:order_view.php');	
            }
            unset($_SESSION["cart_item"]);
          } else {
            header('location:checkout.php');	
          }
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
                $productByCode = $db_handle->runQuery("SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 AND prod_code='" . $_GET["prod_code"] . "' ORDER BY category.category_name ASC, menu.prod_name ASC");



                $itemArray = array($productByCode[0]["prod_code"]=>array('prod_code'=>$productByCode[0]["prod_code"],'menu_id'=>$productByCode[0]["menu_id"],'prod_name'=>$productByCode[0]["prod_name"], 'category_name'=>$productByCode[0]["category_name"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));
                
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["prod_code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                                if($productByCode[0]["prod_code"] == $k) {
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
                        if($_GET["prod_code"] == $k)
                            unset($_SESSION["cart_item"][$k]);				
                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                }
            }
        break;
        case "checkout":
          header('location:checkout.php');
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
          <li class="breadcrumb-item active">Checkout</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Checkout Page 
          </div>
            <div class="card-body">


<form method="post">

  <div class="form-group">
    <label for="exampleFormControlTextarea1">Notes to commissary:</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" name="notes" rows="3" placeholder="Please deliver on..." required></textarea>
  </div>


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
</tr>
</tbody>
</table>		
  <?php
} else {
?>
<div class="alert alert-danger d-flex justify-content-center">Your Cart is Empty</div>
<?php 
}
?>


			</div>

			<a class="btn btn-danger mt-2" href="outlet_order.php">Go back</a>
			<input type="submit" class="btn btn-success mt-2" value="Place order" name="place_order" <?php if(empty($_SESSION["cart_item"])){ ?> disabled <?php } ?>>
      </form>
            </div>
    <div class="card-footer small text-muted"></div>
    
  </div>

  


<!-- TEST MODAL HERE  -->



<?php 
include 'footer.php';
include 'scripts.php'; 
?>


<!-- <button data-toggle="modal"  data-target="#preview" class="btn btn-primary btn-sm float"><i class="fas fa-shopping-cart">&nbsp;</i>Cart</button> -->



</body>
</html>
