	<!DOCTYPE html>
<html lang="en">
<?php session_start(); 
if (isset( $_POST['userlocationinput'] ))
	$_SESSION['user_location']=$_POST['userlocationinput']; 
?>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>CSE716 - Group 8 - Project 4</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
	
	<style>
		#sites-div-main , #queries-div-main , #one_entry_div_id , #one_entry_queries_div_id{
			display: none;
		}
		body {
			background-color: white;
			color:black;
		}
		
		<!--
		/*
		@media screen and (prefers-color-scheme: dark) {
		body {
			background-color: black;
			color: white;
		}
		}
		*/
		-->
		/* width */
		::-webkit-scrollbar {
		  width: 5px;
		}

		/* Track */
		::-webkit-scrollbar-track {
		  box-shadow: inset 0 0 5px grey; 
		  border-radius: 10px;
		}
		 
		/* Handle */
		::-webkit-scrollbar-thumb {
		  background: grey; 
		  border-radius: 10px;
		}

		/* Handle on hover */
		::-webkit-scrollbar-thumb:hover {
		  background: #b30000; 
		  width: 10px;
		}
	</style>


</head>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="project4.js"></script>
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<script type="text/javascript" src="dataloader/loadSites.js"></script>
<script type="text/javascript" src="dataloader/loadSites-html.js"></script>
<script type="text/javascript" src="dataloader/loadQueries-html.js"></script>
<script type="text/javascript" src="dataloader/loadAllSites-html.js"></script>

<script>
	$(document).ready(function() {
		$("#loadBtn").click(function() {

			 setTimeout(function () {
				 $("#content").text("Please wait while loading...");
			 }, 2);
			
			$("#content").load('content.txt');
		});
	});

</script>
<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="./" class="w3-bar-item w3-button w3-padding-large">Project4</a>
	<a href="#" class="w3-bar-item w3-button w3-padding-large">Administrative Tasks</a>
    <a href="#usersection" class="w3-bar-item w3-button w3-padding-large w3-hide-small">User Section</a>
	<form action="" method="post"><button type="submit" name="reset"  class="w3-bar-item w3-button w3-padding-large w3-hover-red w3-hide-small w3-right"> HARD RESET</button></form>
  </div>
</div>
<!-- Navbar on small screens (remove the onclick attribute if you want the navbar to always show on top of the content when clicking on the links) -->
<div id="nav" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <a href="#usersection" class="w3-bar-item w3-button w3-padding-large" onclick="myFunction()">User Section</a>
</div>
<?php
		include "db_operations.php";
?>
<!-- Page content -->
<div class="w3-content" style="max-width:2000px;margin-top:46px">
	<?php	if(isset($_POST["reset"])){ ?>
	<div class="container">
	<?php		hard_reset($mysqli); ?>
	</div>
	<?php	} ?>
  <div class="container" id="administrative" style="min-height:90vh">
	<div class="container">
		<div class="well well-lg">Site Information</div>
			<form class="form-inline">
				<div class="form-group">
					<label for="email">Number of Sites:</label>
					<input type="number" class="form-control" id="number_of_sites_id">
				</div>
				<button type="button" class="btn btn-default" onclick="sitePopulateClick()">Submit</button>
			</form>
		</div>
		<br/><br/>

						<div id="one_entry_div_id">
							<div class="form-group">
								<label for="email">Site name:</label>
								<input type="text" class="form-control" name="sites[]" required id="email">
							</div>
							<div class="form-group">
								<label for="pwd">Location (km):</label>
								<input type="number" fclass="form-control" name="locations[]" required id="pwd">
							</div>
							<br/>
						</div>


		<form action="" method="post">
			<div class="container" id="sites-div-main">
				<div class="well well-sm">Please enter new site information:</div>
				<div class="form-inline">
					<div id="sites_div_id">
						
						
					</div>
				</div>
				<br/>
				<button type="submit" name="submitsites" class="btn btn-info">Submit Sites</button>
			</div>
		</form>
		<br/><br/>
	
		<!-- Table view -->
		<div>
			<button type="submit" id="viewSitesButton" >View Sites</button> <button type="submit" id="viewAllSitesButton" >View All Sites Data</button> 
			<table id="SitesTable" cellspacing="0" cellpadding="0" style="max-width:300px;">
			</table>
			<div id="displayViewSites"></div>
			
			<table id="AllSitesTable" cellspacing="0" cellpadding="0" style="max-width:300px;">
			</table>
			<div id="displayViewAllSites"></div>
		</div>
	
	
		<div class="container">
			<div class="well well-lg">Query Information</div>
				<form class="form-inline">
					<div class="form-group">
						<label for="pwd">Number of Queries:</label>
						<input type="number" class="form-control" id="number_of_queries_id">
					</div> 
					<button type="button" class="btn btn-default" onclick="queryPopulateClick()">Submit</button>
				</form>
			</div>
							<div id="one_entry_queries_div_id">
							<div class="form-group">
								<label for="email">Query :</label>
								<input type="text" class="form-control" name="queries[]" required id="email">
							</div> 
							<br>
							</div>
			<form action="" method="post">
				<div class="container" id="queries-div-main">
					<div class="well well-sm">Global generic query:</div>
					<div class="form-inline">
						<div id="queries_div_id">
							
						</div>
					</div>

					<br/>
					<button type="submit" name="submitqueries" class="btn btn-info">Submit Queries</button>
				</div> 
				
			</form>
			<!-- Table view -->
		
			<div>
				<br/>
				<button type="submit" id="viewQueriesButton" >View Global Queries</button>
				<table id="QueriesTable" cellspacing="0" cellpadding="0" style="max-width:600px;">
				</table>
				<div id="displayViewQueries"></div>
			</div>
			<div class="container">
			<div class="well well-lg">User location</div>
			<form action="" method="post" class="form-inline">
				<div class="form-group">
					<label for="pwd">User location:</label>
					<input type="number" class="form-control" name="userlocationinput" id="userlocationinput">
				</div> 
				<input id="setsessionbutton" type="submit" value="Set">
			</form>
			<br/> Current Location: <?php if( isset( $_SESSION['user_location'] ) ) { echo $_SESSION['user_location']; } ?>
			<br/> Nearest site: <?php if(isset($_SESSION['user_location'])) echo nearestSite($_SESSION['user_location'],$mysqli); else echo "-"; ?>
		</div>
	</div>
		
		
		
		
	</div>

	<br><br>

		
		

		<div class="container" id="usersection" style="min-height:90vh">

		
			<div class="well well-lg">User Section</div>
			<br/> Current Location: <?php if( isset( $_SESSION['user_location'] ) ) { echo $_SESSION['user_location']; } ?>
			<br/> Nearest site: <?php if(isset($_SESSION['user_location'])) echo nearestSite($_SESSION['user_location'],$mysqli); else echo ""; ?>
			
				<div class="form-group">
					<label for="email">Available queries:</label>
					<br/>
					<?php // get queries 
						$queries=loadQueriesArray($mysqli);
						if (!empty($queries)) { 
							$i=0; 
							foreach ($queries as $row){ ?>
								
								<form class="form-inline" id="queryform" name="queryform" method="post" action="./#usersection">
									<input type="hidden" name="querysubmit" value="<?php echo $row["query"]; ?>">
									<input type="submit" name="querysubmitbutton" class="btn btn-default" value="<?php echo $row["query"]; ?>">
								</form>
								
					<?php	}
							echo "</br>";
						}else {
							echo "None</br>";
						}
						
						if(isset($_POST["querysubmit"])){
							$queries=loadUserQuery($_POST["querysubmit"],$mysqli);//print_r($queries);
							if (!empty($queries)) { 
								$i=0; ?>
								<table style="max-width:300px;">
								<tr><th>Data</th><th>Score</th></tr>
								
						<?php	foreach ($queries as $row){ ?>
										<tr><td><?php echo $row["data"]; ?></td><td><?php echo $row["score"]; ?></td></tr>
						<?php	} ?></table></br><?php
							}
						}
					?>
					
				</div> 
			
			<form class="form-inline" method="post" action="./#usersection">
				<div class="form-group">
					<label for="email">Insert Data</label>
					<br/>
					<label>Data: </label><input type="text" class="form-control" name="userdatainput" required id="userdatainput"> 
					<label>Score: </label><input type="number" class="form-control" name="userscoreinput" required id="userscoreinput"> 
					<input id="userinsertbutton" type="submit" value="Insert">
					<br/>
					<?php
						if(isset($_POST["userdatainput"]) and isset($_POST["userscoreinput"])){
							insertUserData($_POST["userdatainput"],$_POST["userscoreinput"],$mysqli);
							echo "Data inserted at site : " . nearestSite($_SESSION['user_location'],$mysqli);
						} else{
							//echo "Insufficient information to perform INSERT operation";
						}
					?>
				</div> 
			</form>
			
		</div>
<!-- End Page Content -->
</div>
</body>
</html>



 
