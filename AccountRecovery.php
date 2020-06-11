<?php

if(isset($_POST['submit_email'])){

	//$con = NEW MySQLi('localhost', 'id12635463_dev', 'fort4572', 'id12635463_mega');
	$con = NEW MySQLi('localhost', 'root', '', 'megatowel');

	$email = $_POST['ce'];
	
	$recovery = $con->query("SELECT * FROM accounts WHERE email = '$email'");

	if($recovery->num_rows != 0){

		$row = $recovery->fetch_assoc();
	    $username = $row['username'];
	}
	$recovery_token = md5($email.time());

	$token = $con->query("UPDATE accounts SET RecoveryToken = '$recovery_token' WHERE username = '$username'");

	if($token){

		echo "Check $email to recover your account";
	}



	$to = $email;
	$sub = "Account Recovery";    
	$message = "<a href='http://localhost/MegaTowel/ChangePassword.php?recovery_token=$recovery_token'> Hello $username,Change your  Password Here! </a>";
	$headers = "From: ianwchanner@gmail.com \r\n";
	$headers .= "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset:UTF-8" . "\r\n";
	mail($to,$sub,$message,$headers);


}


?>


<html>
<style>

input[type=email], select {

  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
  
  right: 555px;
  position: absolute;
  background-color:#bf00ff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
div {
  border-radius: 10px;
  background-color:  #333333;
  padding: 20px;
}
input[type=submit]:hover {
  background-color: #8000ff;
}
</style>
<div>	
<img src="https://megatowel.io/favicon.ico" position; top-left height = 100 width = 100 />
</div>
<center>
<body bgcolor = #4d4d4d>
	<br/>
	<br/>
<h2 style="color:white;"> Forgot your password? </h2>
<h3 style="color:white;">Enter your email below and we will send you a link to help you recover it. </h3>

 <form method="POST" name="email_form" action="">
    <table>
    <tr>
       
        <td> </td>
        <td> <input type="EMAIL" size="50" placeholder = "Linked email" name ="ce" required/></td>
   </tr>
   <tr>
        <td> </td>
        <td> <input type="SUBMIT" name ="submit_email" value = "Send Recovery Email" required/> </td>
    </tr>   
        
    </form>      
    </table>
    <br/>
    <br/>

</body>
</center>

</html>