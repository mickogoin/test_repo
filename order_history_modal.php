<!-- Order Details Modal-->
<div class="modal fade" id="order_details<?php echo $row['order_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
      </div>
      <div class="modal-body" id="printSection">

      <div class="container-fluid">
          <!-- <div class="row">
          
          <div class="col-sm">
          <h5>Outlet: <b><?php echo ucfirst($row['username']); ?></b></h5>
          </div>

          <div class="col-sm">
          </div>

          <div class="col-sm">
          <span class="d-flex justify-content-end">
                  <?php echo date('M d, Y h:i A', strtotime($row['purchased_at'])) ?>
              </span>
          </div>
                
          
          </div> -->
          
          <table class="table table-bordered table-hover" id="dataTable_modal" width="100%" cellspacing="0">
          
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub Total</th>
                  </tr>
                </thead> 
                <tbody>
                <!-- START PHP SCRIPT CATERGORY -->
                <?php
                //order details query
                $ord_id = $row['order_id'];
                $o_details_sql="SELECT menu.prod_name, menu.price, order_details.qty, order_details.qty_old, order_details.qty_status 
                                FROM order_details 
                                LEFT JOIN menu ON menu.menu_id=order_details.menu_id 
                                WHERE order_id=$ord_id 
                                ORDER BY prod_name ASC";

                $o_details_result=$connection->query($o_details_sql);
                while($drow=$o_details_result->fetch_array()){ 
                ?>
                  <tr>
                    <td><?php echo $drow['prod_name']; ?></td>
                    <td><?php echo number_format($drow['price'], 2); ?></td>
                    <td>
                    <?php 
                    // condition if qty is out of stock
                    if($drow['qty'] > 0){ 
                      //condition if qty is updated by commissary then show that value
                      if($drow['qty_status'] == 0)
                      {
                        echo $drow['qty']; 
                      } else {
                        echo $drow['qty']." <label class='badge badge-info ml-1'> Previous qty ".$drow['qty_old']."</label>";
                      }
                      // end condition if qty is updated by commissary
                    }
                    else{
                      echo "<label class='badge badge-danger text-wrap'> out of stock </label>";
                    }
                    // end condition for out of stock status
                    
                    ?>
                    </td>
                    <td> &#8369;
                      <?php
                          $subt = $drow['price']*$drow['qty'];
                          echo number_format($subt, 2);
                      ?>
                    </td>
                  </tr>
                <?php } ?>
                <!-- END PHP SCRIPT CATEGORY -->
                <tr>
                    <td><b>TOTAL</b></td>
                    <td></td>
                        <!-- <td colspan="3"><b>TOTAL</b></td> -->
                      <td></td>
                      <td>&#8369; <?php echo number_format($row['total'], 2); ?></td>
                  </tr>
                  <tr>
                    <td> <b> Outlet: </b> </td>
                    <td> <?php echo ucfirst($row['username']); ?></td>
                        <!-- <td colspan="3"><b>TOTAL</b></td> -->
                      <td><b>Notes:</b></td>
                      <td> <?php echo $row['notes']; ?></td>
                  </tr>
                  <tr>
                    <td> </td>
                    <td></td>
                        <!-- <td colspan="3"><b>TOTAL</b></td> -->
                        <td> <b> Date Delivered: </b> </td>
                        <td> <?php echo $row['delivered_at']; ?></td>
                  </tr>
                </tbody>
            </table>


      </div>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times">&nbsp;</i>  Close</button>

      

      </div>
    </div>
  </div>
</div>





