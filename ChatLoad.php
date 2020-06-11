<?php
session_start();
$con_chat = NEW MySQLi('localhost', 'root', '', 'megatowel_chat');
$con = NEW MySQLi('localhost', 'root', '', 'megatowel');

 //$chat_name = $_SESSION['chat_name'];
if(!isset($_SESSION['chat'])){
    exit("Couldn't load chat!");
}

if(!isset($_GET['name'])){
    exit("Loading...");
}


else{

 $chat_name = $_GET['name'];
 $grab = $con_chat->query("SELECT * FROM `$chat_name`");

 //echo "<button class= fixed onclick='myFunction()'>Jump to Present</button>";
    while($row = $grab->fetch_assoc()){

       $msg= $row['msg'];
       $sender = $row['Sender'];
       $pfp = $row['Favicon'];
       
       
     	echo "<div class=msgbody>";
    	echo "<li class=c>";
      echo "<img class=p2 src='images/".$pfp."' height = 40; width = 40;></img><b><p   style=color:white;><a href='User.php?u=$sender'>$sender</a></b></br> $msg </p>";

   		echo "</li>";

      echo "</div>";

      
     }
       echo "<div id=content></div>";


}


?>

<html>


<style>
p.{

	line-height: 1;
	margin-left: auto;
	margin-right: auto;
  width: 8em


	  
}

button.fixed{
  position: fixed;
  top: 194;
  width:300px;
  padding-bottom: 5px;
  padding-top: 5px;


}

div.msgbody {
  border-radius: 5px;
  background-color: #333333;
  overflow:hidden;


}

li p{
	
	width: 250px; margin-left: 50px

}
.c{

  list-style: none;
}

div.msgbody:hover{

	 background-color:#262626;
}

img.p{

	float:left;
	margin-top:30px;
	margin-right:5px;
}

img.p2{

  float:left;
  margin-top:0px;
  margin-right:5px;
}





</style>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


<script>

  function myFunction() {
  var elmnt = document.getElementById("content");

  elmnt.scrollIntoView();

  document.getElementById("help").style.display = "none";
}


</script>


  <style>
div.msgbody {
  border-radius: 5px;
  background-color: #33333;
  overflow:hidden;


}
  </style>

 <link rel="shortcut icon" href="favicon/favicon.ico">
</head>



<body>
  

  <div class="msgbody" id="body">
  
  </div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
  

var socket = io.connect("http://localhost:3001");


socket.on("new_order",function(data){

    if(data.Channel == "<?php echo $chat_name ?>" ){

  
        $("#body").append("<li class=c><img class=p2 src='images/"+data.Avatar+"' height = 40; width = 40;></img><a href='User.php?u="+data.Sender+"''><b><p style=color:white;>"+data.Sender+"</b></a></br>"+data.Message+"</p></li>");

    }

  })


</script>

</body>

</html>

</html>