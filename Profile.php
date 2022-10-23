
<!DOCTYPE html>

<html>

<head>


</head>

 <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.1.0/video-js.css" rel="stylesheet">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.1.0/video.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-youtube/2.6.1/Youtube.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-youtube/2.6.1/Youtube.js"></script>

 <video  muted id="player" res='1080' src="https://vjs.zencdn.net/v/oceans.mp4" class="video-js" controls preload="auto" width="640" height="264">
    <source id="mp4" src="https://vjs.zencdn.net/v/oceans.mp4" type='video/mp4'>
 </video>



</html>



<?php

//TODO:
//Chat
//People list
//Front End

error_reporting(0);
include("vendor/autoload.php");

use ElephantIO\Client;
use ElephantIO\Engine\SocketIO\Version2X;

session_start();

$_SESSION['id'] = uniqid();

if($_SESSION['room'] != $_GET['room']){

  unset($_SESSION['owner']);
}
else{

  $_SESSION['owner'] = true;
}



$url = '';
$owner = $_SESSION['owner'];
$currentRoom = $_GET['room'];
$id = $_SESSION['id'];

$version = new Version2X("https://lit-fjord-99581.herokuapp.com/");
$client = new Client($version);
$client->initialize();

if(isset($_POST["uploadfile"])){

  $video = $_FILES['file']['tmp_name'];
  $videoName = $_FILES['file']['name'];
  $videoSize = $_FILES['file']['size'];
  $fileExt = explode('.', $videoName);
  $fileRealExt = strtolower(end($fileExt));

  $allowed = array('mp4', 'webm', 'mov', 'ogv');

  if(in_array($fileRealExt, $allowed)){

    if($vieoSize < 1000000){

      $newName = uniqid('', true).".".$fileRealExt;
      $tar = "videos/".$newName;

      if (move_uploaded_file($_FILES['file']['tmp_name'], $tar)) {
      
      }
      else{

        echo "Error uploading video";
      }
    

        $url = "https://coachsfinest.com/Streaming/videos/".$newName;

        $client->emit("changeVideo", array("Video" => $url, "Room"=> $currentRoom));

        ?>

        <script>
    
          document.getElementById("mp4").setAttribute("src", <?php echo json_encode($url) ?>);

        </script>

        <?php

    }
    else{

       echo "Video can not be over 100mb!";
    }
  }
  else{

    echo "Video format is not supported!";
  }
}

if(isset($_POST['submit'])){

  $url =  $_POST['url'];

  $client->emit("changeVideo", array("Video" => $url, "Room"=> $currentRoom));

  ?>

  <script>
    
    document.getElementById("mp4").setAttribute("src", <?php echo json_encode($url) ?>);

  </script>


  <?php

}


?>


<style>
  
.vjs-tech {
  pointer-events: none;
}


</style>

<html>

<form id="myForm" method="post">

<input type="text" name="url" required placeholder="Enter URL">

<input type="submit" name="submit"  value="Change Video">

</form>

<form id="upload" enctype="multipart/form-data" method="post">
  
<input type ="file" required name='file'>

<input type="submit" name="uploadfile" value="Upload File">

</form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>



<script>

var currentRoom = <?php echo json_encode($currentRoom) ?>;
var owner = <?php echo json_encode($owner) ?>;
var id = <?php echo json_encode($id) ?>;
var paused = true;
var started = false;
var ready = false;
var socket = io.connect("https://lit-fjord-99581.herokuapp.com/");


console.log("Connected to room: " + currentRoom);


if(owner){

  socket.emit("changeVideo", {Video:  document.getElementById("mp4").getAttribute("src"), Room: currentRoom});
  document.getElementById("myForm").style.display = "block";
}
else{
  
  socket.emit('reqCatchUp', id, currentRoom);

  videojs('player').controlBar.playToggle.disable();
  videojs('player').controlBar.progressControl.disable();
  videojs('player').bigPlayButton.disable();

  document.getElementById("myForm").style.display = "none";
  document.getElementById("upload").style.display = "none";
}

socket.on("connect", () => {

  socket.emit('reqCatchUp', id, currentRoom);
  
});


videojs('player').ready(function() {
            
    var player = this;    
    
    player.controlBar.playToggle.on('mouseup', function(event){
        
        if(owner && paused){
            
          ///socket.emit("pause", false, currentRoom);
        
        }
    });
    
    player.bigPlayButton.on('mouseup', function(event){
        
        if(owner){
            
          //socket.emit("pause", false, currentRoom);
        }
    });
    
    player.controlBar.progressControl.seekBar.on('mousedown', function(event) {
         
         if(owner){ 
            
            socket.emit("update", player.currentTime(), currentRoom);
         }
    });

    player.on("pause", function(){
      
      
    });

    player.on("play", function(){
        
      started = true;
      
    });

    player.controlBar.progressControl.on('mouseup', function(event) {
                 
        if(owner){
        
            socket.emit("update", player.currentTime(), currentRoom);
        }
               
    });

    player.on("ended", function(){
      
      player.pause();
      socket.emit("pause", player.paused(), currentRoom);
    
    });
    
    setInterval(function(){
        
        socket.emit("pause", player.paused(), currentRoom);
        
    }, 100);
    
    setInterval(function(){
        
      if(player.readyState() == 1){

          ready = false;
      }
      if(player.readyState() == 4 && !ready){

        console.log("Video loaded!");
        
        socket.emit('reqFinishLoad', id, currentRoom);
        
        ready = true;   
      }
      
    },1000);




  socket.on('changeVideo', function(data){

    if(data.Room == currentRoom){

      player.src([

            {type: "video/mp4", src: data.Video}
        
        ]);
    }
  })

   socket.on('reqFinishLoad', function(userId, room){
      
      if(room == currentRoom && owner){ 
        
        socket.emit('finishLoad',userId, player.currentTime(), currentRoom);
      }
   })

   socket.on('reqCatchUp', function(userId,room){

    if(room == currentRoom && owner){

      var url = document.getElementById("mp4").getAttribute("src");

      socket.emit('catchUp', userId, player.currentTime(), url, player.paused(), started, currentRoom);
    }

  })


  socket.on('finishLoad', function(userId, time, room){

       if(userId == id && room == currentRoom && !owner){
            
            player.currentTime(time);

            ready = true;
       }

       if(owner){ 
        
        setTimeout(function(){

          socket.emit("update", player.currentTime(), currentRoom);         

        }, 3000); 
      }

  })


  socket.on('catchUp', function(userId, time, video, pause, started, room){

    if(userId == id && room == currentRoom && !owner){

        player.src([

            {type: "video/mp4", src: video}
        
        ]);     

        player.currentTime(time);

        if(started){
          
          if(pause){
             
              player.pause();
          }
          else{
              
            player.play();  
          }
        }
      }

      if(owner){ 
        
        setTimeout(function(){

          socket.emit("update", player.currentTime(), currentRoom);

        }, 3000); 
      }
  })

  socket.on("pause", function(pause,room){

    if(room == currentRoom){ 
    
        if(!owner){
      
          if(pause){

            player.pause();
          }
          else{
              
              player.play();          
          }
              
            if(owner){     
              
              setTimeout(function(){

                  socket.emit("update", player.currentTime(), currentRoom);

                }, 3000);
              }
            }
     }  
  })

  socket.on('update', function(time,room){

      if(room == currentRoom){

        if(!owner){

          player.currentTime(time);
          
        }
    }
  })

});


</script>

</html>9) balance: 2KCl + H2SO4  K2SO4 + 2HCl. Is Soluble
10) balance: NaCI + H2O. Products: NaCl. Not soluable
11) balance: 2Fe(OH)3 + 3BaBr2. Products: BaBr2, Fe(OH)3. Not soluable 
12) balance: 3NaCl + FePO4. Products: NaCl, FePO4 .Not soluable 
13)
14)