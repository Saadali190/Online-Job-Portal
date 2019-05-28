<?php

session_start();

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$jp = $_SESSION["username"];
$JT = $qlf = $exp = $company= "";
$JT_err = $company_err = "";

 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["JT"]))){
        $JT_err = "Please Enter Job Title";     
    } else{
        $JT = trim($_POST["JT"]);
    }
    if(empty(trim($_POST["company"]))){
        $company_err = "Please Enter Company Name";     
    } else{
        $company = trim($_POST["company"]);
    }
    if(empty(trim($_POST["qlf"]))){
        $qlf = Null;     
    } else{
        $qlf = trim($_POST["qlf"]);
    }
    if(empty(trim($_POST["exp"]))){
        $exp = Null;     
    } else{
        $exp = trim($_POST["exp"]);
    }    	
    // Check input errors before inserting in database
    if(empty($JT_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO job (job_title, req_qlf, req_exp, company, jp) VALUES (?, ?, ?, ?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_JT, $param_qlf, $param_exp, $param_company, $param_jp);
            
            // Set parameters
             $param_JT  = $JT;
             $param_qlf = $qlf; // Creates a password hash
             $param_exp = $exp;
			 $param_jp  = $jp;
			 $param_company =$company;
			
            //echo "   JT  ".$param_JT;
            //echo "qlf ".$param_qlf; // Creates a password hash
            //echo "exp ".$param_exp;
			//echo $param_jp;
			echo "copm ".$param_company;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: welcome.php");
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
        <h2>Post Job</h2>
        <p>Please fill this form to post a job.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($JT_err)) ? 'has-error' : ''; ?>">
                <label>Job Title</label>
                <input type="text" name="JT" class="form-control" value="<?php echo $JT; ?>">
                <span class="help-block"><?php echo $JT_err; ?></span>
            </div>    
			<div class="form-group ">
                <label>Required Qualifications</label>
                <textarea name="qlf" rows="5" cols="60"></textarea>
            </div>
            <div class="form-group ">
                <label>Required Experience</label>
                <textarea name="exp" rows="5" cols="60"></textarea>
            </div>
			<div class="form-group <?php echo (!empty($company_err)) ? 'has-error' : ''; ?>">
                <label>Company</label>
                <input type="text" name="company" class="form-control" value="<?php echo $company; ?>">
				<span class="help-block"><?php echo $company_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="post">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p> <a href="welcome.php">Click here</a> to go back</p>
        </form>
    </div>    
</body>
</html>