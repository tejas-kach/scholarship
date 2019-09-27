<?php
 
require_once("include/config.php");
$login_id=$password="";
$errEmail=$errEmpty=$err_invalid="";
function valid_email($str) {
return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}

if(isset($_POST["submit"]))
{	
	$login_id=trim(htmlspecialchars($_POST["username"]));
	$password=trim(htmlspecialchars($_POST["pass"]));
	if (empty($login_id) || empty($password))
    {
        $errEmpty="Empty login id or password";
        echo "enter credentials";
    }
    else
    {
    	if(!valid_email($login_id))
    	{
			$errEmail = "Invalid id";
			echo $errEmail;
    	}
    	else
    	{
			$sql="SELECT password FROM admin WHERE  username=?";
			$stmt=mysqli_prepare($conn,$sql);
			if(!$stmt)
			{
			echo "error stmt not prepared  ",mysqli_error($conn);
			}
			else
			{
			mysqli_stmt_bind_param($stmt,"s",$login_id);
		    mysqli_stmt_execute($stmt);
		    $result=mysqli_stmt_get_result($stmt);
		    if(mysqli_num_rows($result) != 1)
			    {
			        $err_invalid="Invalid logoin id or password";
			    }
			    else
			    {
			    	$row=mysqli_fetch_assoc($result);
			    	//password_verify($password,$row["password"])
			      	if($password===$row["password"])
			      	{
			      		echo "successfully logged in";
			        	header("");				      	}
			      	else
			      	{
			        	$err_invalid="Invalid logoin id or password";
			        	echo $err_invalid;				      	}
			    }
  			}
  			mysqli_close($conn);
    	
    	}	 
    }	
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
    <style type="text/css">
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

    </style>
  </head>
  <body>
 <form  class="form-signin" method="POST" action="">
  <h1 class="h3 mb-3 font-weight-normal">Sign in</h1>
  <label for="inputEmail" class="sr-only">Login id</label>
  <input type="text" id="username" name="username" class="form-control" placeholder="login" autofocus>
  <br>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="pass" name="pass" class="form-control" placeholder="Password">
  </div>
  <input type="submit"  class="btn btn-lg btn-primary btn-block"  name="submit">
</form>
</body>
</html>
?>