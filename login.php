<?php 

include_once 'DBConnector.php';
include_once 'user.php';

$con = new DBConnector;

if (isset($_POST['btn-login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$instance = User::create();
	$instance->setPassword($password);
	$instance->setUsername($username);

	if ($instance->isPasswordCorrect()) {
		$instance->login();
		$con->closeDatabase();
		$instance->createUserSession();
	} else {
		$instance->createFormErrorSessions("Username or password is incorrect");
		$con->closeDatabase();
	}
}


 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="validate.js"></script>
	<link rel="stylesheet" type="text/css" href="validate.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript" src="timezone.js"></script>
</head>
<body>
	<form method="post" id="user_details" name="user_details" onsubmit="return validateForm()" action="<?=$_SERVER['PHP_SELF']?>">
		<div id="form-errors">
			<?php 
			if (!empty($_SESSION['form_errors'])) {
				echo " ". $_SESSION['form_errors'];
				unset($_SESSION['form_errors']);
			}
			 ?>
		</div>
		<div><input type="text" name="username" placeholder="user name..."></div>
		<div><input type="password" name="password" placeholder="password..."></div>
		<div><button type="submit" name="btn-login"><strong>LOGIN</strong></button></div>
		<div><a href="lab1.php">Register</a></div>
	</form>
</body>
</html>