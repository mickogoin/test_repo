<!-- Edit Product -->
<div class="modal fade" id="product_edit<?php echo $row['menu_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
      </div>
      <div class="modal-body">

      <form method="POST" action="product_edit.php?product_id=<?php echo $row['menu_id']; ?>" enctype="multipart/form-data">
      <div class="form-group" style="margin-top:10px;">
          <div class="row">
              <div class="col-md-3" style="margin-top:7px;">
                  <label class="control-label">Product Name:</label>
              </div>
              <div class="col-md-9">
                  <input type="text" class="form-control" value="<?php echo $row['prod_name']; ?>" name="product_name">
              </div>
          </div>
      </div>

      <div class="form-group" >
          <div class="row">
              <div class="col-md-3">
                  <label class="control-label">Code:</label>
              </div>
              <div class="col-md-9">
                  <input type="text" class="form-control" value="<?php echo $row['prod_code']; ?>" name="prod_code">
              </div>
          </div>
      </div>

      <div class="row">
            <div class="col-md-3">
                <label for="exampleFormControlSelect1">Category</label>
            </div>
            <div class="col-md-9">
                <select class="form-control" name="category">
                <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                <?php
                    $sql_cat="SELECT * FROM category WHERE hidden=0 AND category_id != '".$row['category_id']."'";
                    $cquery=$connection->query($sql_cat);

                    while($crow=$cquery->fetch_array()){
                        ?>
                        <option value="<?php echo $crow['category_id']; ?>"><?php echo $crow['category_name']; ?></option>
                        <?php
                    }
                ?>

                </select>
            </div>
        </div>

        <div class="row mt-3">
              <div class="col-md-3" style="margin-top:7px;">
                  <label>Price</label>
            </div>
              <div class="col-md-9">
                  <input type="number" step=".01" class="form-control" name="price" value="<?php echo number_format($row['price'], 2); ?>">
              </div>
        </div>

      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i> Close</button>
      <button type="submit" class="btn btn-success"><i class="fas fa-pencil-alt">&nbsp;</i> Update</button>
      </form>
      </div>
    </div>
  </div>
</div>



<!-- Delete Category -->
<div class="modal fade" id="delete_product<?php echo $row['menu_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Remove Product</h5>
            </div>
            <div class="modal-body">
                <h3 class="text-center"><?php echo $row['prod_name']; ?></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i> Close</button>
                <a href="delete_product.php?product_id=<?php echo $row['menu_id']; ?>" class="btn btn-danger"><i class="fas fa-archive">&nbsp;</i>Yes</a>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Logout Modal-->




