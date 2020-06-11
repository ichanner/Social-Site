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
#perm_error {
  border-radius: 10px;
  background: #FFA19E;
  padding: 20px; 
  width: 200px;
  height: 75px;
  border: 1px solid red;

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
$error = NULL;

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {

    session_unset();     
    session_destroy();   
}


$_SESSION['under_13']=0;

If (isset($_POST["submit"])){
	$day = $_POST['day'];
	$year = $_POST['year'];
	$month = $_POST['month'];
	$u = $_POST['u'];
	$p = $_POST['p'];
	$p2 = $_POST['p2'];
	$e = $_POST['e'];
	//$con = NEW MySQLi('localhost', 'id12635463_dev', 'fort4572', 'id12635463_mega');
	$con = NEW MySQLi('localhost', 'root', '', 'megatowel');

	$age_check = "$day-$month-$year";
	$today = date("Y-m-d");
	$calculate = date_diff(date_create($age_check),date_create($today));
	$age = $calculate->format('%y');
	
	$user_check = $con->query("SELECT * FROM accounts WHERE username = '$u'");
	$email_check = $con->query("SELECT * FROM accounts WHERE email = '$e'");

	$nofify = 0;


	if($age < 13){

		$_SESSION['under_13']= 1;
		echo "<center>";
		echo "<h2 style=color:red id = perm_error> ERROR:Users must be 13+</h2> ";
		echo "</center>";
	}

	else if($_SESSION['under_13'] == 1){
  
   		echo "<center>";
		echo "<h2 style=color:red id = perm_error> ERROR:Users must be 13+</h2> ";
		echo "</center>";
	
	}


	else if(mysqli_num_rows($user_check) > 0){

		echo "<center>";
		echo "<h2 style=color:red id = error> ERROR:Username already exists</h2> ";
		echo "</center>";

	}

	else if(mysqli_num_rows($email_check) > 0){

		echo "<center>";
		echo "<h2 style=color:red id = error> ERROR:Email is already in use</h2> ";
		echo "</center>";

	}


	else if (strlen ($p) < 3){
	    echo "<center>";
		echo "<h2 style=color:red id = error> ERROR:Password must be at least 4 characters</h2> ";
		echo "</center>";
		
	}


	else if($p != $p2) {
		
		echo "<center>";
		echo " <h2 style=color:red id = error> ERROR:Passwords do not match </h2>";

		echo "</center>";
		
	}
	else {
		
		$u = $con-> real_escape_string($u);
		$p = $con-> real_escape_string($p);
		$p2 = $con-> real_escape_string($p2);
		$e = $con-> real_escape_string($e);
		$vkey = md5(time().$u);
		$token = md5(time().$p);
		$ignore_token = md5(time().$e.$p);
		$bio = 'This user has not written a bio yet.';
		$pfp = 'Default.png';
		$p = md5($p);
		$tag = $u;
		$online = 0;
		$recovery_token = md5($e.time());
		$insert = $con->query("INSERT INTO accounts(username,password,email,vkey,Bio,Image,Token,Tag, Online,RecoveryToken,BirthDay,Age,notifications,Ignore_Token)
		VALUES( '$u', '$p', '$e', '$vkey','$bio','$pfp','$token','$tag','$online','$recovery_token','$age_check','$age','$notfiy','$ignore_token')");
	
		if ($insert){
			echo "<center>";
			echo "<div id = success>";
			echo "<h2 style=color:#269900>Your account has been created $u</h2>";
			echo "<h3 style=color:#269900>Check $e to verify your account</h3>";
			echo "</div>";
			echo "<br/>";
			echo "</center>";
			$to = $e;
			$sub = "Verification";
		    //$message = "<a href='megatoweldb.000webhostapp.com/Verify.php?vkey=$vkey'> Verify Your Account </a>";
		    $message = "<a href='http://localhost/MegaTowel/Verify.php?vkey=$vkey'> Verify Your Account </a>";
			$headers = "From: ianwchanner@gmail.com \r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset:UTF-8" . "\r\n";
			
			mail($to,$sub,$message,$headers);
			
		}
		else{
			echo "<center>";
			echo "<h2 style=color:red id = error>A connection error occured, sorry...</h2>";
			echo "</center>";
		}
	
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


a:visited{

	color:white;
}

a:hover{

	color:green;
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
</style>

<div>

	<center>
		<img src="https://megatowel.io/favicon.ico" position; top-left height = 100 width = 100 />

<head>
    <h1 style="color:white;"> Create an Account</h1>
   	<hr   width = 300 class = "new1"></hr>
</head>

<body bgcolor = #4d4d4d>
    <form method="POST" name="name" action="">
    <table>
    <tr>
     
        <td> <input type="TEXT" name ="u" placeholder = "Username" required/></td>


   </tr>

   <tr>
        
        <td> <input type="PASSWORD" name ="p" placeholder = "Password" required/></td>


   </tr>


   <tr>
    
        <td> <input type="PASSWORD" name ="p2" placeholder = "Confirm Password" required/></td>


   </tr>

    <tr>
        
        <td> <input type="EMAIL" name ="e" placeholder = "Email" required/></td>


   </tr>


	<tr>
	<td>

	<lable style="color:white;">Birthday:</lable><br/>
	<select name = "day" required>
	<option value="">Day</option>
	<?php

		for($day = 1; $day <= 31; $day++){

			echo "<option value = '".$day."'>".$day."</option>";
		}
	?>
	</select>

	<select name = "month" required>
	<option value="">Month</option>
	<?php
		for($month = 1; $month <= 12; $month++){
			echo "<option value = '".$month."'>".$month."</option>";
		}
	?>
	
	</select>	
	<select name = "year" required>
	<option value="">Year</option>
	<?php
		$y = date("Y", strtotime("+8 HOURS"));
		for($year = 1900; $y >= $year; $y--){
			echo "<option value = '".$y."'>".$y."</option>";
		}
	?>
	</select>

	</td>

	</tr> 
   <tr>
 
        <td> <input type="SUBMIT" name ="submit" value = "Register" required/> </td>


   </tr>
        
    </table>
    </form> 


<script>

document.getElementById("error").onclick = function() {closeError()};

function closeError() {
    
    window.location.href = 'Register.php';
}

</script>
 
</body>
</center>
</div>
<?php 
echo $error;
?>  
</body>

</html>


