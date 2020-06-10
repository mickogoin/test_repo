<?php

include_once 'header.php';

// include_once 'timeout.php';

include 'navbar.php';

if(isset($_POST['add']))
{
    $cname=$_POST['category_name'];

    $category_add_sql="INSERT INTO category (category_name) VALUES ('$cname')";
    $connection->query($category_add_sql);
    header('location:category_view.php');
}



//query for category
$category_sql="SELECT * FROM category WHERE hidden=0 ORDER BY category_id ASC";
$category_result=$connection->query($category_sql);
?>


  <div id="wrapper">

  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Category</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>


        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Category List
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <button class="btn btn-primary btn-block btn-sm mb-3" data-toggle="modal" data-target="#add_category"><i class="fas fa-plus">&nbsp;</i> Add Category</button>
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Category Name</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Category Name</th>
                    <th>Actions</th>
                  </tr>
                </tfoot>
                <tbody>
                <!-- START PHP SCRIPT CATERGORY -->
                <?php while($row=$category_result->fetch_array()){ ?>
                  <tr>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#category_edit<?php echo $row['category_id'];?>" class="btn btn-primary btn-sm"><i class="fas fa-edit">&nbsp;</i>Update</a> 
                    | <a href="#" data-toggle="modal" data-target="#delete_category<?php echo $row['category_id'];?>" class="btn btn-danger btn-sm"><i class="fas fa-times">&nbsp;</i>Delete</a></td>
                    <?php include 'category_modal.php'; ?>
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
  <div class="modal fade" id="add_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
      </div>
      <div class="modal-body">

      <form method="POST" enctype="multipart/form-data">
      <div class="form-group" style="margin-top:10px;">
          <div class="row">
              <div class="col-md-3" style="margin-top:7px;">
                  <label class="control-label">Category Name:</label>
              </div>
              <div class="col-md-9">
                  <input type="text" class="form-control" value="<?php echo $row['category_name']; ?>" name="category_name">
              </div>
          </div>
      </div>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i>Close</button>
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
