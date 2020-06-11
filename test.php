   
<?php

   $u = $_POST['u'];
   $p = $_POST['p'];



  $con = NEW MySQLi('localhost', 'root', '', 'megatowel');
  $p = md5($p);
  $grab = $con->query("SELECT * FROM accounts WHERE username OR Tag = '$u' AND password = '$p' LIMIT 1");

  if($grab->num_rows != 0){

     
      echo "epic games";
      header('HTTP/1.1 200 Granted');

  }
  else{

     header('HTTP/1.1 403 Unauthorized');
  }


    ?>