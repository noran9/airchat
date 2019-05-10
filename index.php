<?php
session_start ();
function loginForm() {
    echo '
   <div id="loginform" class="jumbotron container">
   <h1>Air Chat</h1><br>
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
    fwrite ( $fp, "<div class='msgln'><i>User " . $_SESSION ['name'] . " has left the chat session.</i><br></div>" );
    fclose ( $fp );
   
    session_destroy ();
    header ( "Location: index.php" ); // Redirect the user
}
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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
<div id="wrapper" class="jumbotron container">
	<h1 class="text-center">Air Chat</h1>
        <div id="menu">
            <p class="welcome">
                Your destination is: <b><?php echo $_SESSION['name']; echo phpversion(); ?></b>
            </p>
            <p class="logout">
                <a class="btn btn-danger" id="exit" href="#">Exit Chat</a>
            </p>
            <div style="clear: both"></div>
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
            <input class="form-control" name="usermsg" type="text" id="usermsg" size="63" /><br> <input
                name="submitmsg" class="btn btn-dark form-control" type="submit" id="submitmsg" value="Send" />
        </form>
    </div>
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
// jQuery Document
$(document).ready(function(){
});
 
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
        $.post("post.php", {text: clientmsg});             
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
    <script type="text/javascript"
        src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
    <script type="text/javascript">
</script>
</body>
</html>