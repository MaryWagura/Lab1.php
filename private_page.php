<?php
session_start();
if (!isset($_SESSION['username'])) 
{
	header("Location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PrivatePage</title>
</head>
<body>
	<p>This is a private page!</p>
	<p>We want to protect it.</p>
	<p><a href="logout.php">Logout</a></p>

</body>
</html>