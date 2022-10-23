<?php




session_start();

error_reporting(0);
echo "<span id=nav></span>";
echo "<div class=container>";
echo "<div class=bars>";

$id = $_SESSION['id'];
$chat_name = $_GET['name'];
$con_chat = NEW MySQLi('localhost', 'root', '', 'megatowel_chat');
$con = NEW MySQLi('localhost', 'root', '', 'megatowel');
$con_group = NEW MySQLi('localhost', 'root', '', 'megatowel_groupchat');


$fetch = $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name");
$user = $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name AND recipient_id = $id");
$user2= $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name AND starter_id = $id");

$row = $fetch->fetch_assoc();



if($user->num_rows){

  $user_id=$row['starter_id'];
  $name = $con->query("SELECT * FROM accounts WHERE id = $user_id");
  $name_row = $name->fetch_assoc();
  $user_name = $name_row['username'];
  $added = $user_id;

}





if($user2->num_rows){

  $user_id=$row['recipient_id'];
  $name = $con->query("SELECT * FROM accounts WHERE id = $user_id");
  $name_row = $name->fetch_assoc();
  $user_name = $name_row['username'];
  $added = $user_id;

}



$_POST['added']=$added; 


 

$group_check =  $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name");
$row = $group_check->fetch_assoc();
$is_group = $row['group_id'];



if($is_group != 0){

  $stat = "Invite Users";
  $stat_id = "inv";
  $group_name = $con_chat->query("SELECT * FROM message_count WHERE id = $chat_name");
  $row = $group_name->fetch_assoc();
  $user_name = $row['name'];

}

if($is_group == 0){

  $stat = "Create DM";
  $stat_id = "fr";

}


echo "<h2 class=move style=color:white;>$user_name</h2>";

echo "<button id=$stat_id style=position:absolute;right:30;top:20;width:100;padding-top:5;padding-bottom:5>$stat</button>";
echo"</div>";
echo"</br>";
echo "<center>";
///echo "<div class = container>";
echo "<div id = scroll class=msgbox>";
echo "<button id = help class= fixed onclick='myFunction()'>Scroll back</button>";
echo "<span id='messages'></span>";
//echo "<span id='gay'></span>";
echo "</div>";
echo"</center>";
echo "</body>";
echo "<div class=dms>";



$dms = $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id AND recipient_id != 0");
$dms2 = $con_chat->query("SELECT * FROM message_count WHERE recipient_id = $id");



$friend_1 = $con->query("SELECT * FROM friends WHERE User_1 = $id");
$friend_2 = $con->query("SELECT * FROM friends WHERE User_2 = $id");


$friend_3 = $con->query("SELECT * FROM friends WHERE User_1 = $id");
$friend_4 = $con->query("SELECT * FROM friends WHERE User_2 = $id");


echo "<div id = invfriends class=invfriends> ";



if($friend_3->num_rows != 0){

  while($friend_row = $friend_3->fetch_assoc()){

    $id_f = $friend_row['User_2'];

    $name = $con->query("SELECT * FROM accounts WHERE id = $id_f");

    $name_row = $name->fetch_assoc();
    $names = $name_row['username'];

    echo "<div class=user>"; 
    echo "<h3 style=color:white;>$names</h3>";echo "<button id = $id_f class=inv>Invite</button>";
    echo "</div>";
    echo "</br>";
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
      
      $('#<?php echo $id_f ?>').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'Add.php?name=<?php echo $chat_name?>&added=<?php echo $id_f ?>',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
    
        });
    });

</script>
<?php 

   }
}


if($friend_4->num_rows != 0){

  while($friend_row = $friend_4->fetch_assoc()){

    $id_f = $friend_row['User_1'];

    $name = $con->query("SELECT * FROM accounts WHERE id = $id_f");

    $name_row = $name->fetch_assoc();
    $names = $name_row['username'];
    
    echo "<div class=user>"; 
    echo "<h3 style=color:white;>$names</h3>";echo "<button id = $id_f class=inv>Invite</button>";
    echo "</div>";
    echo "</br>";
?>

<script type="text/javascript">
      
      $('#<?php echo $id_f ?>').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = 'Add.php?name=<?php echo $chat_name?>&added=<?php echo $id_f ?>',
        data =  {'action': clickBtnValue};
        $.post(ajaxurl, data, function (response) {
    
        });
    });

</script>
<?php 
           
  }
}


echo "</div>";

  




echo "<div id=friends class=friends> ";

echo "<form id=create method=post>";

if($friend_1->num_rows != 0){

  while($friend_row = $friend_1->fetch_assoc()){

    $id_f = $friend_row['User_2'];

    $name = $con->query("SELECT * FROM accounts WHERE id = $id_f");

    $name_row = $name->fetch_assoc();
    $names = $name_row['username'];

    echo "<div class=user>"; 
    echo "<h3 style=color:white;>$names</h3>";echo "<input type=checkbox name=fr[] value=$id_f class=inv></input>";
    echo "</div>";
    echo "</br>";


   }
}




if($friend_2->num_rows != 0){

  while($friend_row = $friend_2->fetch_assoc()){

    $id_f = $friend_row['User_1'];

    $name = $con->query("SELECT * FROM accounts WHERE id = $id_f");

    $name_row = $name->fetch_assoc();
    $names = $name_row['username'];
    
    echo "<div class=user>"; 
    echo "<h3 style=color:white;>$names</h3>";echo "<input type=checkbox name=fr[]  value=$id_f class=inv></input>";
    echo "</div>";
    echo "</br>";
       
  }
}

echo "<input class=create type=submit name=create value='Create DM'></input>";
echo "</div>";

echo "</form>";

$query = $con_chat->query("SELECT * FROM message_count");
$next1= $query->num_rows;
$next = $next1+=1;
if(isset($_POST['create'])){

  

if(!empty($_POST['fr'])){


      $actual_names = $con->query("SELECT * FROM accounts WHERE id = $id");

      $fetch = $actual_names->fetch_assoc();

      $user_names = $fetch['username'];

      $name = "$user_names''s Group($next)";

      $group_favicon = "Default.png";
      $con_chat->query("INSERT into message_count(starter_id,group_id,name,favicon)VALUES('$id','$next','$name','$group_favicon')");

      $con_group->query("CREATE TABLE `megatowel_groupchat`.`$next` ( `id` INT NOT NULL AUTO_INCREMENT , `recipient` INT NOT NULL,PRIMARY KEY  (`id`)) ENGINE = InnoDB;");

      $con_chat->query("CREATE TABLE `megatowel_chat`.`$next` ( `id` INT NOT NULL AUTO_INCREMENT ,  `msg` TEXT NOT NULL ,  `Sender` TEXT NOT NULL ,  `Favicon` VARCHAR(45) NOT NULL ,  `Date` TIMESTAMP NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;");
      
      $con_group->query("INSERT INTO `$next`(recipient)VALUES('$user_id')");

      header("Location: Chat.php?name=$next");

  


foreach($_POST['fr'] as $selected){

      $con_group->query("INSERT INTO `$next`(recipient)VALUES('$selected')");
  }
 }
}





   if($dms->num_rows != 0)

        while($row = $dms->fetch_assoc()){

            $user_id = $row['recipient_id'];

            $redirect = $con_chat->query("SELECT * FROM message_count WHERE starter_id = $id AND recipient_id = $user_id");

            $redirect_row = $redirect->fetch_assoc();

            $url = $redirect_row ['id'];
            
            $name = $con->query("SELECT * FROM accounts WHERE id = $user_id");
            $name_row = $name->fetch_assoc();
            
            $user = $name_row['username'];
            $pfp  = $name_row['Image'];


             echo "<a id=click href=Chat.php?name=$url><div class=user>";
             echo "<img class=p src='images/".$pfp."' height = 40; width = 40;></img>"; echo "</br>"; echo "<h3 style=color:white;>$user</h3>";
             echo "</br>";
             echo "</div></a>";
             echo "</br>";
        }

    //}  




$group_ch = $con_chat->query("SELECT * FROM message_count WHERE group_id != 0 AND starter_id = $id");

$num = $con_chat->query("SELECT * FROM message_count WHERE group_id != 0");

$last = $con_chat->query("SELECT * FROM message_count WHERE group_id != 0 ORDER BY id DESC LIMIT 1");

$fetch_last = $last->fetch_assoc();

$last_id = $fetch_last['group_id'];

$total = $num->num_rows+$last_id;


$first = $con_chat->query("SELECT * FROM message_count WHERE group_id != 0 ORDER BY stamp ASC LIMIT 1");
$fetch_f = $first->fetch_assoc();
$first_id = $fetch_f['group_id'];


for($i = $first_id; $i < $total ; $i++){


$cd = $con_group->query("SELECT * FROM `$i` WHERE recipient = $id");

if($cd->num_rows != 0){

    $group = $con_chat->query("SELECT * FROM message_count WHERE group_id = $i");

   $fetch = $group->fetch_assoc();

    $name = $fetch['name'];
    $pfp = $fetch['favicon'];
    $i = $fetch['id'];

  
             echo "<a id=click href=Chat.php?name=$i><div class=user>";
             echo "<img class=p src='images/".$pfp."' height = 40; width = 40;></img>"; echo "</br>"; echo "<h3 style=color:white;>$name</h3>";
             echo "</br>";
             echo "</div></a>";
             echo "</br>";

 }


}


    if($group_ch->num_rows != 0){

        while($group_rows = $group_ch->fetch_assoc()){


             $name = $group_rows['name'];
             $pfp = $group_rows['favicon'];
             $i = $group_rows['group_id'];


             echo "<a id=click href=Chat.php?name=$i><div class=user>";
             echo "<img class=p src='images/".$pfp."' height = 40; width = 40;></img>"; echo "</br>"; echo "<h3 style=color:white;>$name</h3>";
             echo "</br>";
             echo "</div></a>";
             echo "</br>";


        }
    }




  







    if($dms2->num_rows != 0){
 
        while($row = $dms2->fetch_assoc()){
            
  
            $user_id = $row['starter_id'];

            $redirect = $con_chat->query("SELECT * FROM message_count WHERE starter_id = $user_id AND recipient_id = $id");

            $redirect_row = $redirect->fetch_assoc();

            $url = $redirect_row ['id'];


            $name = $con->query("SELECT * FROM accounts WHERE id = $user_id");
            $name_row = $name->fetch_assoc();
            
            $user = $name_row['username'];
            $pfp  = $name_row['Image'];

          
            echo "<a id=click href=Chat.php?name=$url><div class=user>";
            echo "<img class=p src='images/".$pfp."' height = 40; width = 40;></img>"; echo "</br>"; echo "<h3 style=color:white;>$user</h3>";
            echo "</div></a>";
            echo "</br>";        

        }
      
    }

echo"</div>";

?>








<html>


<style>

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

h2.move{

    position: absolute;
    top:30;
}

h2.t{

  float:left;

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

input[type=submit].create{

  position: fixed;

  top:500;
  right: 130;
}

div.bars{
 
 width: 480px;
 height: 20px;
 border-radius: 5px;
 background-color:  #333333;
 padding: 20px;


}

button{

  width:100;
  float: right;
}

input[type="checkbox"].inv{

  margin-top : -40px;
  float: right;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

input[type="checkbox"]:checked {

  box-shadow: 0 0 0 3px purple;
}

h4 {
  margin: 0;
  display: inline-block;
}

div.invite{

 border-radius: 5px;
 background-color:  #262626;
 padding: 20px;
 width: 260px;
 height: 50px;
 padding-bottom: 25px;
 padding-top: 25px;

}

button.inv{


  margin-top : -50px;
  width:100;
  float: right;
}

div.user{
 width: 250px;
 border-radius: 5px;
 background-color:  #262626;
 padding: 20px;

}

div.user:hover{

  background-color: #1a1a1a;
}



div.container{

 position: fixed;
 left:360;
 top: 100;
 width: 520px;
 height: 450px;
 border-radius: 5px;
 background-color:  #262626;;
 padding: 20px;
 

}

div.friends {
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


div.invfriends {
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


button.fixed{
  position: fixed;
  top: 194;
  width:510px;
  padding-bottom: 5px;
  padding-top: 5px;


}

div.dms{

 overflow-y: auto;
 position: fixed;
 top: 100;
 left:10;
 width: 300px;
 height: 450px;
 border-radius: 5px;
 background-color:  #333333;
 padding: 20px;
 width:300px; 
 

}






div.msgbox {
  border-radius: 5px;
  background-color:  #333333;
  padding: 5px;
  height: 250px;
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


<script> $jq132 = jQuery.noConflict(true); </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
  var elmnt = document.getElementById("end");
  elmnt.scrollIntoView(true);
</script>


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

  <center>
    <form method="POST" id = "send" name="name_form" action="">
        <td> <input type="TEXT"  autocomplete="off" class="poop" placeholder = "Message <?php echo $user_name ?>" id = "cu" name ="cu" required/></td><td> <input type="SUBMIT" id = "submit" name ="submit"  value = "Send" required/> </td>     
    </table>
    <br/>
    


  </center>




    </body>

  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>


    <script>

    document.getElementById("submit").style.display = "none";

    $(document).ready(function(){
       $("#messages").load("ChatLoad.php?name=<?php echo $chat_name ?>");
    });


    $('#fr').click(function(){
   
        document.getElementById("friends").style.display = "block";
              
    });

    document.getElementById("invfriends").style.display = "none";

     $('#inv').click(function(){
   
        document.getElementById("invfriends").style.display = "block";
              
    });
 


</script>


<script>

var test = document.getElementById("scroll").scrollTop;
var elem = document.getElementById("scroll");  
var a = localStorage.setItem('pos',test);

elem.scrollTo(0, 500);


</script>

<script>
    

    $(function () {

         $('#send').on('submit',function (e) {

              $.ajax({
                type: 'post',
                url: 'client.php?name=<?php echo $chat_name ?>',
                data: $('#send').serialize(),
                success: function () {
                  
                  document.getElementById("cu").value = "";

                  var elem = document.getElementById("scroll");


                  elem.scrollTop = elem.scrollHeight;


              
                }

              });
          e.preventDefault();
        });
    });


</script>


  


    <script>


    document.getElementById("help").style.display = "none";

    jQuery(function($) {
    $('#scroll').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {

           document.getElementById("help").style.display = "none";
        }

        else{

            document.getElementById("help").style.display = "block";
        }
      })
    });


     $('#scroll').on('scroll', function() {
        if($(this).scrollTop()+$(this).height() < 3000) {


            //console.log($(this).scrollTop());
            //document.getElementById("help").style.display = "none";
        }
      })
  

    $(function () {


        $('#send').on('submit',function (e) {

              $.ajax({
                type: 'post',
                url: 'SendMessage.php?name=<?php echo $chat_name ?>',
                data: $('#send').serialize(),
                success: function () {

                  
                
                }
              });
          e.preventDefault();
        });
    });




</script>


<script type="text/javascript">
  
document.getElementById("friends").style.display = "none";

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
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script>
  

var socket = io.connect("http://localhost:3001");


socket.on("new_order",function(data){



})


</script>

</body>

</html>

<?php


echo "</div>";

?>