<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $ad_email = $company = $comapnyd = $address = $country= $phone = "";
$username_err = $password_err = $confirm_password_err = $company_err=  "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT jp_username FROM jobprovider WHERE jp_username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    
    // validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // check for email
    if(empty($_POST["ad_email"])){
        $ad_email = NULL; 
    } else{
        $ad_email = trim($_POST["ad_email"]);
    }
    
    if(empty($_POST["company"])){
        $company_err = "Please Enter your Company Name";     
    } else{
        $company = trim($_POST["company"]);
    }

    if(empty($_POST["companyd"])){
	$companyd = NULL;     
    }
	else{
        $companyd = trim($_POST["companyd"]);
    }
	
    if(empty($_POST["address"])){
        $address = NULL;     
    } else{
        $address = trim($_POST["address"]);
    }

    if(empty($_POST["phone"])){
        $phone = NULL;     
    } else{
        $phone = trim($_POST["phone"]);
    }  
	
	
    if(empty($_POST["country"])){
        $country = NULL;     
    } else{
        $phone = trim($_POST["country"]);
    }  
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($company_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO jobprovider (jp_username, password, company, companyd, address, email, pno, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $param_password, $param_company, $param_companyd, $param_address, $param_email,
			$param_pno, $param_country);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			$param_company =  $company;
			$param_companyd = $companyd;
			$param_address  = $address;
            $param_email    = $ad_email;
            $param_pno   = 	  $phone;
			$param_country =  $country;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
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
    <title>Job Provider Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 450px; padding: 20px; }
    </style>
</head>
<body>
    
    <div class="wrapper">
        <h2>Sign Up As Job Provider</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($ad_email)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="ad_email" class="form-control" value="<?php echo $ad_email; ?>">
            </div>
            <div class="form-group <?php echo (!empty($company_err)) ? 'has-error' : ''; ?>">
                <label>Company</label>
                <input type="text" name="company" class="form-control" value="<?php echo $company; ?>">
				<span class="help-block"><?php echo $company_err; ?></span>
            </div>
            <div class="form-group ">
                <label>Comapny Description</label>
                <textarea name="companyd" rows="5" cols="40"></textarea>
            </div>
            <div class="form-group <?php echo (!empty($ad_email)) ? 'has-error' : ''; ?>">
                <label>Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
            </div>
            <div class="form-group ">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
            </div>
            <div class="form-group ">
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>