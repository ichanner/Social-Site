
<?php
session_start();
error_reporting(0);
ini_set('display_errors', 0);
//$con = NEW MySQLi('localhost', 'id12635463_dev', 'fort4572', 'id12635463_mega');

include("Connection.php");

if(!isset($_SESSION['logged_in'])){
  
    

?>


<html>

<style>

 
  hr.new1 {
  border: 1px solid purple;

}
    .login {
  background-color: #bf00ff;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  position: absolute;
  top: 50px;
  right: 100px;
}


    .button {
  background-color: #bf00ff;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  position: absolute;
  top: 50px;
  right: 210px;
}
 button:hover {
  background-color: #8000ff;
}
div {
  border-radius: 5px;
  background-color:  #333333;
  padding: 20px;
}



img {
  float: left;
}
    
</style>    
  <div>
   <img src="https://megatowel.io/favicon.ico" position; top-left height = 100 width = 100 />
 

<head>

</head>
<body bgcolor=#4d4d4d>





<button  type="button" class="login"  onclick="window.location.href = 'login.php'">  Login </button>


<button  type="button" class="button"  onclick="window.location.href = 'Register.php'">  Register </button>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>


  <hr class = "new1"></hr>
</div>
</body>


</html>


<?php


}

else{

?>
<html>
 <span id="nav"></span>
  <script> $jq132 = jQuery.noConflict(true); </script>

 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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



</html>

<?php
}

?>

<?php
    include('NavBar.php');
?>