<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else{
	$username = $_SESSION["username"];
	$type = $_SESSION["table"];
}

// Include config file
require_once "config.php";

$JS=$JT=$company=$qlf="";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 20px sans-serif; text-align: center; }
		.wrapper{ width: 500px; padding: 10px; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1> ONLINE JOB PORTAL </h1>
    </div>
	<div class="wrapper">
		<h2>Account type <b><?php echo htmlspecialchars($_SESSION["table"]); ?></b> <br>
		Username <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h2>
		<br><br>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
		<div class="form-group">
              <label>Job Search</label>
              <input type="text" name="JT" class="form-control" value="<?php echo $JT; ?>">
		</div>
		
		<div class="form-group">
              <input type="submit" name="JTS"  value="Search">
        </div>
		<p><a href="postjob.php">Click Here</a> to post a job </p>
		</form>
		<br><br><br>
		
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		
		<div class="form-group ">
              <label>Job Seeker Search</label>
              <input type="text" name="JS" class="form-control" value="<?php echo $JS; ?>">
		</div>
		<div class="form-group">
              <input type="submit" name="JSS"  value="Search">
        </div>
		<br><br>
		
	</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
  if(!empty($_POST['JTS'])){
	if(empty(trim($_POST["JT"]))){
        
        $query = "SELECT * FROM job";
	}
	else{
		$JT=trim($_POST["JT"]);
        $query = "SELECT job_title,company,req_qlf FROM job WHERE job_title like '%$JT%'";
	}
	    
		$result = $link->query($query);
		$result1=$link->query($query);;
		$num_results = $result->num_rows;
		echo "<p>Number of JOBSs found: ".$num_results."</p>";


		//DISPLAY AS TABLE
		echo "<table border = '1'>";
		echo "<tr><td> Job Title </td><td> Company </td><td> REQ_QUALIFICATION </td> </td></tr>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$JT  = $row['job_title'];
		$company = $row['company'];
		$qlf = $row['req_qlf'];
	
		echo "<tr><td>".$JT."</td><td>".$company."</td><td>".$qlf."</td></tr>";
		}
		echo "</table>";
   }
  else if(!empty($_POST['JSS'])){
	if(empty(trim($_POST["JS"]))){
        
        $query = "SELECT * FROM jobseeker";
	}
	else{
		$JT=trim($_POST["JS"]);
        $query = "SELECT Distinct * FROM jobseeker WHERE exp like '%$JS%' or qlf like '%$JS%' ";
	}
	    
		$result = $link->query($query);
		$result1=$link->query($query);;
		$num_results = $result->num_rows;
		echo "<p>Number of Job Seeker found: ".$num_results."</p>";


		//DISPLAY AS TABLE
		echo "<table border = '1'>";
		echo "<tr><td> JS_USER </td><td> Name </td><td> Qualification </td><td> Experience </td></tr>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$JT  = $row['js_username'];
		$fname = $row['fname']; $lname = $row['lname'];
		$qlf = $row['qlf'];
		$exp = $row['exp'];
		
		echo "<tr><td>".$JT."</td><td>".$fname." ".$lname."</td><td>".$qlf."</td><td>".$exp."</td></tr>";
		}
		echo "</table>";
 }
	
}
?>

		<br><br><br><br><br>
		<p> <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a> </p>
	</form>
</body>
</html>