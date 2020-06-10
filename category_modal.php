<!-- Edit Product -->
<div class="modal fade" id="category_edit<?php echo $row['category_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
      </div>
      <div class="modal-body">

      <form method="POST" action="category_edit.php?category_id=<?php echo $row['category_id']; ?>" enctype="multipart/form-data">
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
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i> Close</button>
      <button type="submit" class="btn btn-success"><i class="fas fa-edit">&nbsp;</i> Update</button>
      </form>
      </div>
    </div>
  </div>
</div>



<!-- Delete Category -->
<div class="modal fade" id="delete_category<?php echo $row['category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Remove Category</h5>
            </div>
            <div class="modal-body">
                <h3 class="text-center"><?php echo $row['category_name']; ?></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i> Close</button>
                <a href="delete_category.php?category_id=<?php echo $row['category_id']; ?>" class="btn btn-danger"><i class="fas fa-plus">&nbsp;</i> Yes</a>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Logout Modal-->




