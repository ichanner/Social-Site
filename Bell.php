<?php

ob_start();
session_start();
if(!isset($_SESSION['logged_in'])){
  
    exit("Failed to authenticate user!");
}
else{
$con = NEW MySQLi('localhost', 'root', '', 'megatowel');
$token = $_SESSION['user'];
$grab = $con->query("SELECT * FROM accounts WHERE Token = '$token'");

  


	
	$row = $grab->fetch_assoc();
	$verified = $row['Member'];
	$email = $row['email'];
  $id = $row['id'];
	$date = $row['date'];
	$date = strtotime($date);
	$date = date('M d Y', $date);
	$bio = $row['Bio'];
	$pfp_var = $row['Image'];
  $us = $row['username'];
  $id = $row['id'];
 	$tag = $row['Tag'];
  $_SESSION['image']=$pfp_var;



if($grab->num_rows != 0 && $verified == 1){



    $notify = $con->query("SELECT * FROM request WHERE Reciever = '$id'");
    $notification = $notify->num_rows;
    $con->query("UPDATE accounts SET notifications = $notification WHERE username = '$us'");



}

if($notification == 0){


		echo "<script>";
		echo "document.getElementById('red_back').style.display= 'none';";
		echo "document.getElementById('num_not').style.display= 'none';";
		echo "</script>";
	}


}

?>




<html>
<style>


div.red{

  border-radius: 50%;
  background-color: red;
     position: absolute;
     height:30;
     width:30;
    right:120;
  top:5;
   z-index:10;
}
.not{

   position: absolute;
  top:-10;
  left:1130;
   z-index:10;

}


</style>
 <div id = red_back class = red></div>
 <h3 id = num_not class = not style=color:white;><?php echo "$notification"; ?></h3>
<html>