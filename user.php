<?php
include "Crud.php";
//include "authenticate.php";
class user implements Crud //Authenticator
{
	private $user_id;
	private $first_name;
	private $last_name;
	private $city_name;
    private $username;
	private $password;

	function __construct ($first_name,$last_name,$city_name,$username,$password)
	{
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->city_name=$city_name;
        $this->username=$username;
        $this->password=$password;
	}
	public static function create ()
	{
		$instance= new self('$first_name','$last_name','$city_name','$username','$password');
		return $instance;
	}
	public function setUsername ($username)
	{
		$this->username= $username;
	}
	public function getUsername()
	{
		return $this->username;
	}
	public function setPassword($password)
	{
		$this->password= $password;
	}
	public function getPassword()
	{
		return $this->password;
	}
	public function setUserId($user_id)
	{
		$this->user_id=$user_id;
	}
	public function getUserId()
	{
		return $this->$user_id;
	}
	public function save($con)
	{
		$fn= $this->first_name;
		$ln=$this->last_name;
		$city=$this->city_name;
		$uname= $this->username;
		$this->hashPassword();
		$pass= $this->password;
		$conn=mysqli_connect('localhost','root','','btc3205');
		$res=mysqli_query($conn,"INSERT INTO user (first_name,last_name,user_city,username,password) VALUES ('$fn','$ln','$city','$uname','$pass')") or die ("Error ").mysqli_error($conn->error);
		return $res;
		

	}

	public function readAll($conn)
	{

		$result=$conn->query("SELECT * FROM user ") or die("Failed to query DB").mysqli_error($con);
         if($result->num_rows >0)
         {
         	while ($rows=$result->fetch_assoc())
         	{
         		print_r($rows);
         	}
         }

	}
	public function validateForm()
	{
		$fn= $this->first_name;
		$ln=$this->last_name;
		$city=$this->city_name;
		if($fn =="" || $ln =="" || $city =="")
		{
			return false;
		}
		return true;
	}
	public function createFormErrorsSessions()
	{
		session_start();
		$_SESSION['form_errors']="All fields are required";
	}
	public function hashPassword()
	{
		$this->password= password_hash($this->password,PASSWORD_DEFAULT);
	}
	public function isPasswordCorrect($conn)
	{
          $conn=mysqli_connect('localhost','root','','btc3205');
          $found=false;
         $result=$conn->query("SELECT * FROM user") or die ("Error").mysqli_error($con);
		while($row=mysqli_fetch_array($result))
		{
			if (password_verify($this->getPassword(),$row['password']) && $this->getUsername() ==$row['username']) 
			{
                 $found= true;
				
			}
		}
		//close the DB
		 $con= new DBConnector;
		$con->closeDatabase($conn);
		return $found;
		//return found
	}
	public function login()
	{
		if($this->isPasswordCorrect($conn))
		{
			//if pass is correct, we load the page
			header("Location:private_page.php");
		}
	}
	public function createUserSession()
	{
		session_start();
		$_SESSION['username'] = $this->getUsername();
	}
	public function logout()
	{
		session_start();
		unset($_SESSION['username']);
		session_destroy();
		header("Location:lab1.php");
	}
	public function isUserExists($username)
	{
		$res_u = mysqli_query("SELECT username FROM users WHERE username=''")or die("Failed to query DB").mysqli_error($con);
        if (mysqli_num_rows($res_u) > 0) {
  	      echo "Sorry... username already taken"; 	
           
        }
       
	}
	public function readUnique()
	{
		return null;
	}
	public function search()
	{
		return null;
	}
	public function update()
	{
		return null;
	}
	public function removeOne()
	{
		return null;
	}
	public function removeAll()
	{
		return null;
	}
}

?>