<?php
include('database/db_config.php');
include('session.php');

if(isset($_GET['q']))
{
	$o_details_sql="SELECT * FROM outlet_users WHERE username='".$_GET['q']."'";
   $o_details_result=$connection->query($o_details_sql);
   $drow=$o_details_result->fetch_array();
   echo $drow['username'];
   echo '<table>
            <tr>
               <td>'.$drow['roles'].'</td>
            </tr>
         </table>
   
   ';
   
}
?>