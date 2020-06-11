<?php
session_start();
include("vendor/autoload.php");

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;


$con_chat = NEW MySQLi('localhost', 'root', '', 'megatowel_chat');
$con = NEW MySQLi('localhost', 'root', '', 'megatowel');
$token = $_SESSION['user'];  


$grab = $con->query("SELECT * FROM accounts WHERE Token = '$token'");

$row = $grab->fetch_assoc();

$sender = $row['username'];

$pfp = $row['Image'];

$test = array("Message"=>$_POST['cu'],"Channel"=>$_GET['name'], "Sender"=>$sender,"Avatar"=>$pfp);


$version = new Version2X("http://localhost:3001");

$client = new  Client($version);

		$client->initialize();

		$client->emit("new_order", $test);

		$client->close();


?>






