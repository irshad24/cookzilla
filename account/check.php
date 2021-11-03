<?php
#require 'authentication.inc';
#require 'db.inc';
session_start();
if (!$connection = mysqli_connect("localhost", "root", ""))
  die("Cannot connect" . mysql_error());
mysqli_select_db($connection,'cookzilla');
#$query = 'SELECT * FROM book where topic =\'Cooking\'';
$uname = $_POST['user_id'];
$nickname = $_POST['nickname'];
$profile = $_POST['profile'];
$password = $_POST['password'];
#echo $kw;
$query = "INSERT INTO Users values ('".$uname."','".$nickname."','".$password."','".$profile."')";
#echo'ok';

$result = mysqli_query($connection,'cookzilla');

$_SESSION['uname']=$uname;
$_SESSION['nickname']=$nickname;
echo "<script type='text/javascript'>";  
echo "alert('Sign up successfully. Sign in and loading back to front page...');";
echo "window.location.href='/cookzilla/index.php'";
echo "</script>";   
// Free resultset
mysqli_free_result($result);

// Closing connection
mysqli_close($connection);
?>