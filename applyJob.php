<?php
// Include config file
require_once "config.php";
session_start();
// Define variables and initialize with empty values
$jp = $_SESSION["username"];
$JT = $Job = "";
$JT_err = $Job_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["JT"]))){
        $JT_err = "Please Enter username";     
    } else{
        $JT = trim($_POST["JT"]);
    }
    
    if(empty(trim($_POST["Job"]))){
        $Job_err = "Please Enter Job Title";     
    } else{
        $Job = trim($_POST["Job"]);
    }
        	
    // Check input errors before inserting in database
    if(empty($JT_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO applied_for (js, application) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_JT, $param_applic);
            
            // Set parameters
            $param_JT  = $JT;
            $param_applic = $Job; // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: welcomeseeker.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>job Post Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Apply for Job</h2>
        <p>Please fill this form to apply for a job.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($JT_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="JT" class="form-control" value="<?php echo $JT; ?>">
                <span class="help-block"><?php echo $JT_err; ?></span>
            </div>    

			<div class="form-group <?php echo (!empty($Job_err)) ? 'has-error' : ''; ?>">
                <label>Job Title</label>
                <input type="text" name="Job" class="form-control" value="<?php echo $Job; ?>">
				<span class="help-block"><?php echo $Job_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="post">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p> <a href="welcomeseeker.php">Click here</a> to go back</p>
        </form>
    </div>    
</body>
</html>