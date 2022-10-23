<?php

echo "You have been banned from the chat room!";

session_start();

$_SESSION['banned'] = true;


?>