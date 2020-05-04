<?php
include_once 'DBConnector.php';
include 'user.php';

$con= new DBConnector;



if (isset($_POST['btn-login'])) 
{
	$username= $_POST['username'];
	$password= $_POST['password'];
	$instance= User::create('$username','$password');
	$instance-> setUsername($username);
	$instance-> setPassword($password);
	

	if($instance->isPasswordCorrect($con))
	{
		$instance->login();
		$con->closeDatabase();
		$instance->createUserSession();
	}else
	{
		$con->closeDatabase();
		header("Location:login.php");
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="validate.php"></script>
</head>
<body>
	<form method="post" name="login" id="login" action="<?=$_SERVER['PHP_SELF']?>">
	<table align="center">
		<tr>
			<td>
				<input type="text" name="username" placeholder="Username" required>
			</td>
		</tr>
		<tr>
			<td>
				<input type="password" name="password" placeholder="Password" required>
			</td>
		</tr>
		<tr>
			<td><button type="submit" name="btn-login"><strong>Login</strong></button></td>
		</tr>

</body>
</html>