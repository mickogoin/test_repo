    <!-- Sidebar -->
    <ul class="sidebar navbar-nav sticky-top sticky-offset" >
    <?php if($_SESSION['branch'] != "engineer"){ ?>


    <?php if($_SESSION['role'] == 'admin') { ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php" >
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item dropdown" >
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-pizza-slice"></i>
          <span>Products</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Finished Goods</h6>
          <!-- <a class="dropdown-item" href="product_add.php">Add Products</a> -->
          <a class="dropdown-item" href="product_view.php">View Products</a>
          <!--<div class="dropdown-divider"></div>-->
          <!--<h6 class="dropdown-header"> Utensils</h6>-->
          <!-- <a class="dropdown-item" href="utensils_add.php">Add Utensils</a> -->
          <!--<a class="dropdown-item" href="utensils_view.php">View Utensils</a>-->
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="category_view.php">
          <i class="fas fa-fw fa-clone"></i>
          <span>Categories</span>
        </a>
      </li>
      <?php } ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-check-square"></i>
          <span>Orders</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Outlet Orders</h6>
          <a class="dropdown-item" href="outlet_order.php">Add Orders</a>
          <a class="dropdown-item" href="order_view.php">View Orders</a>
          <!-- <a class="dropdown-item" href="history_view.php">History</a> -->
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="history_view.php">
          <i class="fas fa-fw fa-history"></i>
          <span>Order History</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="reports_view.php">
          <i class="fas fa-fw fa-clone"></i>
          <span>Reports</span>
        </a>
      </li>
      <!-- 
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->

      <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php" >
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="maintenance_view.php">
          <i class="fas fa-fw fa-clone"></i>
          <span>Maintenance</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-clone"></i>
          <span>History</span>
        </a>
      </li>

      <?php } ?>
    </ul>