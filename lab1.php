<?php

include_once 'DBConnector.php';
include_once 'user.php';
include_once 'fileUploader.php';
$con=new DBConnector;//database connection

 if(isset($_POST['btn-save'])){
	 $first_name=$_POST['first_name'];
	 $last_name=$_POST['last_name'];
	 $city=$_POST['city_name'];
	 $username=$_POST['username'];
	 $password=$_POST['password'];
     $utc_timestamp=$_POST['utc_timestamp'];
	 $offset= $_POST['time_zone_offset'];
	 $uploads=$_POST['fileToUpload'];

	 //create new user
	 $user=new User($first_name,$last_name,$city,$username,$password,$utc_timestamp,$offset,$uploads);
	 //create object for file uploading
	 $uploader= new FileUploader;
	 if (!$user->Validateform())
	  {
	    $user->createFormErrorSessions();
	    header("Refresh:0");
	    die();
	 }
	 $res=$user->save($con);
	 //call uploadfile()function, which returns
	 $file_upload_response=$uploader->uploadfile();
	 
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
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
         <script type="text/javascript" src="timezone.js"></script>
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
	                </tr>
	                <tr>
		                <td><input type="text" name="username"required placeholder="Username"/></td>
	                </tr>
	                <tr>
		                <td><input type="password" name="password"required placeholder="Password"/></td>
	                </tr>
	                	<tr>
	                		<td>Profile Image:<input type="file" name="fileToUpload" id="fileToUpload"></td>
	                	</tr>
		            <tr>
		                <td><button type="submit" name="btn-save"><strong>SAVE</button></td>
	                </tr>
	                <input type="hidden" name="utc_timestamp" id="utc_timestamp" value=""/>
	                <input type="hidden" name="time_zone_offset" id="time_zone_offset" value=""/>
	                	<tr>
	                		<td>
	                			<a href="login.php">Login</a>
	                		</td>
	                	</tr>
	            </table>
             </form>
	    </body>
	</html>

