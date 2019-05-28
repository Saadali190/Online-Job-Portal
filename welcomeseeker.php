<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
else{
	$username = $_SESSION["username"];
	$type = $_SESSION["table"];
}
*/
// Include config file
require_once "config.php";

$JT= $JS = "";
$jobsearch_err = $JS_err = "";
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
		
		<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
              <label>Job Search</label>
              <input type="text" name="JT" class="form-control" value="<?php echo $JT; ?>">
		</div>
		
		<div class="form-group">
              <input type="submit" class="btn btn-primary" value="Search">
        </div>
		
		<p><a href="applyJob.php">Click Here</a> to apply for a job </p>
		</form>
		<br><br><br>				
		
	</div>
		
<?php if($_SERVER["REQUEST_METHOD"] == "POST"){
	
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
		if(empty($qlf))
			$qlf = 'Null';
		if(empty($company))
			$company = 'Null';
		echo "<tr><td>".$JT."</td><td>".$company."</td><td>".$qlf."</td></tr>";
		}
		echo "</table>";
   
}
?>
		<p> <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a> </p>
	</form>
	
</body>
</html>