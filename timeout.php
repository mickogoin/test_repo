<?php 
include_once 'header.php';

  session_destroy();
  // echo '<script language="javascript">';
  // echo 'alert("You have been inactive, please login again!")';
  // echo '</script>';
  
  header('Refresh: 1; URL = login.php');


?>