


<?php
	session_start();
	



	  if(!isset($_SESSION['logged_in'])){
  			
  			exit("Please login to view our site just for a little while!");

    }
	   if(!isset($_GET['u'])){
			
			   echo "Couldn't load profile";
	   }	


	  

	    $u = $_GET['u'];	
    
      include("Connection.php");

      $grab = $con->query("SELECT * FROM accounts WHERE username = '$u'");
      $row = $grab->fetch_assoc();
    
      $verified = $row['Member'];
	    $pfp_var = $row['Image'];
	    $date = $row['date'];
	    $date = strtotime($date);
	    $date = date('M d Y', $date);
	    $bio = $row['Bio'];
	    $pfp_var = $row['Image'];
      $us = $row['username'];
      $tag = $row['Tag'];
      $id = $row['id'];
      $online = $row['Online'];
      $Status = NULL;
    	$auto_auth = $_SESSION['u'];
      $id_send = $_SESSION['id'];
      $delete = $_SESSION['notify_token'];
     
      
      if($u == $auto_auth){
    	   
         return_home();
      }
      

      function return_home(){ 
           header("Location: Profile.php");
      }
 



  if($grab->num_rows != 0 && $verified == 1){

        
       if($online == 1){

          //$Status = "$us is Online :)";

       }

       else{

           ///$Status = "$us is Offline :(";

       }

       $status = "Friend"; 
     
       $friends_client_connection_1 = $con->query("SELECT * FROM friends WHERE User_1 = '$id'  AND User_2 = '$id_send'");
       $friends_client_connection_2 = $con->query("SELECT * FROM friends WHERE User_1 = '$id_send'  AND User_2 = '$id'");

       $pending_client_connection_1 = $con->query("SELECT * FROM request WHERE Sender = $id_send AND Reciever = $id");
       $pending_client_connection_2 = $con->query("SELECT * FROM request WHERE Sender = $id AND Reciever = $id_send");

       if($pending_client_connection_1->num_rows != 0 || $pending_client_connection_2->num_rows != 0){


          $status = "Pending";          

       }
   

  
       echo "<div class = profile>";
		   echo "<img src='images/".$row['Image']."' height = 100; width = 100; position:absolute;top>";  
       echo "<br></br>";
		   echo "<h2 style=color:white;  >$us</h2>";
       echo "<small style=color:white;  >@$tag</small>";

       echo "<br><br/>";




       if($friends_client_connection_2->num_rows != 0 || $friends_client_connection_1->num_rows != 0){
            echo "<form method=post>";
            echo "<input type=submit  name=Message value=Message style=width:100;></input>";
            echo "<input type=text  name=name style=width:100;></input>";
            echo "<input type=text  name=friend style=width:100;></input>";
            echo "</form>";
            $status = "Unfriend";

       }
      

       echo "<h4 style=color:white;  >$bio</h4>";
	     echo "<h5 style=color:white;  >Account created: $date</h5>";
       echo "<form method=post>";
       echo "<input type = submit id = status value = '$status' name = '$status'></input>";
       echo "<br></br>";
       echo "</form>";
       echo "</div>";
  
	}
	
  else{
	    
	    echo "<center><h2 style=color:white;>User doesn't exist</h2>";
	}




      
 
      

	


  if(array_key_exists('Friend',$_POST)){
           
          
      $con->query("INSERT into request(Sender,Reciever,Delete_Key) 
      VALUES('$id_send','$id','$delete')");
      header("Refresh:0");
           
  }



if($_POST['Message']){

      $check = $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id_send AND recipient_id = $id");
      $check2 = $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id AND recipient_id = $id_send");


  if($check->num_rows == 0 && $check2->num_rows == 0){
      
      $con_chat->query("INSERT into message_count(starter_id,recipient_id)VALUES('$id_send','$id')");       
      $chat = $con_chat->query("SELECT * FROM message_count");
      $chat_name = $chat->num_rows;
      $con_chat->query("CREATE TABLE `megatowel_chat`.`$chat_name` ( `id` INT NOT NULL AUTO_INCREMENT ,  `msg` TEXT NOT NULL ,  `Sender` TEXT NOT NULL ,  `Favicon` VARCHAR(45) NOT NULL ,  `Date` TIMESTAMP NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;");

      $chat =  $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id_send  AND recipient_id = $id");
      $row = $chat->fetch_assoc();
      $chat_name=$row['id'];
      $_SESSION['chat_name'] = $chat_name;

      $_SESSION['chat']='1';

      $_SESSION['friend']=$us;

      $_POST['name']=$chat_name;        
      $name = $_POST['name'];
      $url = "Chat.php?name=" . $name;
      header('Location: ' . $url);

    }

    $chat =  $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id_send AND recipient_id = $id");

    if($chat->num_rows != 0){
          
        $row = $chat->fetch_assoc();
        $chat_name=$row['id'];
        $_SESSION['chat_name'] = $chat_name;
        //header("Location: Chat.php?v=".$chat_name);
        $_SESSION['chat']='1';
        $_SESSION['friend']=$us;


        $_POST['name']=$chat_name;
     

        $name = $_POST['name'];
        $url = "Chat.php?name=" . $name;
        header('Location: ' . $url);
  
        //$_POST['friend']=$us;
        //header("Location: TestChat.php?name=".$_POST['name']);


    }

    $chat2 =  $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id AND recipient_id = $id_send");
    
    if($chat2->num_rows != 0){

        $row = $chat2->fetch_assoc();
        $chat_name=$row['id'];
        $_SESSION['chat_name'] = $chat_name;
        //header("Location: Chat.php?v=".$chat_name);
        $_SESSION['chat']='1';
        $_SESSION['friend']=$us;

        $_POST['name']=$chat_name;        
        $name = $_POST['name'];
        $url = "Chat.php?name=" . $name;
        header('Location: ' . $url);





    }
    
      

     
  }


  if($status == "Pending"){

      echo "<script>";
      echo "document.getElementById('status').style.backgroundColor = '#8000ff';";
      echo "document.getElementById('status').disabled = true;";
      echo "document.getElementById('status').style.pointerEvents = 'none';";
      echo "</script>";
  }

   if(array_key_exists('Unfriend',$_POST)){
           
          
      $con->query("DELETE FROM friends WHERE User_1 = $id_send AND User_2 = $id");
      $con->query("DELETE FROM friends WHERE User_1 = $id AND User_2 = $id_send");
      
      header("Refresh:0");
           
  }


?>

<style>

img {
  border-radius: 25%;
}


div.profile{
  border-radius: 5px;
  background-color:  #333333;
  padding: 20px;
  width: 300px;
  height: 800px;
}


button {
  width: 100%;
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

div.fixed{
            
    position: absolute;
    left: 500px;
    top: 0px;
}


h2{
  line-height: 0.1;
}

small{
  line-height: 0.1;
}


body{

  overflow-y:hidden;
}


input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  width:300;
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



input[type=submit]:hover {
  background-color: #8000ff;
}

     
</style>


    <body bgcolor=#4d4d4d>



  <span id="nav"></span>
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





    <div class = "fixed">    
    <center>
    <form method="POST" action="">
        
     <table>
    
     <tr>
        <br/>
        <td> </td>
   
        
    </form>      
    </table>
    </center>
    </div>


 
</body>


     <div class = "fixed" id = "con">    
    <center>




    <form method="POST" action="">
        
     <table>
    
     <tr>
        <br/>
        <td> </td>
   
    </table>
    </form>      
   


    <span id = "result"></span>   


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>






</center>
    </div>    

</html>
<?php
    include('NavBar.php');
?>

