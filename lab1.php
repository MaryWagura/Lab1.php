<?php

include_once 'DBConnector.php';
include_once 'user.php';
$con=new DBConnector;//database connection

 if(isset($_POST['btn-save'])){
	 $first_name=$_POST['first_name'];
	 $last_name=$_POST['last_name'];
	 $city=$_POST['city_name'];
	 $username=$_POST['username'];
	 $password=$_POST['password'];
	 
	 //create new user
	 $user=new User($first_name,$last_name,$city,$username,$password);
	 if (!$user->Validateform())
	  {
	    $user->createFormErrorSessions();
	    header("Refresh:0");
	    die();
	 }
	 $res=$user->save($con);
	 
	 
	 if($res){
		 echo "save operation was succesful";
		 
	 }
	 else{
		 echo "An error has occured!";
	 }
	 
 }
 $rows= User::readAll($con->conn);

  ?>    
	
	<html>
        <head>
         <title>UserDetails</title>
         <script type="text/javascript" src="validate.js"></script>
         <link rel="stylesheet" type="text/css" href="validate.js">
       </head>
       <body>
           <form method ="post" name="UserDetails" id="UserDetails" onsubmit="return Validateform()" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return Validateform()">
	            <table align="center">
	            	<tr>
	            		<td>
	            			<div id="form-errors">
	            				<?php
	            				session_start();
	            				if(!empty($_SESSION['form-errors']))
	            				{
	            					echo "".$_SESSION['form-errors'];
	            					unset($_SESSION['form-errors']);
	            				}
	            				?>
	            		</td>
	            	</tr>
	              <tr>
		               <td><input type="text" name="first_name"required placeholder="First Name"/></td>
	                <tr>
		            <tr>
		                <td><input type="text" name="last_name"required placeholder="Last Name"/></td>
	                <tr>
		            <tr>
		                <td><input type="text" name="city_name"required placeholder="City"/></td>
	                <tr>
	                <tr>
		                <td><input type="text" name="username"required placeholder="Username"/></td>
	                <tr>
	                <tr>
		                <td><input type="password" name="password"required placeholder="Password"/></td>
	                <tr>
		            <tr>
		                <td><button type="submit" name="btn-save"><strong>SAVE</button></td>
	                <tr>
	                	<tr>
	                		<td>
	                			<a href="login.php">Login</a>
	                		</td>
	                	</tr>
	            </table>
             </form>
	    </body>
	</html>

