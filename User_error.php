<?php
session_start();
echo "User doesn't exist :(";
session_destroy();
?>



<html>

<body>

<br/>

<button  type="button" onclick="window.location.href = 'index.php'">  Return to home </button>

</body>


</html>