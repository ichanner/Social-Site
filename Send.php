<?php
include("vendor/autoload.php");

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

if (strpos($_POST["cu"], '@') == false) {

	$chat = array("Message"=>$_POST['cu'],"Channel"=>$_GET['name'], "Sender"=>$_GET['sender']);

	$name = $_GET['sender'];

	//. " (In chat room: " . $_GET['name'] . ")"

	$curl = curl_init("https://discordapp.com/api/webhooks/710016789387411487/WcTQZy7EsKk6wJZTVexA6ycDqvCUBvfP2ph3hnlC60hC034NFbCRX6MFb7Bq5SQMzXIC");

	curl_setopt($curl,CURLOPT_POST,1);
	curl_setopt( $curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode(array( "tts" =>  false ,"content" => $_POST['cu'], "username"=> $name)));
	echo curl_exec($curl);


$version = new Version2X("https://frozen-falls-28329.herokuapp.com/");

$client = new  Client($version);

		$client->initialize();

		$client->emit("new_msg", $chat);

		$client->close();


}

?>




