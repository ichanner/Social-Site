<?php
    ob_start();
    session_start();
    $ne = $_SESSION['newemail'];
    echo "Check $ne to verify your new email";
        
      if(array_key_exists('l',$_POST)){
           
           header("Location: login.php");
           session_destroy();
           ob_end_flush();
       }
            
?>



<html>

<body>
    
    
     <form method="POST" action="">
     <table>
    
     <tr>
        <br/>
        <td> </td>
        <td> <input type="SUBMIT" name ="l" value = "Return to home" required/> </td>
    </tr>   
        
    </form>      
    </table>


    

 
</body>    

</html>
