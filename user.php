<?php
include "Crud.php";
include "fileUploader.php";
//include "authenticate.php";
class user implements Crud //Authenticator
{
	private $user_id;
	private $first_name;
	private $last_name;
	private $city_name;
    private $username;
	private $password;
	private $utc_timestamp;
	private $offset;
	private $uploads;

	function __construct ($first_name,$last_name,$city_name,$username,$password,$utc_timestamp,$offset,$uploads)
	{
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->city_name=$city_name;
        $this->username=$username;
        $this->password=$password;
        $this->utc_timestamp=$utc_timestamp;
        $this->offset=$offset;
        $this->uploads=$uploads;
	}
	public static function create ()
	{
		$instance= new self('$first_name','$last_name','$city_name','$username','$password','$utc_timestamp','$offset','$uploads');
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
	public function setutc_timestamp($utc_timestamp)
	{
		$this->utc_timestamp=$utc_timestamp;
	}
	public function getutc_timestamp()
	{
		return $this->$utc_timestamp;
	}
	public function setoffset($offset)
	{
		$this->offset=$offset;
	}
	public function getoffset()
	{
		return $this->$offset;
	}
    public function setuploads($uploads)
	{
		$this->uploads=$uploads;
	}
	public function getuploads()
	{
		return $this->$uploads;
	}
	public function save($con)
	{
		$fn= $this->first_name;
		$ln=$this->last_name;
		$city=$this->city_name;
		$uname= $this->username;
		$utc_timestamp=$this->utc_timestamp;
		$offset=$this->offset;
		$uploads=$this->uploads;
		$this->hashPassword();
		$pass= $this->password;
		$conn=mysqli_connect('localhost','root','','btc3205');
		$res=mysqli_query($conn,"INSERT INTO user (first_name,last_name,user_city,username,password,utc_timestamp,offset,offset,uploads) VALUES ('$fn','$ln','$city','$uname','$pass','$utc_timestamp','$offset','$uploads')") or die ("Error ").mysqli_error($conn->error);

		return $res;
		

	}

	public function readAll($conn)
	{

		$con = new DBConnector();
		$users = mysqli_query($con->conn, "SELECT * FROM user") or die("Error: ".$con->error);
		if(mysqli_num_rows($res_set) > 0)
      {
        echo "<table align='center' border='1px' style='width:600px; line-height:40px;'>";
          echo "<t>";
              echo "<th>"; echo "ID"; echo "</th>";
              echo "<th>"; echo "First Name"; echo "</th>";
              echo "<th>"; echo "Last Name"; echo "</th>";
              echo "<th>"; echo "City"; echo "</th>";
              echo "<th>"; echo "Username"; echo "</th>";
              echo "<th>"; echo "Password"; echo "</th>";
        while($row= mysqli_fetch_assoc($res_set))
        {
          
          echo "</t>";
            echo "<tr>";
                echo "<td>";
                    echo $row['id'];
                echo "</td>";
                echo "<td>";
                    echo $row['first_name'];
                echo "</td>";
                echo "<td>";
                    echo $row['last_name'];
                echo "</td>";
                echo "<td>";
                    echo $row['user_city'];
                echo "</td>";
                 echo "<td>";
                    echo $row['username'];
                echo "</td>";
                 echo "<td>";
                    echo substr($row['password'], 0,10);
                echo "</td>";
            echo "</tr>";
          
          
        }
      echo "</table>";
        
      }else{
          echo "0 results";
      }  
        
		
		$con->closeDatabase();
		
		return $users;
         


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
		header("Location:login.php");
	}
	public function isUserExists($username)
	{
		$con = new DBConnector;

		$res = mysqli_query($con->conn, "SELECT * FROM user") or die("Error: ".$con->conn->error);

		$con->closeDatabase();

		while ($row = $res->fetch_assoc()) {
			if ($this->username == $row['username']) {
				return true;
				  $_SESSION['exists'] = "This Username is already in use";
				   break;
			}
		}
		$con->closeDatabase($conn);
		return $found;
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
 