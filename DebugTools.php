<?php
//$con = NEW MySQLi('localhost', 'id12635463_dev', 'fort4572', 'id12635463_mega');
$con = NEW MySQLi('localhost', 'root', '', 'megatowel');
if (isset($_POST['test'])){
	$test = $_POST['test'];

	$con->query("SELECT * FROM message LIMIT 1");
	
    $con->query("UPDATE message SET msg = $test LIMIT 1");
    echo $test;

}

?>


<html>
<head>
    <h1>Debug tools</h1>
</head>

<body>
    <form method="POST" action="DebugTools.php">
    <table>
	 <tr>
        <td>  Broadcast notification </td>
        <td> <input type="TEXT" name ="test" required/></td>


   </tr>
	
  

   <tr>
        <td>   </td>
        <td> <input type="SUBMIT" name ="submit" value = "Send" required/> </td>


   </tr>
        
    </table>
    </form> 
	</body>
	</html>