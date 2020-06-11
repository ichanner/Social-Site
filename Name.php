<?php

session_start();


if(isset($_POST['submit'])){
    
  $name =  $_POST['cu'];
  //$id = $_POST['id'];
  
  $_SESSION['name']=$name;

  header('Location: '."Chat");
  //header('Location: '."Chat?id=".$id);
    
}

  

//  <input type="TEXT"  autocomplete="off" class="poop" placeholder = "Chat room name?" id = "id" name ="id">

?>


<html>
    
    <style>
    
    input[type=submit] {
  
  position:fixed;
  top:99999;
  
}




input[type=text].poop {
  

  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  height: 40;
  width:50%;

}





        
        



    </style>
    
    <body>
        
        
    <center>
    
    <form method="POST" id = "send" name="name_form" action="">
    
    
    <input type="TEXT"  autocomplete="off" class="poop" placeholder = "What's your name?" id = "cu" name ="cu" required/>
    
    <input type="SUBMIT" id = "submit" name ="submit"  value = "Send" required/>      
  
    </form>

     </center>

    

        
    </body>
    
    
</html>