<!DOCTYPE html>

<html>  

<head>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
</head>
<?php 
session_start();
	$uid = $_SESSION['uid'];
	//$title = $_SESSION['title'];
	$style = "";
	if(isset($_SESSION['alumn'])){
		$style = "style='display:none;'";
	} 
?>
<body> 
	</script> 
	<nav class="navbar navbar-ex pand-lg navbar-light bg-light">
		<a class="navbar-brand" index="test" href="./student_home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<!-- Grad Tabs -->
				<li class="nav-item">
				  <a class="nav-link grad" id= "test" href="./apply_for_grad.php" <?php echo $style;?>>Apply For Graduation</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link grad" id= "test" href="./view_transcript.php">View Transcript</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link button" id= "Edit Info" href="./edit_user_info.php" onclick=''>Edit Info</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id= "Logout" href="#" onclick="return logout()">Logout</a>
				</li>
				<script>
				function logout () {
					$.ajax({
						url: "./logout.php",
						type: "POST",
						data: {uid: '<?php echo $uid; ?>', type: "disapprove"},
						success: function(data){
							event.preventDefault();
							location.href = "./login.html";
						}
					});
				}
			</script>
			</ul>
		  </div>
	  </nav>
	  

	  <?php
		  echo "<h1 class='display-1'> Welcome</h1>";
		  echo "<h1 class='display-3'> Look at the Navbar to View your transcript,  edit your personal info, or apply for graduation! </h1>";
	  ?>
</body>

</html>