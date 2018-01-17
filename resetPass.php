<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//check if username exists in database from entered email
  $dbhost = "*********";
  $dbuser = "**************";
  $dbpass = "********";
  $dbname = "*******************";

	//make connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($conn->connect_error)
	{
		die("something went wrong");
	} 
	mysql_select_db($dbname);
	if(isset($_POST['pass1']) && isset($_POST['key']) && isset($_POST['key2']))
	{
		$pass = testData($_POST['pass1']);
		$key = testData($_POST['key']) . testData($_POST['key2']);
	}
	else
	{
		$conn->close();	
	}
	$pass = password_hash($pass, PASSWORD_BCRYPT);
	
	$query = "UPDATE antemon1_Baconators.User SET PSWD ='".$pass."' WHERE PASSKEY = '".$key."'";
	$conn->query($query);
	$conn->close();
	//header("Location: http://antem-online.net/login.html");
}
function testData($data)
{
$data = trim($data);
$data = strip_tags($data);
$data = htmlspecialchars($data);
return $data;
}

?>
