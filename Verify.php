	<?php

if(isset($_GET['vkey'])){
	
	$vkey = $_GET['vkey'];
   	
   	include("Connection.php");

	$acc = $con->query("SELECT Member,vkey FROM accounts WHERE Member = 0 AND vkey = '$vkey' LIMIT 1");

	 if ($acc->num_rows == 1){
		$upd = $con->query("UPDATE accounts SET Member = 1 WHERE vkey = '$vkey' LIMIT 1");
		if ($upd){
			
			echo "You are verrified";
			
		}		
		else{
			
			echo "Failed to verify";
			
		}
		
	}else{
		echo "Account has already been verified";
		
	}
}

else{
	die("Error 404");
}
?>