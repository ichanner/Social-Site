<?php

session_start();

if(!isset($_SESSION['chat'])){
    exit("Couldn't load chat!");
}

if(!isset($_GET['name'])){
    exit("Couldn't load chat!");
}

$con_chat = NEW MySQLi('localhost', 'root', '', 'megatowel_chat');
$con = NEW MySQLi('localhost', 'root', '', 'megatowel');

$token = $_SESSION['user'];  

$grab = $con->query("SELECT * FROM accounts WHERE Token = '$token'");

$row = $grab->fetch_assoc();
$pfp_var = $row['Image'];
$us = $row['username'];
$msg = $_POST['cu'];
$chat_name = $_GET['name'];
//echo "Chat_id: $chat_name";

 $con_chat->query("INSERT INTO `$chat_name` (msg,Sender,Favicon) VALUES('$msg','$us','$pfp_var')");

?>


