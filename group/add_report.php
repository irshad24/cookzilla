<?php
date_default_timezone_set('US/Eastern');

session_start();
if (!$connection = @ mysqli_connect("localhost", "root", ""))
  die("Cannot connect" . mysqli_error());
mysqli_select_db($connection,'cookzilla') ;
$uname = $_SESSION['uname'];
$eid = $_SESSION['eid'];
$ertitle = $_POST['ertitle'];
$ertext = $_POST['ertext'];

$date = date("Y-m-d H:i:s");

$query = "INSERT INTO event_report values (0,'".$uname."','".$eid."','".$ertitle."','".$ertext."','".$date."')";
$result = mysqli_query($connection,$query) or die('Query failed: ' . mysql_error());

$erid =  mysqli_insert_id();




$inames = $_POST['inames'];



$images = $_POST['images'];
if(isset($images)){
  $len=count($images);
  for($x=0;$x<$len;$x++) {
    if ($images[$x] != '') {
    $query = "INSERT INTO report_img values (0,'".$erid."','".$images[$x]."')";
    $result = mysqli_query($connection,$query) ;
    }
  }
}
//echo $units[0];

// Free resultset


// Closing connection
mysql_close($connection);  

echo "<script type='text/javascript'>";  
echo "alert('create review successfully! Loading back to previous page...');";
echo "history.go(-2)";
echo "</script>";  
?>