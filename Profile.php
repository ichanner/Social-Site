<?php

ob_start();
session_start();
error_reporting(0);
ini_set('display_errors', 0);

include ("ProfileParent.php");


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1000)) {

    session_unset();     
    session_destroy();   
    header('Location:SessionExpired.php');
    $con->query("UPDATE accounts SET Online = 0 WHERE Token = '$token'");
}
$_SESSION['LAST_ACTIVITY'] = time();


if(!isset($_SESSION['logged_in'])){
  
    exit("Failed to authenticate user!");
}

else{

	
	$con = NEW MySQLi('localhost', 'root', '', 'megatowel');
	$token = $_SESSION['user'];

  $online = $con->query("UPDATE `accounts` SET `Online` = '1' WHERE Token = '$token'"); 

	$grab = $con->query("SELECT * FROM accounts WHERE Token = '$token'");
	$row = $grab->fetch_assoc();
  $Profile = new User($row['username'],$row['Tag'],$row['date'],$row['Image'],$row['id'],$row['email'],$row['Bio'],$row['Member']);
  
if($grab->num_rows != 0 && $Profile->get_verified()){
    

    echo $Profile->get_profile();
    $notify = $con->query("SELECT * FROM request WHERE Reciever = '$id'");
    $notification = $notify->num_rows;
    $con->query("UPDATE accounts SET notifications = $notification WHERE username = '$us'");
	   	
	}



	else{
			
		   // header("Location: User_error.php");
	    	//die();
		}
    	


	  
?>

<html>

<style>


img {
  border-radius: 25%;
}

img.none{


  position: absolute;
  top:10;
  left:20;
  border-radius: 0%;
}


img.favicon{

 border-radius: 25%;
 position: absolute;
 right:55;
 top:20;

}

::-webkit-scrollbar {
  width: 0px; 
  background: transparent;  
}

div.profile {
 overflow-y: auto;
 position: fixed;
 top: 100;
 width: 300px;
 height: 450px;
 border-radius: 5px;
 background-color:  #333333;
 padding: 20px;
 width:300px; 
}


div.request {
 overflow-y: auto;
 position: fixed;
 top: 100;
 width: 300px;
 height: 500px;
 border-radius: 5px;
 background-color:  #262626;
 padding: 20px;
 width:300px; 

}


div.notify {

  overflow-y: auto;
  position: fixed;
  top:100;
  left:930;
  border-radius: 5px;
  background-color:  #333333;
  padding: 20px;
  width: 300px;
  height: 450px;
}


h2{
  line-height: 0.1;
}

small{
  line-height: 0.1;
}




div.red{

  border-radius: 50%;
  background-color: red;
     position: absolute;
     height:30;
     width:30;
    right:120;
  top:5;
}


input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  height: 40;
  width:400;
    position: absolute;
    right:470;
  top:15;

 
}

input[type=submit] {
  width: 100%;
  background-color:#bf00ff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width:100;
  

}



input[type=submit]:hover {
  background-color: #8000ff;
}

body{

  overflow-y: hidden;
}



button {
  width: 25%;
  background-color:#bf00ff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

 button:hover {
  background-color: #8000ff;
}



.flex-container {
  display: flex;
  background-color: DodgerBlue;
}

.bell{

    position: absolute;
  top:25;
  left:1100
}

.flex-container > div {
  
  
  padding: 20px;

}

div.sub{

  border-radius: 5px;
  background-color: #262626;
  padding: 20px;
}

div.bar{

 position: absolute;
  top:0;
  left:5;
  border-radius: 5px;
  background-color:  #333333;
  padding: 20px;
  width: 1230px;
  height: 50px;
}

.not{

   position: absolute;
  top:-10;
  left:1130;

}


a:link{

  text-decoration: none;
    color:white;

}

a:visited{

    color:white;
}

a:hover{

  text-decoration: underline;
}

a:active{

  color:purple;
}

input.search{

  width: 100%;
  background-color:#bf00ff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width:100;
  position: absolute;
  right:365;
  top:14;
}

div.fixed{
            
  position: absolute;
  left: 500px;
   top: 0px;
}

</style>



<body bgcolor=#4d4d4d>
 


  <script> $jq132 = jQuery.noConflict(true); </script>

  <span id="nav"></span>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script>

    $(document).ready(function(){


         $.ajax({

              url:"NavBar.php",
              type:"post",
              data:{search: $(this).val()},
              success:function(result){

                $("#nav").html(result);
              }
          });
      });

</script>


<script>
  
document.getElementById("edit").onclick = function() {edit()};

function edit() {
    
    window.location.href = 'Settings.php';
}

</script>


</body>
</html>

<?php

  }

  include('NavBar.php');

?>
