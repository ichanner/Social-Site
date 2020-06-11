

<html>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    $(document).ready(function(){

        setInterval(function() {
        		$("#div_refresh").load("NavBar.php");
        refresh();
        }, 10000);
    });
 
</script>

<body>
    <div id="div_refresh"></div>
</body>
</html>