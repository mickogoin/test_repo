<?php
ob_start();
session_start();





$ReadSql = "SELECT * FROM `outlet_users`";
$res = mysqli_query($connection, $ReadSql);
while($r = mysqli_fetch_assoc($res)){



if (isset($_POST['login']) && !empty($_POST['uname']) && !empty($_POST['pass'])) {
    
    
   if ($_POST['uname'] == $r['username'] && $_POST['pass'] == $r['password']) 
    { 

      //session timeout script
      // $_SESSION['logged_in'] = true; //set you've logged in
      // $_SESSION['last_activity'] = time(); //your last activity was now, having logged in.
      // $_SESSION['expire_time'] = 10; //expire time in seconds:
      //end session timeout

      $_SESSION['valid'] = true;
      $_SESSION['timestamp'] = time();
      $_SESSION['userid'] = $r['user_id'];
      $_SESSION['role'] = $r['roles'];
      $_SESSION['branch'] = $r['username'];
      
      
      if($_SESSION['role'] == 'admin'){
        header("Location: index.php");
      } else {
        header("Location: order_view.php");
      }
      
      
    } else {
    
    echo '<script>';
    echo '$("#incorrect").modal("show");';
    echo '</script>';
   }

}//end IF ISSET LOGIN
  
}//end of while

?>


