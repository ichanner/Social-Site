<?php
session_start();
include("vendor/autoload.php");

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;




$chat = array("Message"=>$_GET['msg'],"Channel"=>$_GET['name'], "Sender"=>$_GET['sender']);

$name = $_GET['sender'];

$version = new Version2X("https://frozen-falls-28329.herokuapp.com/");

$client = new  Client($version);

$client->initialize();

$client->emit("new_msg", $chat);

$client->close();





?>