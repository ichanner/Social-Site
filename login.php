<?php
//echo "WebSocket:An error occured";
?>

<html>

<style>

#error {
  border-radius: 10px;
  background: #FFA19E;
  padding: 20px; 
  width: 200px;
  height: 75px;
  border: 1px solid red;

  -webkit-touch-callout: none;
  -webkit-user-select:none;
  -khtml-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
   user-select:none; 
}

#error:hover{

     background-color:#ff8480;
}

#success {
  border-radius: 10px;
  background: #c6ffb3;
  padding: 20px; 
  width: 500px;
  height: 100px;
  border: 1px solid #269900; 
}
</style>

</html>



<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
$error = NULL;
//for web request

if (isset($_POST['submit'])){
	//$con = NEW MySQLi('localhost', 'id12635463_dev', 'fort4572', 'id12635463_mega');
	$con = NEW MySQLi('localhost', 'root', '', 'megatowel');
	$u = $con-> real_escape_string($_POST['u']);
	$p = $con-> real_escape_string($_POST['p']);
	$p = md5($p);
  $grab = $con->query("SELECT * FROM accounts WHERE username OR Tag = '$u' AND password = '$p' LIMIT 1");
	
	if($grab->num_rows != 0){
		$row = $grab->fetch_assoc();
		$verified = $row['Member'];
		$email = $row['email'];
		$id = $row['id'];
		$date = $row['date'];
		$date = strtotime($date);
		$date = date('M d Y', $date);
		  
		$token = $row['Token'];
		
		
		
		if($verified == 1){
			if (isset($_POST['u'])){
			$u = $_POST['u'];
			$url = "Profile.php";
			$url = "Profile.php?u=" . $u;
			$_SESSION['logged_in']='1';
			$_SESSION['u']=$u;
			$_SESSION['user']=$token;
      $_SESSION['id']=$id;
      $_SESSION['notify_token']=$token;
      //header('HTTP/1.1 200 Unauthorized');

	if(!empty($_POST['remember'])){


    	setcookie('u',$u,time() + (10 * 365 * 24 * 60 * 60));	
    	setcookie('p',$p,time() + (10 * 365 * 24 * 60 * 60));
    
    }

    else{
    	
    if(isset($_COOKIE['p'])){ setcookie("p","");}
    	
    if(isset($_COOKIE['u'])){ setcookie("u","");}
    {

      header('Location: ' . $url);
    }
    
    }
      
		
	}
	}		

	else{

		echo "<center>";
    echo "<h2 style=color:red id = error> ERROR:This account is not verrified</h2> ";
    echo "</center>";
	}
		
	}
	
	
else{
	
	 echo "<center>";
    echo "<h2 style=color:red id = error> ERROR:Wrong username or password</h2> ";
    echo "</center>";


   // $error = "Error";
	
}
}





?>

<html>

<style>

hr.new1 {
  border: 1px solid purple;

}
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}


input[type=email], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}


input[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
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

.remember {
	
	color: white;

}

input[type=submit]:hover {
  background-color: #8000ff;
}

div {
  border-radius: 5px;
  background-color:  #333333;
  padding: 20px;
}

</style>


	<div>
		
<center>

	<img src="https://megatowel.io/favicon.ico" position; top-left height = 100 width = 100 />
	<hr   width = 300 class = "new1"></hr>
<head>

</head>

<body bgcolor=#4d4d4d>
    <form method="POST" action="">
    <table>
	 
	
    <tr>
    
        <td> <input type="TEXT" name ="u" placeholder = "Username" value = "<?php if(isset($_COOKIE["u"])) { echo $_COOKIE["u"]; } ?>" required/></td>


   </tr>

   <tr>
      
   <td> <input type="password" name ="p" placeholder = "Password" value="<?php if(isset($_COOKIE["p"])) { echo $_COOKIE["p"]; } ?>" required/></td>


   </tr>


   <tr>
 
        <td> <input type="SUBMIT" name ="submit" value = "Login" required/> </td>


   </tr>
        
    </table>
    </form>

    <form>
    	<input type = "CheckBox" name = "remember" <?php if(isset($_COOKIE["u"])) { ?> checked <?php } ?>></input>
    	<span class="label remember">Remember me</span>
    </form>

    <p><b><a href = "AccountRecovery.php" target="_blank"> Forgot your password? </a></b></p>
	</center>


<?php 
echo $error;
?>  
</body>
</div>

<script>
document.getElementById("error").onclick = function() {closeError()};

function closeError() {
    
    //window.location.href = 'login.php';
}

</script>

</html>