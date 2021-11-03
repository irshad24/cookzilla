<?php
date_default_timezone_set('US/Eastern');
$sucess = "";
session_start();
if (!$connection = @ mysqli_connect("localhost", "root", ""))
  die("Cannot connect" . mysql_error());
mysqli_select_db($connection,'cookzilla') or die('Could not select database' . mysql_error());
$uname = $_SESSION['uname'];
$rtitle = $_POST['rtitle'];
$nos = $_POST['nos'];
$descrip = $_POST['descrip'];
$date = date("Y-m-d H:i:s");

$query = "INSERT INTO Recipe values (0,'".$uname."','".$rtitle."','".$nos."','".$descrip."', '".$date."')";
$result = mysqli_query($connection,$query) ;
if (mysqli_query($connection, $query))
    {
        $sucess = "Insert has been successfully.!"; 
    }
    else
    {
   echo "Error: " . $query . "
    " . mysqli_error($connection);
   }
    mysqli_close($connection);

$rid =  mysqli_insert_id($connection);
$tags = $_POST['tags'];
if(isset($tags)){
  $len=count($tags);
  for($x=0;$x<$len;$x++) {
    if ($tags[$x] != '') {
      $query = "INSERT INTO Tag values ('".$rid."','".$tags[$x]."')";
	   $result = mysqli_query($connection,$query) ;
     $rrr = "SELECT recipeId from tag where rtag = '$tags[$x]' and recipeId != '$rid'";
     $related = mysqli_query($connection,$rrr) ;
     while($row = mysqli_fetch_array($related)) {
      $reid = $row['recipeId'];
//       echo "<script type='text/javascript'>";  
// echo "alert('$reid');";
// echo "window.location.href='/cookzilla/index.php'";
// echo "</script>"; 
      $query ="INSERT INTO related values($rid, $reid)";
       mysqli_query($connection,$query) ;
       $query ="INSERT INTO related values($reid, $rid)";
       mysqli_query($connection,$query) ;
     }
    }
  }
}


$inames = $_POST['inames'];
$iqs = $_POST['iqs'];
$units = $_POST['units'];
if(isset($inames)){
  $len=count($inames);
  for($x=0;$x<$len;$x++) {
    if ($inames[$x] != '') {
    $query = "INSERT INTO Ingredient values ('".$rid."','".$inames[$x]."','".$iqs[$x]."','".$units[$x]."')";
	$result = mysqli_query($connection,$query) ;
}
}
  }


$images = $_POST['images'];
if(isset($images)){
  $len=count($images);
  for($x=0;$x<$len;$x++) {
    if ($images[$x] != '') {
    $query = "INSERT INTO recipe_img values (0,'".$rid."','".$images[$x]."')";
    $result = mysqli_query($connection,$query);
    }
  }
}
//echo $units[0];

// Free resultset


// Closing connection
mysqli_close($connection);  

echo "<script type='text/javascript'>";  
echo "alert('create recipe successfully! Loading back to previous page...');";
echo "history.go(-2)";
echo "</script>";  
?>