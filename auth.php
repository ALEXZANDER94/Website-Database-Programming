<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{	
  $dbhost = "*********";
  $dbuser = "**************";	
  $dbpass = "********";
  $dbname = "*******************";
	$name = "";
	$pswd = "";
	$password_okay = False;
	$hash = "";

	//make connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($conn->connect_error)
	{
		die("something went wrong");
	}
	mysql_select_db($dbname);
	
	if(isset($_POST['user']))
	{
		$name = testData($_POST['user']);
	}
	else
	{
		echo "Enter a Username";
		$conn->close();
		exit();
	}
	if(isset($_POST['pass']))
	{
		$pswd = testData($_POST['pass']);
	}
	else
	{
		echo "Enter a password";
		$conn->close();
		exit();
	}
	$query = "SELECT * FROM User WHERE NAME LIKE '".$name."'";
	$result = $conn->query($query);
		
	$row = $result->fetch_assoc();	
	$pass = $row["PSWD"];
	$hash = password_hash($pswd, PASSWORD_BCRYPT);
	if(password_verify($pswd, $pass))
	{
		$password_okay = True;
	}
	else
	{
		$password_okay = False;
	}
	if($result->num_rows == 1 && $password_okay)
	{
		echo "a";
		$conn->close();
		//exit();
	}
	else if($result->num_rows == 1 && !$password_okay)
	{
		echo "Password does not match";
		$conn->close();
	}
	else if($result->num_rows != 1)
	{
		echo "Username not found";
		$conn->close();
	}
	
}

function testData($data)
{
$data = trim($data);
$data = strip_tags($data);
$data = htmlspecialchars($data);
return $data;
}

?>

