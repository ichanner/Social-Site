<?php
session_start();
include("vendor/autoload.php");

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;




$chat = array("Message"=>$_GET['msg'],"Channel"=>$_GET['name'], "Sender"=>$_GET['sender']);

$name = $_GET['sender'];

$version = new Version2X("http://localhost:2001");

$client = new  Client($version);

$client->initialize();

$client->emit("new_msg", $chat);

$client->close();





?>