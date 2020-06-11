
<?php

ob_start();
session_start();	


if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {

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
	
	include("Connection.php");
    
   
	$token = $_SESSION['user'];
  	$token = $_SESSION['user'];
  	$online = $con->query("UPDATE `accounts` SET `Online` = '1' WHERE Token = '$token'");

   	if(isset($_POST['Search'])){
  
      $u = $_POST['Name'];
      $auto_auth = $_SESSION['u'];
    
      if($u == $auto_auth){
          
           header("Refresh:0");
      }
      
      	else{

            $url = "User.php?u=" . $u;
            header('Location: ' . $url);

      	}


  	}
   
	$grab = $con->query("SELECT * FROM accounts WHERE Token = '$token'");
	$row = $grab->fetch_assoc();
	$verified = $row['Member'];
	$email = $row['email'];
	$date = $row['date'];
	$date = strtotime($date);
	$date = date('M d Y', $date);
	$bio = $row['Bio'];
	$pfp_var = $row['Image'];
  $us = $row['username'];
  $tag = $row['Tag'];
 	$_SESSION['image']=$pfp_var;
 	
   
	if($grab->num_rows != 0 && $verified == 1){

  echo "<span id = nav></span>";
	 echo "<div class = profile>";
   	$none = "NO FILE DEFINED";
       echo "<br/>";
    echo"<div id = test>";
    echo "<img class = pic id=pic src='images/".$row['Image']."' height = 100; width = 100;>";
    echo "</div>";

      echo "<div id = c>";
		echo "<br/>";
		echo "<form name=picture enctype = multipart/form-data method = post>";
		echo "<input type =file id = file class=custom-file-input name = file required/> </input>";
		echo '<input required type=SUBMIT onchange=myFunction() id=some class = pfp name =submit_pfp value="' . $none . '"/>';
	
		echo "</form>";


		echo "<h2 style=color:white;  >$us</h2>";
	  echo "<small style=color:white;  >@$tag</small>";
    echo "<br/>";
    echo "<br/>";
    echo "<button id = edit>Profile</button>";
    echo "<h4 style=color:white;  >$bio</h4>";
	  echo "<h5 style=color:white;  >Account created: $date</h5>";


    echo "</div>";
	}

	else{


	}
	 
	 

	if(isset($_POST['submit_pfp'])){
    	 
    	    
    	    
    	    $tar = "images/".basename($_FILES['file']['name']);
    	    $pfp = $_FILES['file']['name'];
    	    $upload = $con->query("UPDATE accounts SET Image = '$pfp' WHERE Token = '$token'");
    	    
    	   if (move_uploaded_file($_FILES['file']['tmp_name'], $tar)) {
    	       
  	      		header("Refresh: 0");

  	        	
        	}else{
        	    
  	            echo "Failed to upload image";
  	            exit();
  	        }
    	   
    	}
    	
    	
	    if(isset($_POST['submit'])){
	      
	        $cu = $_POST['cu'];
	        $acc = $con->query("SELECT * FROM accounts WHERE Token = '$token'");
	       
              
	       $acc2 = $con->query("SELECT Bio FROM accounts WHERE Token = '$token'");
	  
	       $acc2 = $con->query("UPDATE accounts SET username = '$cu' WHERE Token = '$token'");
	        
	        header("Refresh:0");
	        ob_end_flush();
	        die();
	     
	   }
	   
	 
	   if(isset($_POST['submit_email'])){
	       
	       
	       
	       $ne = $_POST['ce'];
	       $_SESSION['newemail'] = $ne; 
	       
	       $vkey = md5(time().$token);
	       
	       $con->query("SELECT * FROM accounts WHERE Token = '$token'");
	       $con->query("UPDATE accounts SET Member = 0 WHERE Token = '$token' LIMIT 1");
	       $con->query("UPDATE accounts SET vkey = '$vkey' WHERE Token = '$token' LIMIT 1");
           $con->query("UPDATE accounts SET email = '$ne' WHERE Token = '$token'");

	       $to = $ne;
		   $sub = "Re-Verification";
		   ///$message = "<a href='megatoweldb.000webhostapp.com/Verify.php?vkey=$vkey'> Re-Verify Your Account </a>";
       	   $message = "<a href='http://localhost/MegaTowel/Verify.php?vkey=$vkey'> Re-Verify Your Account </a>";
		   $headers = "From: ianwchanner@gmail.com \r\n";
		   $headers .= "MIME-Version: 1.0" . "\r\n";
		   $headers .= "Content-type:text/html;charset:UTF-8" . "\r\n";
	       mail($to,$sub,$message,$headers);
			
			
			
		   header("Location: NewEmail.php");
		
	     
	   }
        
       if(array_key_exists('Logout',$_POST)){
           
           header("Location: login.php");
           $con->query("UPDATE accounts SET Online = 0 WHERE Token = '$token'");
           session_destroy();

       }
            
       
    
       if(isset($_POST['submit_pass'])){
           
           	
           $cp = $con->real_escape_string($_POST['pass']);
        
           $cp = md5($cp);
           $grab = $con->query("SELECT * FROM accounts WHERE Token = '$token' AND password = '$cp' LIMIT 1");
           
           $np = $con->real_escape_string($_POST['upd_pass']);
           $np = md5($np);
           
           if($grab->num_rows != 0){
            
               $con->query("UPDATE accounts SET password = '$np' WHERE Token = '$token' LIMIT 1");
               header("Refresh:0");
           }
           else if(strlen($len_check) < 3){

            echo  "<p> Password must be at least 4 characters</p> ";

           }
           else{
               
               echo "Wrong Password";
           }

         
       }    
	   
	   if(isset($_POST['submit_bio'])){
	       
	       header("Refresh:0");
	  
           $upd_bio = $_POST['upd_bio'];
           
	       $con->query("UPDATE accounts SET Bio = '$upd_bio' WHERE Token = '$token' LIMIT 1");
	       
	       
	   }
	   else{
?>

<html>


<head>
  
<style>


img.pic {
  border-radius: 25%;
}


div.profile {
  border-radius: 5px;
  background-color:  #333333;
  padding: 20px;
  width: 300px;
  height: 800px;
}



h2{
  line-height: 0.1;
}

small{
  line-height: 0.1;
}

input[type=password] {
 width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  width:300;

}


input[type=email] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  width:300;

}

input.name {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  width:300;
}

textarea {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  width:300;
}

input[type=submit].pfp{

  position: absolute;
  top:115;
  	
  width: 300;
    line-height: 1px;
  background-color:#bf00ff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  display: inline-block


}

div.test{

	position:absolute;
}

input[type=submit].width {
  width: 100%;
  background-color:#bf00ff;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;


}
input[type=submit].warn {
  width: 100%;
  background-color:red;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.custom-file-input::-webkit-file-upload-button {
  visibility: hidden;
}

input[type='file'] {
  color: transparent;    
  direction: rtl;   
   position: absolute;
  
  top:38;  
   border-radius: 25%;
    height: 100px;
     width: 100px;
     background-color: #ccc; 
       opacity: 0.0;
       border: none;
}

img.add{
 position: absolute;
  right: 225;
  top:35;
  pointer-events:none;  
	
}

input[type='file']:hover{

	opacity: 0.5;
	border: none;
}

input[type='file']:active{

	 border: none;
}


input[type=submit]:hover {
  background-color: #8000ff;
}

input.warn:hover{

	 background-color:#b30000;
}



button {
  width: 50%;
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

div.settings {

 position: fixed;
  left:360;
 top: 100;
  width: 520px;
 height: 450px;
 border-radius: 5px;
 background-color:  #333333;
 padding: 20px;

   
  overflow-y: auto;
}

::-webkit-scrollbar {
display: none;
}

.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}


.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}
input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
body{

	overflow-y: hidden;
}

textarea {
        resize: none;
    }

div.online {
 	  
   
  position: absolute;
  right: 1160;
  top:110;  
  border-radius: 100%;
  height: 20px;
  width: 20px;
  background-color: green; 
   
}

</style>

</head>


         <img class = "add" id = "add" src="https://visualpharm.com/assets/60/Add%20User%20Male-595b40b85ba036ed117dbeb7.svg" position; top-left height = 0 width = 100 border= "0"/>


<body bgcolor=#4d4d4d onload="myFunction()">
 

<script>

document.getElementById("edit").onclick = function() {

  edit()

};

function edit() {
    
    window.location.href = 'Profile.php';
  
}

</script>

</script>
 


    <div class = "settings">
 
      <center>

    <h2 style=color:white>Profile Settings</h2>
    
    <form method="POST" name="name_form" action="">
    <table>
    <tr>
        <td></td>
    <td> <input class ="name" name ="cu" placeholder = "New Name" required  value = "<?php echo $us ?>" /></td>
    </tr>
    
    <tr>
        <td></td>
        <td> <input class = "width" type="SUBMIT" name ="submit" value = "Save Name" required/> </td>
    </tr>   
        
    </form>      
    </table>
    <br/>
   
    <form method="POST" name="bio_form" action="">
    <table>
    <tr>
        <td></td>
        <td> <textarea name ="upd_bio" placeholder = "New Bio" required></textarea></textarea></td>
   </tr>
   <tr>
        <td> </td>
        <td> <input  class = "width"  type="SUBMIT" name ="submit_bio" value = "Save Bio" required/> </td>
    </tr>   
        
      </table>
    </form>      
  <hr/>
 
    
<?php
    }
?>  
  <br/>
   <h2 style=color:white>Password Settings</h2>
   
    <form method="POST" name="pass_form" action="">
    <table>
        
        
    <tr>
       
        <td> </td>
        <td> <input  type = "PASSWORD"  name ="pass" placeholder = "Current Passwod"required/> </input></td>
   </tr>
        
    <tr>
       
        <td> </td>
        <td> <input type = "PASSWORD" name ="upd_pass" placeholder = "Updated Passwod" required/> </input></td>
   </tr>
   
   <tr>
        <td> </td>
        <td> <input  class = "width"  type="SUBMIT" name ="submit_pass" value = "Save Password" required/> </td>
    </tr>   
        
      </table>
    </form>
    <hr/>
    <br/>
    <h2 style=color:white>Email Settings</h2>
     <form method="POST" name="email_form" action="">
    <table>
    <tr>
       
        <td> </td>
        <td> <input type="EMAIL" placeholder = "New Email" name ="ce" value = "<?php echo $email ?>"required/></td>
   </tr>
   <tr>


        <td> </td>
        <td> <input  class = "width"  type="SUBMIT" name ="submit_email" value = "Save Email" required/> </td>
    </tr>   

    </form>      
    </table>

        <tr>
        	<td><lable style=color:white>Turn on Notifications</lable></td>
   <label class="switch">
   <input type="checkbox" checked>
   <span class="slider round"></span>
  </label>

   </tr> 

    <br/>
    <hr/>
    <br/>
      <h2 style=color:white>Account Settings</h2>
     <form method="POST" action="">
     <table>
     	<tr>
     	  <td> </td>
       <td> <input  class = "width"  type="SUBMIT" name ="2auth" value = "Enable Two-Factor Auth" required/> </td>
        </tr>  
     <tr>
     	
        <td> </td>
       
        <td> <input    type="SUBMIT" class = "warn" name ="Logout" value = "Logout" required/> </td>
    </tr> 

    	<tr>
     	  <td> </td>
       <td> <input    type="SUBMIT" class = "warn" name ="delete" value = "Delete Account" required/> </td>
        </tr>  
     <tr>  
        
    </form>      
    </table>
	</div>

      <style>
        div.fixed{
            
            position: absolute;
            left: 500px;
            top: 0px;
        }
     
        
    </style>
  
    <div class = "fixed">    
  
  
    </center>
         


<script type="text/javascript">
	
	document.getElementById("some").style.display = "none";
  
</script> 
 


<script>

 

	document.getElementById('file').onchange = function () {
 		
 		var path = this.value;
 		var filename = path.replace(/^.*\\/, "");
  		
  		document.getElementById("some").value = "Upload " + filename;
  		document.getElementById("some").style.display = "block";
  		document.getElementById("add").style.top = 12;
  		document.getElementById("file").style.top = 12;
  		document.getElementById("file").border = "none";
  		document.getElementById("test").style.marginTop=-27;
  		document.getElementById("c").style.marginTop=20;
  	   

  		
	};

	document.getElementById('file').onmouseover = function () {

		document.getElementById("add").height = 100;
		
	}


	document.getElementById('file').onmouseout = function () {

		document.getElementById("add").height = 0;
		
	}


</script>

 <script> $jq132 = jQuery.noConflict(true); </script>


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







</body>
</html>
<?php
}
?>

<?php
    include('NavBar.php');
?>





