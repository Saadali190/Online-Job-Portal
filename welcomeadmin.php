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

$JT= $JS = "";
$jobsearch_err = $JS_err = "";
/*if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	if(empty(trim($_POST["JT"]))){
        $jobsearch_err = "Please Enter some keywords for job search";
    }else
	{
        $sql = "SELECT * FROM job WHERE job_title like ?";
        
        if($stmt = mysqli_prepare($link, $sql))
		{
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_JT);
            
            // Set parameters
            $param_JT = "%".trim($_POST["JT"])."%";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
/*                mysqli_stmt_store_result($stmt);
                
                if((mysqli_stmt_num_rows($stmt)) >= 1){
                  while($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
						echo "Job : " . $row["job_title"]. " Company: " . $row["company"]. "<br>";
					}
                } else{
					$jobsearch_err = "There are no jobs with the following keyword";
                  }
            }
         
          // Close statement
           mysqli_stmt_close($stmt);
        }
	}
}
*/
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
		
		
		<p><a href="modifyjobP.php">Click Here</a> to modify the job provider</p>
		</form>
		<br><br><br>
		
		<p><a href="modifyjobS.php">Click Here</a> to modify the job seeker</p>
		</form>
		<br><br><br>
		<br><br>
		
	</div>
	
		<p> <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a> </p>
	</form>
</body>
</html>