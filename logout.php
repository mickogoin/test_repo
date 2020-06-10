<?php
include_once 'database/db_config.php';
include_once 'session.php';
session_destroy();
echo '<script language="javascript">';
echo 'alert("You have successfuly logged out!")';
echo '</script>';
header('Refresh: 2; URL = login.php');
?>


