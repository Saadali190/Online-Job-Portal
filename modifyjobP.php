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
              <label>Job Provider Search</label>
        </div>
		
		<div class="form-group">
              <input type="submit" class="btn btn-primary" value="Search">
        </div>      
        <br><br>
<?php

$ID = $JT= $JS = "";
$jobsearch_err = $JS_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	    
        $query = "SELECT * FROM jobprovider";
	
	    
		$result = $link->query($query);
		$result1=$link->query($query);;
		$num_results = $result->num_rows;
		echo "<p>Number of Job provider found: ".$num_results."</p>";


		//DISPLAY AS TABLE
		echo "<table border = '1'>";
		echo "<tr><td> Username </td><td> Company </td><td>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$JT  = $row['jp_username'];
		$company = $row['company'];
		//$qlf = $row['req_qlf'];
		//if(empty($qlf))
			$qlf = 'Null';
		if(empty($company))
			$company = 'Null';
		echo "<tr><td>".$JT."</td><td>".$company."</td><td>";
		}
		echo "</table>";

}

?>
		<br>
		<div class="form-group">
              <label>Enter Username to Delete</label>
              <input type="text" name="ID" class="form-control" value="<?php echo $ID; ?>">
		</div>
		
		<div class="form-group">
              <input type="submit" class="btn btn-primary" value="Delete" name="Delete">
        </div>

<?php
if(isset($_POST['Delete'])){
		
		$ID1="";
		if(!empty($_POST["ID"])){
		$ID1 = $_POST['ID'];
		$query1 = "DELETE FROM jobprovider where jp_username = '$ID1'";
}
		
		$query2 = "SELECT * FROM jobprovider";
	    
		$result1 = $link->query($query1);
		$result=$link->query($query2);;
		$num_results = $result->num_rows;
		echo "<p>Number of Job provider found: ".$num_results."</p>";


		//DISPLAY AS TABLE
		echo "<table border = '1'>";
		echo "<tr><td> Job Title </td><td> Company </td><td>";
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		$JT  = $row['jp_username'];
		$company = $row['company'];
		//$qlf = $row['req_qlf'];
		//if(empty($qlf))
			$qlf = 'Null';
		if(empty($company))
			$company = 'Null';
		echo "<tr><td>".$JT."</td><td>".$company."</td><td>";
		}
		echo "</table>";
}
?>


		<br><br><br>
        <p> <a href="welcomeadmin.php">Click here</a> to go back</p>
		<br><br><br>
		<br><br>
	
		<p> <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a> </p>
	</form>
</body>
</html>