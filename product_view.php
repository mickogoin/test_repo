<?php

include_once 'header.php';

// include_once 'timeout.php';

include 'navbar.php';

if(isset($_POST['add']))
{
    $pname=$_POST['product_name'];
    $category=$_POST['category'];
    $prod_code=$_POST['prod_code'];
    $price=$_POST['price'];
	

    $product_add_sql="INSERT INTO menu (prod_name, category_id, prod_code, price) VALUES ('$pname', '$category', '$prod_code','$price')";
    $connection->query($product_add_sql);
    header('location:product_view.php');
}



//query for category
//$product_sql="SELECT * FROM menu WHERE hidden=0 ORDER BY menu_id ASC";
$product_sql="SELECT * FROM menu LEFT JOIN category ON category.category_id=menu.category_id WHERE menu.hidden=0 ORDER BY menu.category_id ASC, prod_name ASC";
$product_result=$connection->query($product_sql);

//for dropdown of category query

$category_sql="SELECT * FROM category WHERE hidden=0";
$category_result=$connection->query($category_sql);



?>


  <div id="wrapper">

  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Products</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Product List
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_product"><i class="fas fa-plus">&nbsp;</i>Add Product</button>
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                <!-- START PHP SCRIPT CATERGORY -->
                <?php while($row=$product_result->fetch_array()){ ?>
                  <tr>
                    <td><?php echo $row['prod_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo number_format($row['price'], 2); ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#product_edit<?php echo $row['menu_id'];?>" class="btn btn-primary btn-sm"><i class="fas fa-edit">&nbsp;</i>Update</a> 
                    | <a href="#" data-toggle="modal" data-target="#delete_product<?php echo $row['menu_id'];?>" class="btn btn-danger btn-sm"><i class="fas fa-times">&nbsp;</i>Delete</a></td>
                    <?php include 'product_modal.php'; ?>
                </tr>
                <?php } ?>
                <!-- END PHP SCRIPT CATEGORY -->
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted"></div>
        </div>




<!-- Add Category Modal-->
<div class="modal fade" id="add_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
      </div>
      <div class="modal-body">

      <form method="POST" enctype="multipart/form-data">
      <div class="form-group" style="margin-top:10px;">
        <div class="row">
              <div class="col-md-3" style="margin-top:7px;">
                  <label>Product Name</label>
              </div>
              <div class="col-md-9">
                  <input type="text" class="form-control" name="product_name">
              </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <label for="exampleFormControlSelect1">Category</label>
            </div>
            <div class="col-md-9">
                <select class="form-control" name="category">
                <option value="0">All Category</option>

                <?php
                    while($catrow=$category_result->fetch_array()){
                ?>
                <option value="<?php echo $catrow['category_id']?>"><?php echo $catrow['category_name'] ?></option>
                <?php
                    }
                ?>

                </select>
            </div>
        </div>
        
      <div class="form-group mt-4" >
          <div class="row">
              <div class="col-md-3">
                  <label class="control-label">Code:</label>
              </div>
              <div class="col-md-9">
                  <input type="text" class="form-control" placeholder="product name with no spaces" name="prod_code">
              </div>
          </div>
      </div>

        <div class="row mt-3">
              <div class="col-md-3" style="margin-top:7px;">
                  <label>Price</label>
            </div>
              <div class="col-md-9">
                  <input type="number" min="1" step=".01" class="form-control" name="price">
              </div>
        </div>
        
      </div>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i> Close</button>
      <button type="submit" name="add" class="btn btn-success"><i class="fas fa-plus">&nbsp;</i> Add</button>
      </form>
      </div>
    </div>
  </div>
</div>


<?php 
include 'footer.php';

include 'scripts.php'; 
?>

</body>

</html>
