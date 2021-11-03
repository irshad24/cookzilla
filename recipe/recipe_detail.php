<!DOCTYPE html>

<html>

<head>
	<title>cookzilla</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<style>
  pre {
    height: auto;
    max-height: 1000px;
    overflow: auto;
    background-color: #eeeeee;
    word-break: normal;
    
    white-space: pre-wrap;
word-wrap: break-word;
}​
		.navbar.navbar-inverse.navbar-extra{
			color: orange;
		}
    .col-center-block {  
    float: none;  
    display: block;  
    margin-left: auto;  
    margin-right: auto;  
} 
#father{
  position: relative;
  width: 500;
}
#content {

    float: left;
    width: 800px;    
    height:500px;
    padding-left: 50px;
     
}
#review {
  float:left;
  width: 800px;
  height: 200px;
}
#side {
    float: right;
    padding-right: 50px;
    width: 300px;
    
}
#left {
  position: absolute;
  left:50;
  top:20;
  width: 800;
  float: left;
}
#right {
  position: absolute;
  right:50;
  top:20;
  width: 200;
  float: right;
}


	</style>


</head>

<body>
<div class="navbar navbar-inverse navbar-extra" >
        <div class="container">
          <div class="navbar-header" >
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cookzilla"><font color="red">🍴Cookzilla!🍴</font></a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              


             
              <li id="subscribe">
                <a href="/cookzilla/recipe/view_recipe.php?sort=createdat"><font color="orange">Recipe</font></a>
              </li>

              
              
              <li id="subscribe">
                <a href=/cookzilla/group/group.php><font color="orange">Group</font></a>
              </li>
              
              
            </ul>
            
            <div class="dropdown">
            <ul id="navbar-right" class="nav navbar-nav navbar-right">
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                
               <?php
				session_start();
			//需要用isset来检测变量，不然php可能会报错。

				echo $_SESSION['nickname']. "(". $_SESSION['uname'].")";
				
			?>
                
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                
                <li><a href="/cookzilla/account/logout.php">Sign out</a></li>
              </ul>
              </li>
            </ul>
            </div>




            
            <!--
            <form class="navbar-form pull-right">
              <input class="col-md-2" type="text" placeholder="Email">
              <input class="col-md-2" type="password" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form>
            -->
          </div><!--/.navbar-collapse -->
        </div>
      </div>
      

    
    <?php
    $con = mysqli_connect("localhost","root",""); 
  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
date_default_timezone_set('US/Eastern');

mysqli_select_db( $con, 'cookzilla');
$rid = $_GET["rid"];
$_SESSION['rid'] = $rid;
$date = date("Y-m-d H:i:s");
$visited = "INSERT INTO user_visited values('".$_SESSION['uname']."', $rid, '".$date."')";
$result1 = mysqli_query($con,$visited);
$sql4="SELECT * FROM recipe, users where recipe.recipeId = '$rid.' and users.uname = recipe.uname";
$result = mysqli_query($con,$sql4); 
$row1 = mysqli_fetch_array($result);  
$_SESSION['rtitle'] = $row1["r_title"];
echo "<div  id = \"content\">";
echo "<div style='text-align:center;'><h2 class='col-center-block'>". $row1["r_title"]. "</div></h2>";

$sql="SELECT count(*) FROM user_visited where recipeId = $row1[recipeId]" ;
$visits = mysqli_query($con,$sql);
//$v = $visits[0] == "" ? 0 : $visits[0];
echo "<div style='text-align:right;'><h4> <font color='gray'>Author:&nbsp&nbsp" . $row1['nickname'] ."</font></h4></div>";
echo "<div style='text-align:right;'><h4> <font color='gray'>" . $row1['rtime'] ."</font></h4></div>";

$sql="SELECT * FROM ingredient where recipeId = '$rid'";
$ing = mysqli_query($con,$sql);
echo "<h4>ingredients:</h4>";
while ($row = mysqli_fetch_array($ing)) {
  $unit = "";
  switch ($row['iunit']) {
    case '1':
      $unit = 'piece';
      break;
    case '2':
      $unit = 'spoon';
      break;
      case '3':
      $unit = 'cup';
      break;
      case '4':
      $unit = 'bowl';
      break;
      case '5':
      $unit = 'g';
      break;
      case '6':
      $unit = 'kg';
      break;
      case '7':
      $unit = 'lb';
      break;
      case '8':
      $unit = 'oz';
      break;
      case '9':
      $unit = 'ml';
      break;
      case '10':
      $unit = 'l';
      break;
      case '11':
      $unit = 'pt';
      break;
      case '12':
      $unit = 'qt';
      break;
      case '13':
      $unit = 'gal';
      break;
  }

  echo "<p>".$row['iname'].":&nbsp&nbsp".$row['iquantity']."&nbsp".$unit."</p>";
}

echo "<br><h4>Description:</h4>";
echo "<pre>". $row1['r_description'] . "</pre>";

$sql="SELECT image from recipe_img where recipeId = '$rid' ";
$images = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($images)) {
    
    echo "<img src='".$row[0]."' class='img' width='750'> ";
}
echo "<br><h2><a class='btn btn-primary' href='/cookzilla/recipe/new_review.php'>Post Review</a></h2>";
echo "<h2>Review:</h2>";

$sql="SELECT * from review where recipeId = '$rid' order by wtime desc";
$reviews = mysqli_query($con,$sql);
while ($row = mysqli_fetch_array($reviews)) {
echo "<h4><a href=\"review.php?wid=".urlencode($row['reviewId'])."\">".$row['wtitle']."</a></h4>";
$un = $row['uname'];

$sql="SELECT nickname from users where uname = '$un'";
$reviewer = mysqli_query($con,$sql) ;
echo "<h5 style=\"text-align:right;\"> rating:&nbsp".$row['wrating']."&nbsp/&nbsp5&nbsp&nbsp&nbsp&nbsp".$row['wtime']."</h5>";
// echo "<script type='text/javascript'>";  
// echo "alert('$un');";
// echo "</script>"; 
}
echo "</div>";

echo "<div  id = \"side\">";
echo "<h4>". mysqli_fetch_array($visits)[0]."&nbsp&nbspvisits</h4>";

$sql="SELECT rtag FROM tag where recipeId = '$rid'";
$tags = mysqli_query( $con,$sql);
echo "<h4> Tags:&nbsp&nbsp</h4><h4><font color='red'>";
while ($row = mysqli_fetch_array($tags)) {
  echo $row[0]."&nbsp&nbsp";
}
echo "</font></h4>";
echo "<h4> Related&nbsp&nbspRecipes:</h4>";
$sql="SELECT recipe.recipeId, recipe.r_title from related, recipe where related.recipeId1 = '$rid' and related.recipeId2 = recipe.recipeId";
$related = mysqli_query($con,$sql) or die('Query failed: ' . mysql_error());
while ($row = mysqli_fetch_array($related)) {
  echo "<h4><a href=\"recipe_detail.php?rid=".urlencode($row['recipeId'])."\">" . $row[
  'r_title'] . "</a></h4>";
}

?>
<!--<a class="btn btn-primary" href="/cookzilla/recipe/new_review.php?rid=$rid">Post Recipe</a>-->
</div>  

      
   






      </body>
      </html>