<?php

include_once 'DBConnector.php';
include_once 'user.php';
$con=new DBConnector;//database connection

 if(isset($_POST['btn-save'])){
	 $first_name=$_POST['first_name'];
	 $last_name=$_POST['last_name'];
	 $city=$_POST['city_name'];
	 
	 //create new user
	 $user=new User($first_name,$last_name,$city);
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
       </head>
       <body>
           <form method ="post">
	            <table align="center">
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
		                <td><button type="submit" name="btn-save"><strong>SAVE</button></td>
	                <tr>
	            </table>
             </form>
	    </body>
	</html>

