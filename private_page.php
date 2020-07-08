<?php
include_once 'DBConnector.php';
session_start();
if (!isset($_SESSION['username'])) 
{
	header("Location:login.php");
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{  //we do not allow users to visit this page URL
	header('HTTP/1.0 403 Forbidden');
	echo 'You are frbidden';
}else 
{
	$api_key=null;
	$api_key= generateApiKey(64);
	header('Content-type: application/json');
	echo generateResponse ($api_key);
}
function generateApiKey ($str_length)
{
	$char= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$bytes= openssl_random_pseudo_bytes(3*$str_length/4+1);
	$repl= unpack('C2',$bytes);
	$first= $char[$repl[1]%62];
	$second=$char[$repl[2]%62];
	return strtr(subtr(base64_encode($bytes),0,$str_length), '+/',"$first$second");
}
function saveApiKey()
{
	//save API key
}
function fetchUserApiKey()
{
	$dbcon = new DBConnector();
	$user = $_SESSION['username'];
	$myquery = mysqli_query($dbcon->conn, "SELECT * FROM user WHERE username='$user'");
	$user_array = $myquery->fetch_assoc();
	$uid = $user_array['id'];
	$good = mysqli_query($dbcon->conn, "SELECT * FROM api_keys WHERE user_id = '$uid' ORDER BY `api_keys`.`id` DESC") or die(mysqli_error($dbcon->conn));
	$key = $good->fetch_assoc();
	return $key['api_key'];
	
}
function generateResponse($api_key)
{
	if (saveApiKey()) 
		{ $res =['success' =>1, 'message' => $api_key];
		}else
		{
			$res=['success' =>0, 'message' => 'something went wrong'];
		}
		return json_encode($res);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PrivatePage</title>
	<script src="jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="validate.js"></script>
	<script type="text/javascript" src="apikey.js"></script>
	<link rel="stylesheet" type="text/css" href="validate.css">
 <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
 <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>

 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css.map">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css.map">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css">
 <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.min.css.map">
</head>
<body>
	<p><a href="logout.php">Logout</a></p>
	<hr>
	<h3>Here we will create an API to allow users/developers to order fromexternal servers</h3>
	<hr>
	<h4>We now put this feature of allowing users to generate an API key. Click the bottom to generate API key.</h4>
	<button class="btn btn-primary" id="api-key-btn"> Generate API Key</button> <br><br>
	<strong>Your API Key:</strong><br>
	<textarea cols="100" rows="2" id="api_key" name="api_key" readonly><<?php echo fetchUserApiKey(); ?></textarea>

	<h3> Service Description</h3>
	We have a server/API that allows external applications to order food and also pull all order status by using order id. Let's do it
	<hr>


</body>
</html>