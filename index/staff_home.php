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
	$title = $_SESSION['type'];


?>
<body> 
	<script> 
		window.onload = function() {
            var uType = '<?php echo $title;?>';
			if (uType === 0){	
			    $('.adm').hide();
			} else {
                $('.gs').hide();
            }

		}; 
	</script> 
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" index="test" href="./staff_home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav mr-auto">
			  <!-- Admin tabs -->
			<li class="nav-item">
			  <a class="nav-link adm" id= "test" href="./create_account.php">Create New Account</a>
			</li>
			<li class="nav-item">
				<a class="nav-link adm" id= "test" href="./all_accounts.php">View All Accounts</a>
			  </li>
            <!-- GS -->
            <li class="nav-item">
            	<a class="nav-link gs" id= "test" href="./view_all_students.php">View All Students</a>
            </li>


			<li class="nav-item">
				  <a class="nav-link button" id= "Edit Info" href="./edit_user_info.php" onclick=''>Edit Info</a>
				</li>
			<li class="nav-item">
				<a class="nav-link" id= "Logout" href="#"onclick="return logout()">Logout</a>
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
	  <form method="post">
	  <?php
	  		
			if($title == 0){
				echo "
						<button type='submit' class='btn btn-primary btn-md float-left f1' id='reset' name='reset' style='margin-left:20px; margin-top:20px'>Reset Data</button>
						";
				echo "<br><br><br>";
				
				if(isset($_POST['reset'])){
					require_once("connectvars.php");
					$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

					$host = DB_HOST;
					$username = DB_USER;
					$pass = DB_PASSWORD;
					$name = DB_NAME;
					
					shell_exec("mysql --user=$username --password=$pass -h $host -D $name < ../Deliverables/sql.sql");
					
				}
			}
			?>
	  </form>

	  <?php
		  echo "<h1 class='display-1'> Welcome</h1>";
		  echo "<h1 class='display-3'> Look at the Navbar to View Students, or edit your personal info! </h1>";
	  ?>

	  
</body>

</html>