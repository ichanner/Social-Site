<?php
ob_start();
session_start();
if(!isset($_SESSION['logged_in'])){
  
  exit();
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


<body id = "can" bgcolor=#4d4d4d>


  
 <div id = "bar" class = "bar">
 <span id = "hot"></span>

   
   <a href="index.php"><img src="https://megatowel.io:4000/megatowel.png" height = 70; width = 70; class = "none"/></a>
   <img id = "bell" class = "bell" src="https://megatoweldb.000webhostapp.com/images/bell-3-xxl.png" height = 40; width = 40; class = "none"/>
  <img  src="https://pngriver.com/wp-content/uploads/2018/04/Download-Open-Message-Png-Image-79206-For-Designing-Projects.png" height = 40; width = 40; />


  <form method="POST" action="">

      <br/>
      <input  type="TEXT" id = "search"  name ="Name" required/><input type="SUBMIT" class = "search" name ="Search" value = "Search" required/> 

  </form>      
   
  <span id = "result"></span>
 
 <div id = notifications class = notify>

  <span id="not"></span>

  
</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  
    <script>

    $(document).ready(function(){
        setInterval(function() {
            $("#not").load("Notify.php");
        }, 1000);
    });

    $(document).ready(function(){
        setInterval(function() {
            $("#hot").load("Bell.php");
        }, 1000);
    });

	$(document).ready(function(){
         $.ajax({

              url:"Bell.php",
              type:"post",
              data:{search: $(this).val()},
              success:function(result){

                $("#hot").html(result);
              }
          });

        });


		$(document).ready(function(){
         $.ajax({

              url:"Notify.php",
              type:"post",
              data:{search: $(this).val()},
              success:function(result){

                $("#not").html(result);
              }
          });

        });
   
    $(document).ready(function(){


      $("#search").keyup(function(){

          $.ajax({

              url:"Results.php",
              type:"post",
              data:{search: $(this).val()},
              success:function(result){

                $("#result").html(result);
              }
          });
      });
  });

</script>


<script>




</script>

<script> $jq132 = jQuery.noConflict(true); </script>
<script>

document.getElementById("notifications").style.display = "none";

document.getElementById("bell").onclick = function(){

  notification();

}

function notification(){

  document.getElementById("notifications").style.display = "block";
}

</script> 


<script type="text/javascript">


$(document).mouseup(function (e){

	var container = $("#notifications");

	if (!container.is(e.target) && container.has(e.target).length === 0){

		container.fadeOut();
		
	}
}); 


</script>

	


	





</div>




</html>
<?php


   
    echo "<a href='Profile.php'><img class = favicon src='images/".$row['Image']."' height = 50; width = 50; position:absolute;top;></a>";



    $notify = $con->query("SELECT * FROM request WHERE Reciever = '$id'");
    


      if($notify->num_rows != 0){




         while($row = $notify->fetch_assoc()){


            $sender = $row['Sender'];
            $del = $row['Delete_Key'];
            $name_sender = $con->query("SELECT username FROM accounts WHERE id = '$sender'");
      
            if($name_sender->num_rows != 0){


                $row = $name_sender->fetch_assoc();
                $name = $row['username'];

              
                if(isset($_POST[$del])){


                	$con->query("DELETE from request WHERE Delete_Key =  '$del'");
                	
                }


                if(isset($_POST[$sender])){

     

                	$con->query("INSERT INTO friends(User_1,User_2)VALUES('$sender','$id')");
                	$con->query("DELETE from request WHERE Sender =  '$sender'");
                    //header("Refresh:0");

        	    }
       
          }

 
    }


  

    
}



      

?>



        