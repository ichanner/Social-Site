<?php

session_start();

if(!isset($_SESSION['chat'])){
    exit("Couldn't load chat!");
}


$id_send = $_SESSION['id'];


include("Connection.php");


$chat_name = $_GET['name'];
$friend = $_GET['added'];


$group_check = $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name");
$is_group = $group_check->fetch_assoc();
$group = $is_group['group_id'];

if($group != 0){

	$con_group->query("INSERT INTO `$group`(recipient)VALUES('$friend')");
}

else{

$get_last_name = $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name");

$co = $get_last_name->fetch_assoc();

$co_starter = $co['recipient_id'];

$check = $con_chat->query("SELECT * FROM message_count WHERE group_id = $chat_name");

if($check->num_rows == 0){

	$con_chat->query("INSERT into message_count(starter_id,group_id)VALUES('$id_send','$chat_name')");

	$chat = $con_chat->query("SELECT * FROM message_count");
    $chat_group = $chat->num_rows;

	$con_chat->query("CREATE TABLE `megatowel_chat`.`$chat_group` ( `id` INT NOT NULL AUTO_INCREMENT ,  `msg` TEXT NOT NULL ,  `Sender` TEXT NOT NULL ,  `Favicon` VARCHAR(45) NOT NULL ,  `Date` TIMESTAMP NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;");

 
}



$con_group->query("CREATE TABLE `megatowel_groupchat`.`$chat_name` ( `id` INT NOT NULL AUTO_INCREMENT , `recipient` INT NOT NULL,PRIMARY KEY  (`id`)) ENGINE = InnoDB;");

$check = $con_group->query("SELECT * FROM `$chat_name` WHERE recipient = $co_starter");

if($check->num_rows == 0){

	$con_group->query("INSERT INTO `$chat_name`(recipient)VALUES('$co_starter')");
}

$con_group->query("INSERT INTO `$chat_name`(recipient)VALUES('$friend')");


}
 

?>