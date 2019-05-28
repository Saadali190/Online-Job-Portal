<?php

$account_err ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if(empty(trim($_POST['a'])))
	  $account_err = 'Please Select an account type to Signup';
  else{
	if ((trim($_POST['a'])) == 'a') 
	{
		header("location: ad_register.php");
	}
	if ((trim($_POST['a'])) == 'b')
	{
		header("location: js_register.php");
	}
	if ((trim($_POST['a'])) == 'c') 
	{
		header("location: jp_register.php");
	}
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ONLINE JOB PORTAL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 20px sans-serif; text-align: center; }
        .wrapper{ width: 500px; padding: 50px; }
    </style>
</head>
<body>
	<div class="page-header">
        <h1> ONLINE JOB PORTAL </h1>
    </div>
		<br><br>
        <p>Please Select An Account Type to Signup</p> <br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($account_err)) ? 'has-error' : ''; ?>">
               
			   <label>Account Type</label>
                <select id- "a" name= 'a'>
				<option value="">--Please choose account type--</option>
				<option value = 'a'>Admin</option>
				<option value = 'b'>Job Seeker</option>
				<option value = 'c'>Job Provider</option>
				</select>
		
                <span class="help-block"><?php echo $account_err; ?></span>
            </div>
			<br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
		</form>
     
</body>
</html>