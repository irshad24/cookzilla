<?php
date_default_timezone_set('US/Eastern');

session_start();
if (!$connection = @ mysqli_connect("localhost", "root", ""))
  die("Cannot connect" . mysqli_error());
mysqli_select_db($connection,'cookzilla') ;
$uname = $_SESSION['uname'];
$rid = $_SESSION['rid'];
$wtitle = $_POST['wtitle'];
$rating = $_POST['rating'];
$suggestion = $_POST['suggestion'];
$review = $_POST['review'];
$date = date("Y-m-d H:i:s");

$query = "INSERT INTO review values (0,'".$uname."','".$rid."','".$wtitle."','".$rating."','".$review."', '".$suggestion."','".$date."')";
$result = mysqli_query($connection,$query) ;

$wid =  mysqli_insert_id($connection);




$inames = $_POST['inames'];



$images = $_POST['images'];
if(isset($images)){
  $len=count($images);
  for($x=0;$x<$len;$x++) {
    if ($images[$x] != '') {
    $query = "INSERT INTO review_img values (0,'".$wid."','".$images[$x]."')";
    $result = mysqli_query($connection,$query) or die('Query failed: ' . mysqli_error());
    }
  }
}
//echo $units[0];

// Free resultset


// Closing connection
mysqli_close($connection);  

echo "<script type='text/javascript'>";  
echo "alert('create review successfully! Loading back to previous page...');";
//echo "window.location.href='/cookzilla/index.php'";
echo "history.go(-2)";
echo "</script>";  
?>