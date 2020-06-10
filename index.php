<?php

include_once 'header.php';

include 'navbar.php';

// include_once 'timeout.php';
?>


  <div id="wrapper">

  <?php include 'sidebar.php'; ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <?php
                $order_sql="SELECT * FROM orders WHERE status='pending'";
                $order_result=$connection->query($order_sql);
                $pending_order_count = mysqli_num_rows($order_result);
                ?>
                <div class="mr-5"><?php echo $pending_order_count; ?> Pending Orders!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="order_view.php">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <?php 
                $best_sql=" SELECT prod_name, SUM(qty) FROM `order_details` AS od
                            JOIN menu on od.menu_id = menu.menu_id
                            GROUP BY prod_name
                            ORDER BY qty DESC
                            LIMIT 1 ";

                $best_result=$connection->query($best_sql);

                $best_seller=$best_result->fetch_array();


                
                ?>
                <div class="mr-5"> Most Ordered Product <?php echo $best_seller['prod_name']; ?> </div>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Stay tuned for more software updates!</div>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">Stay tuned for more software updates!</div>
              </div>
              <!-- <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a> -->
            </div>
          </div>
        </div>

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Software Updates
          </div>
          <div class="card-body">
            <!--<div class="jumbotron">-->
                <ul class="list-group">
                  <li class="list-group-item list-group-item-info">Testing for Edsa Shang Ri La outlet. Please proceed with your order. </li>
                </ul>
                
            </div>
          <!--</div>-->
          <div class="card-footer small text-muted"></div>
        </div>

        <!-- DataTables Example -->
        <!-- <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Outlet Orders
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Outlet</th>
                    <th>Date of Order</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Outlet</th>
                    <th>Date of Order</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <tr>
                    <td>Alabang</td>
                    <td>November 13, 2019</td>
                    <td>Pending</td>
                    <td><a href="#" class="btn btn-primary btn-sm">Update</a></td>
                  </tr>
                  <tr>
                    <td>Greenbelt 1</td>
                    <td>November 13, 2019</td>
                    <td>Pending</td>
                    <td><a href="#" class="btn btn-primary btn-sm">Update</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted"></div>
        </div> -->

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Via Mare 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>



  <?php
  include 'footer.php';
  include 'scripts.php'; 
  
  ?>

</body>

</html>
