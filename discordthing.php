<?php

session_start();

echo "<span id=nav></span>";
echo "<div class=container>";
echo "<div class=bars>";

echo "<h2 class='move' style=color:white;>Finest Websocket!</h2>";

echo"</div>";
echo"</br>";
echo "<center>";

echo "<div id = scroll class=msgbox>";

 echo "<div class='msgbody' id='body'> </div>";

echo "<br/>";

echo "</div>";
echo"</center>";
echo "</body>";
echo "<div class=dms>";

$chat_name = "Public-US";

$name = $_SESSION['name'];

if(empty($name) || empty($chat_name)){
    
    header('Location: '."Name.php");
   
}


?>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
  


   $(function () {

        $('#send').on('submit',function (e) {

              $.ajax({
                type: 'post',
                url: 'Send.php?name=<?php echo $chat_name ?>&sender=<?php echo $name ?>',
                data: $('#send').serialize(),
                success: function () {                
                
                    console.log("Success!");

                    document.getElementById("cu").value = "";

                    var scroll = document.getElementById("scroll");
                    scroll.scrollTop = scroll.scrollHeight;

                }
             
              });
          e.preventDefault();
        });
    });



</script>









<html>

<style>

input[type=submit] {
  
  position:fixed;
  top:99999;
  
}

h2.move{

    position: absolute;
    top:20;
}


input[type=text].poop {
  

  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  height: 40;
  width:520;
  position: absolute;
  top:360;
  right:20; 

}



div.bars{
 
 width: 480px;
 height: 20px;
 border-radius: 5px;
 background-color:  #333333;
 padding: 20px;

}


div.container{

 position: fixed;
 left:360;
 top: 100;
 width: 520px;
 height: 100%;
 border-radius: 5px;
 background-color:  #262626;;
 padding: 20px;
 

}


div.msgbox {
  border-radius: 5px;
  background-color:  #333333;
  padding: 5px;
  height: 50%;
  width: 98%;
  overflow-y: auto;
  text-align: left;
  word-wrap: break-word;

}


 ::-webkit-scrollbar {
    width: 0px;  
    background: transparent;  
}



</style>
     


  <body bgcolor=#4d4d4d>

  <center>
   
  <form method="POST" id = "send" name="send" action="">
        
      <input type="TEXT"  autocomplete="off" class="poop" placeholder = "Message" id = "cu" name ="cu" required/>
        
      <input type="SUBMIT" id = "submit" name ="submit"  value = "Send" required/>   
        
  </form>
    
  <br/>
    
  </center>


 

  <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <script>
  

  var socket = io.connect("http://localhost:2001");


  socket.on("new_msg",function(data){

    if(data.Channel == "<?php echo $chat_name ?>" ){

  
      $("#body").append("<b><p style=color:white;>"+data.Sender+"</b></br>"+data.Message+"</p>");
       
    }

  })


  </script>

</body>



</html>

<?php


  echo "</div>";

?>




