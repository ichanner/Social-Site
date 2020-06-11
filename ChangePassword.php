<?php

if(isset($_GET['recovery_token'])){

	//$con = NEW MySQLi('localhost', 'id12635463_dev', 'fort4572', 'id12635463_mega');
    $con = NEW MySQLi('localhost', 'root', '', 'megatowel');

	$recovery_token = $_GET['recovery_token'];

	$acc = $con->query("SELECT RecoveryToken FROM accounts WHERE RecoveryToken = '$recovery_token' LIMIT 1");


	if ($acc->num_rows == 1){
		if(isset($_POST['submit_pass'])){
		
			 $np = $con->real_escape_string($_POST['cp']);
             $np = md5($np);
           
			 $change = $con->query("UPDATE accounts SET password = '$np' WHERE RecoveryToken = '$recovery_token'");


			 if($change){

			 	echo "Password changed to $np";
			 }


		}


		


	}

	else{

		echo "No longer accesible";

	}



}

?>


<html>
<style>

input[type=password], select {

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

<center>
<body bgcolor = #4d4d4d>
	<img src="https://megatowel.io/favicon.ico" position; top-left height = 100 width = 100 />
<h2 style="color:white;"> Change your password </h2>

 <form method="POST" name="email_form" action="">
    <table>
    <tr>
       
        <td> </td>
        <td> <input type="PASSWORD" size="50" autocomplete = "Off" placeholder = "New Password" name ="cp" required/></td>
   </tr>
   <tr>
        <td> </td>
        <td> <input type="SUBMIT" name ="submit_pass" value = "Change Password" required/> </td>
    </tr>   
        
    </form>      
    </table>
</br>
</br>
</br>
</div>
</body>
</form>

</center>
</html>