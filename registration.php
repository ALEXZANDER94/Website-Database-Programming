<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
//prep db params
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

//prepare the query

$query = $conn->prepare("INSERT INTO User(UID, NAME, EXP, SID, IID, PSWD, EMAIL) VALUES (?,?,?,?,?,?,?)");
$query->bind_param("isdiiss", $userID, $user, $exp, $statID, $invID, $pass, $mail);
$query2 = $conn->prepare("INSERT INTO Stats(ATTACK, DEFENSE, SID, SPECIAL, SPEED) VALUES (?,?,?,?,?)");
$query2->bind_param("iiiii", $attack_stat, $defense_stat, $statID, $special_stat, $speed_stat);
$query3 = $conn->prepare("INSERT INTO Inventory(CAPACITY, IID) VALUES (?,?)");
$query3->bind_param("ii", $capacity, $invID);

$user = $_POST['uname'];
$pass = $_POST['pswd'];
$mail = $_POST['mail'];

$user = testData($user);
$pass = testData($pass);
$mail = testData($mail);


$pass = password_hash($pass, PASSWORD_BCRYPT);
$userID = rand(5,9999999999);
$exp = 0.00;
$statID = rand(5,999999);
$invID = rand(5,9999999);
$capacity = 100;
$attack_stat = 50;
$defense_stat = 50;
$special_stat = 50;
$speed_stat = 50;

//Execute the query
$query->execute();
$query2->execute();
$query3->execute();

//close the connections
$query->close();
$query2->close();
$query3->close();
$conn->close();

header("Location: *********************************");
}
function testData($data)
{
$data = trim($data);
$data = strip_tags($data);
$data = htmlspecialchars($data);
return $data;
}
if($_SERVER['REQUEST_METHOD'] == 'GET')
{	
  $dbhost = "*********";
  $dbuser = "**************";
  $dbpass = "********";
  $dbname = "*******************";
	$name = "";
	$mail = "";

	//make connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if($conn->connect_error)
	{
		die("something went wrong");
	}

	mysql_select_db($dbname);
	
	if(isset($_GET['user']))
	{
		$name = testData($_GET['user']);
	}
	else
	{
		echo "Enter a Username";
		$conn->close();
		exit();
	}
	
	if(isset($_GET['email']))
	{
		$mail = testData($_GET['email']);
	}
	else
	{
		echo "Enter an email";
		$conn->close();
		exit();
	}
	
	$query = "SELECT * FROM User WHERE NAME LIKE '".$name."'";
	$result = $conn->query($query);
	$query2 = "SELECT * FROM User WHERE EMAIL LIKE '".$mail."'";
	$result2 = $conn->query($query2);
	
	if($result->num_rows > 0)
	{
		echo "Username already taken";
		$conn->close();
		//exit();
	}
	
	else if($result2->num_rows > 0)
	{
		echo "Email already in use";
		$conn->close();
		//exit();
	}
	else
	{
		echo "a";
		$conn->close();
		//exit();
	}
	
}

?>
