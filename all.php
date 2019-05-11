<?php
			//connecting to database
			include_once('db.php');
			$db = db();

			$items = mysqli_query($db, "SELECT * FROM journey");

			if(mysqli_error($db)){
				echo mysqli_error($db);
			}

$row; ?>

<style>
.carousel{
    background: gray;
    margin-top: 20px;
    padding: 20px;
}
.carousel-item{
    text-align: center;
    min-height: 280px; /* Prevent carousel from being distorted if for some reason image doesn't load */
    max-height: 700px;
}

</style>
			<!DOCTYPE html>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
			<link rel="stylesheet" type="text/css" href="style.css">
			<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cosmo/bootstrap.css">
			<div id="wrapper" class="jumbotron container-fluid">
				<div class="text-center">
					<img src="AirChat.png" class="img-fluid text-center" id="logo">
				</div><br><br>
			</div>
	<div class="bs-example">
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Carousel indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
        </ol>
        <!-- Wrapper for carousel items -->
        <h1 class="text-center">Recent Jorneys</h1>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/bg.jpg" alt="First Slide">
                <div class="carousel-caption d-none d-md-block bg-dark">
	                <h2>Maribor</h2>
	                <p class="lead">The view in the park today!</p>
            	</div>
            </div>
            <div class="carousel-item">
                <img src="images/adv.jpg" alt="Second Slide">
                <div class="carousel-caption d-none d-md-block bg-dark">
	                <h2>Graz</h2>
	                <p class="lead">An adventure park near by!</p>
            	</div>
            </div>
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>


