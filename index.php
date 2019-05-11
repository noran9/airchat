<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/redmond/jquery-ui.css">

<?php
session_start ();
function loginForm() {
    echo '
   <div id="loginform" class="jumbotron container">
   <div class="text-center">
		<img src="AirChat.png" class="img-fluid text-center" id="logo">
	</div><br>
   <form action="index.php" method="post">
       <p>Please enter your orign and destination to continue:</p>
       <label for="origin">Your origin:</label><br>
       <input class="form-control" type="text" name="origin" id="origin" /><br>
       <label for="name">Your destination:</label>
       <input class="form-control" type="text" name="name" id="name" /><br>
       <input type="submit" class="btn btn-dark" name="enter" id="enter" value="Enter" />
   </form>
   </div>
   ';
}
 
if (isset ( $_POST ['enter'] )) {
?>
	<script type="text/javascript">
		var m;
    	$.ajax({
	    	url: "https://kiwicom-prod.apigee.net/locations/query?term=<?php echo $_POST['origin']; ?>&locale=en-US&location_types=airport&limit=10&active_only=true",
	    	async: false,
	        contentType: "application/json",
	        dataType: 'json',
	        success: function(result){
	        	console.log(result['locations'][0]['id']);
	        	localStorage.setItem('origin_ID', result['locations'][0]['id']);
	        }
		}),
    	$.ajax({
	    	url: "https://kiwicom-prod.apigee.net/locations/query?term=<?php echo $_POST['name']; ?>&locale=en-US&location_types=airport&limit=10&active_only=true",
	    	async: false,
	        contentType: "application/json",
	        dataType: 'json',
	        success: function(result){
	            console.log(result['locations'][0]['id']);
	            localStorage.setItem('destination_ID', result['locations'][0]['id']);
	        }
		});
    	window.location.href = 'index.php?origin='+localStorage.getItem('origin_ID')+'&dest='+localStorage.getItem('destination_ID');
	</script>
	
	<?php 
	
    if ($_POST ['name'] != "") {
        $_SESSION ['name'] = stripslashes ( htmlspecialchars ( $_POST ['name'] ) );
        $_SESSION ['origin'] = stripslashes ( htmlspecialchars ( $_POST ['origin'] ) );
        $fp = fopen ( "log.html", 'a' );
        fwrite ( $fp, "<div class='msgln'><i>User from " . $_SESSION ['origin'] . " has joined the chat session.</i><br></div>" );
        fclose ( $fp );
    } else {
        echo '<span class="error">Please type in a destination</span>';
    }
}
 
if (isset ( $_GET ['logout'] )) {
   
    // Simple exit message
    $fp = fopen ( "log.html", 'a' );
    fwrite ( $fp, "<div class='msgln'><i>User from " . $_SESSION ['origin'] . " has left the chat session.</i><br></div>" );
    fclose ( $fp );
   
    session_destroy ();
    header ( "Location: index.php" ); // Redirect the user
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cosmo/bootstrap.css">
<link rel="stylesheet" type="text/css" href="style.css">
<head>
<style>

 
#chatbox {
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    background: #fff;
    height: 270px;
    width: inherit;
    border: 1px solid #ACD8F0;
    overflow: auto;
}
 
</style>
<title>Chat - Customer Module</title>
</head>
<body>
    <?php
    if (! isset ( $_SESSION ['name'] )) {
        loginForm ();
    } else {
        ?>
<div id="wrapper" class="jumbotron container-fluid">
	<div class="text-center">
		<img src="AirChat.png" class="img-fluid text-center" id="logo">
	</div><br><br>
		<h2 class="text-center">Welcome to the airport chat!</h2><br>
        <div id="menu" class="row">
            <p class="welcome lead col-10">
                Your destination is: <b><?php echo $_SESSION['name']; ?></b>
            </p>
            <p class="logout col-2">
                <a class="btn btn-danger" id="exit" href="#">Exit Chat</a>
            </p>
        </div>
        <div id="chatbox"><?php
        if (file_exists ( "log.html" ) && filesize ( "log.html" ) > 0) {
            $handle = fopen ( "log.html", "r" );
            $contents = fread ( $handle, filesize ( "log.html" ) );
            fclose ( $handle );
           
            echo $contents;
        }
        ?></div>
 
        <form name="message" action="">
        	<div class="container">
        	<div class="row">
        		<div class="col-8 m-3">
        			<label>Enter message:</label>
            		<input class="form-control" name="usermsg" type="text" id="usermsg" size="63" /><br>
        		</div>
            <input name="submitmsg" class="btn btn-dark text-center col-2 m-4" type="submit" id="submitmsg" value="Send" />
            </div>
        </div>
        </form><br><br>

        <div class="container">
	        <div class="row">
	        	<div class="col-sm m-2 btn btn-dark">
	        		<h3 class="m-5 text-center rounded-circle"><a href="create.php">Create your journey from <?php echo $_SESSION ['origin']; ?></a></h1>
	        	</div>
	        	<div class="col-sm m-2 bg-primary btn btn-primary">
	        		<h3 class="m-5 text-center rounded"><a class="text-dark" href="all.php">Look at journeys from <?php echo $_SESSION ['name']; ?></a></h1>
	        	</div>
	        </div>
    	</div>
    </div>

<script type="text/javascript">
//jQuery Document
$(document).ready(function(){
    //If user wants to end session

    $("#exit").click(function(){
        var exit = confirm("Are you sure you want to end the session?");
        if(exit==true){window.location = 'index.php?logout=true';}     
    });
});
 
//If user submits the form
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("post.php?origin=<?php echo $_GET['origin'];?>&dest=<?php echo $_GET['dest'];?>", {text: clientmsg});
        $("#usermsg").attr("value", "");
        loadLog;
    return false;
});
 
function loadLog(){    
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "log.html",
        cache: false,
        success: function(html){       
            $("#chatbox").html(html); //Insert chat log into the #chatbox div  
           
            //Auto-scroll          
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }              
        },
    });
}
 
setInterval (loadLog, 2500);
</script>

<?php
}
?>
</body>
</html>