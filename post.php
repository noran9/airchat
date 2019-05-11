
<?php
session_start();
if(isset($_SESSION['name']) && $_POST['text'] != ""){
	var_dump($_GET);
    $text = $_POST['text'];
    $button = "";
    if((strpos($_POST['text'], "Ljubljana") !== false) || (strpos($_POST['text'], "Maribor") !== false) || (strpos($_POST['text'], "Amsterdam") !== false)){

    	$button = "<br><a href='http://www.kiwi.com/deep?from=".$_GET['origin']."&to=".$_GET['dest']."' target='_blank' class = 'btn btn-primary'>Click to see flights</a>";
    	//echo 'HEHEEEE';
    }
     
    $fp = fopen("log.html", 'a');
    fwrite($fp, "<div class='msgln card-body bg-dark text-light'>(".date("g:i A").") <b>".$_SESSION['origin']."</b>: ".stripslashes(htmlspecialchars($text))."<br>".$button."</div>");
    fclose($fp);
}
?>

