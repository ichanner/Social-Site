<?php
include 'db.inc.php';
session_start();
error_reporting(0);
ini_set('display_errors', 0);
if(isset($_POST['search'])){
	  $display_seatch = $_POST['search'];
	  $search = $_POST['search'];
	  $search = "%$search%";
	  if(strlen($search) > 2){

	  		include("Connection.php");

	  		$select = "SELECT * FROM accounts WHERE username LIKE :s OR Tag LIKE :s";

	  		$stmt = $data->prepare($select);
	  		$stmt->bindParam('s',$search);
	  		$stmt->execute();


	  	echo "<div class = containter>";
	  	echo "<h3 style=color:white>Results for $display_seatch</h3>";
	  	$auto_auth = $_SESSION['u'];
	  		while($row = $stmt->fetch()){
		 	
  	            $us = $row['username'];
  	            $member = $row['Member'];
    		    $tag = $row['Tag'];
    		    $pfp_var = $row['Image'];
    		   if($us != $auto_auth and $member == 1){
    		    echo "<br/><a href = 'User.php?u=$us' ><div id = user class = s><img src='images/".$row['Image']."' height = 100; width = 100; position:absolute;top><br/><h1 style=color:white>$us</h1><small style=color:white>@$tag</small><br/></div></a><br/>";

    			}

    		 
	  }
		
	
    
        if($us=="" or $us == $auto_auth and $member != 1){

        	echo "<br/>";
        	echo "<br/>";
        	echo "<br/>";
    		echo "<h2 style=color:white> Wow such empty </h2>";
    	
    	}
	    

	    echo "</div>";




	}
}

?>


<html>

<style>

div.containter{

 position: fixed;
 left:360;
 top: 100;
 width: 520px;
 height: 450px;
 border-radius: 5px;
 background-color:  #333333;
 padding: 20px;
 overflow-y: auto;
 z-index:10;

}


  -webkit-scrollbar { 
                display: none; 
            } 



div.s {

 width: 483px;
 height: 150px;
 border-radius: 5px;
 padding: 20px;
 background-color:#262626;
  
}

div.s:hover{

	 background-color: #1a1a1a;
}


h1{
  line-height: 0.1;
}

img{

	 border-radius: 25%;
}


a:link{

	text-decoration: none;
}

</style>

<script>

 document.getElementsByTagName('can')[0].innerHTML = '';

</script>

</html>