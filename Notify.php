<?php
ob_start();
session_start();
if(!isset($_SESSION['logged_in'])){
  
    exit("Failed to authenticate user!");
}
else{
include("Connection.php");
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


   // echo "<div id = red_back class = red></div>";
   //echo "<h3 id = num_not class = not style=color:white;><?php echo '$notification'


}


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
    width: 0px;  /* Remove scrollbar space */
    background: transparent;  /* Optional: just make scrollbar invisible */
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


button.decline:hover{

	 background-color:  #333333;
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


  <form method="POST" action="">


  <table>
    
      <tr>
      <br/>
   
  
      </tr>   
    
    </table>
  </form>      
   
  <span id = "result"></span>   

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  


<script type="text/javascript">
  
  var notifications = "<?php echo $notification; ?>";
  
  if(notifications == 0){

    document.getElementById("red_back").style.display = "none";
    document.getElementById("num_not").style.display = "none";

  }

</script>




</html>
<?php

    
   
 

    $notify = $con->query("SELECT * FROM request WHERE Reciever = '$id'");
    
      

      if($notify->num_rows != 0){




         while($row = $notify->fetch_assoc()){

            echo "<div class = sub>";
           
           
            $sender = $row['Sender'];
            $del = $row['Delete_Key'];
            $name_sender = $con->query("SELECT username FROM accounts WHERE id = '$sender'");
      
            if($name_sender->num_rows != 0){

                $row = $name_sender->fetch_assoc();
                $name = $row['username'];
           
                echo "<div class = request"; 
                echo "<h3></h3>";
                echo "<h3 style=color:white;><a href='User.php?u=$name'>$name</a> wants to be friends</h3>";
        
                echo"<form method=post id=som>";

                echo "<input type=submit  name='$sender' value=Accept></input>";echo"&nbsp";echo"<input  class = decline type=submit name=$del value=Decline style=background-color:red; color id = decline></input>";
                echo "</form>";

          }

          echo "</div>";
        echo "</div>";
      echo"<br/>"; 
    }


   
}

else{

  echo"<h2 style=color:white;>You have no notifications :(</h2>";
}


  

?>

<html>


</html>

        