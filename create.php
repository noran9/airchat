<?php 
	include_once('db.php');
	if(isset($_POST["submit"])){
		$conn = db();
		$description = mysqli_real_escape_string($conn, $_POST['description']);
		$path1 = 'images/'.$_FILES["image"]["name"];
		move_uploaded_file($_FILES["image"]["tmp_name"], $path1);

		$query = "INSERT INTO journey (description, photo1) VALUES ('$description', '$path1')";
		$conn -> query($query);

		
	}
?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cosmo/bootstrap.css">
<div id="wrapper" class="jumbotron container-fluid">
	<div class="text-center">
		<img src="AirChat.png" class="img-fluid text-center" id="logo">
	</div><br><br>
        <h1 class="text-center">Create new Journey</h1><br>
        <form action="create.php" method="POST" enctype="multipart/form-data">
        	<label>Add Image</label>
        	<input type="file" name="image" value="Add Image" class="form-control btn btn-primary"><br><br>
        	<label>Description: </label>
        	<textarea class="form-control" name="description"></textarea><br>
        	<input class="btn btn-dark" type="submit" name="submit" value="Create">
        </form>
