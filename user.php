<?php
include "Crud.php";
class user implements Crud
{
	private $user_id;
	private $first_name;
	private $last_name;
	private $city_name;

	function __construct ($first_name,$last_name,$city_name)
	{
		$this->first_name=$first_name;
		$this->last_name=$last_name;
		$this->city_name=$city_name;
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
		$conn=mysqli_connect('localhost','root','','btc3205');
		$res=mysqli_query($conn,"INSERT INTO user (first_name,last_name,user_city) VALUES ('$fn','$ln','$city')") or die ("Error ".mysqli_error($conn->error));
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