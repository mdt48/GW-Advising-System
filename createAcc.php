<!DOCTYPE html>
<html>
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">
<title> Create Account </title>
</head>

<?php
	session_start();
	require_once('connectvars.php');

	//clear error message
	$error_msg = $error_user = $error_password = $error_email = "";

	if (!(isset($_SESSION['uid']))) {
		if (isset($_POST['submit'])) {
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			$flag = false;

			// Grab the user-entered log-in data
			$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
			$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
			$user_email = mysqli_real_escape_string($dbc, trim($_POST['email']));

			if (!empty($user_username) && !empty($user_password) && !empty($user_email)) {
                if (!preg_match("/^[-a-zA-Z0-9 .'-'!]*$/", $user_password)) {
					$error_password = "Only letters, numbers and - . ! allowed.<br/>";
					$flag = true;
				}
				if (!preg_match("/^[-a-zA-Z0-9]*$/", $user_username)) {
					$error_user = "Only letters and numbers allowed.<br/>";
					$flag = true;
				}
				if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
					$error_email = "Email invalid.<br/>";
					$flag = true;
				}
				if (strlen($user_username) > 25) {
					$error_user = "$error_user"."Max character count: 25";
					$flag = true;
				}
				if (strlen($user_password) > 25) {
					$error_password = "$error_password"."Max character count: 25";
					$flag = true;
				}
				if (strlen($user_email) > 35) {
					$error_email = "$error_email"."Max character count: 35";
					$flag = true;
				}
				if (!$flag) {
					$query = "select username from people where username = '$user_username'";
		
					$data = mysqli_query($dbc, $query);
		
					//If The log-in is OK 
					if (mysqli_num_rows($data) == 0) {
						$queryAdd = "INSERT INTO `people` (username, password, email) values ('$user_username', '$user_password', '$user_email');";
						
						if ($dbc->query($queryAdd)) {
							$msg = "Here is your login info: \n Username: $user_username \n Password: $user_password";
						
							mail($user_email, "GW Graduate Program Login Info", $msg);
	
							$home_url = "login.html";
			
							header('Location: ' . $home_url);
						}
						else {
							$error_msg = "Oops, something went wrong";
						}

					}
					else {
						$error_user = 'Sorry, this username already exists';
					}
				}
			}
			else {
				$error_msg = 'Missing username, password or email.';
			}
		}
	}
	if (empty($_SESSION['uid'])) {
?>

<body data-gr-c-s-loaded = "true">
<!-- NAV BAR -->
<nav class = "navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class = "container">
		<a class = "navbar-brand" href = "landingPage.php">GW Graduate Program</a>
		<div class = "navbar-collapse collapse" id = "navbarNavDropdown" > 
			<ul class = "navbar-nav ml-auto">
				<li class = "nav item active">
					<a class = "nav-link" href = "landingPage.php">Home</a>
					</a>
				</li>
				 <li class = "nav item">
					<a class = "nav-link" href = "login.php">Log In</a>
				</li>
			</ul>
		</div>
	</div>
</nav>
<!-- HEADER -->
<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Create an Account</h1>
				<p class = "lead mb-5 text-center text-white-50" id = button>Please enter a username, password and email. <br/>A copy of this information will be sent to your email.</p>
				
			</div>
		</div>
    </div>
</header>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="FormF">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name="username" placeholder="Enter a username">
		</div>
		<?php 
		if (!empty($error_user)) {

			echo '
			<div class="form-group">
			<p>'.$error_user.'
			</div>';
		}		
		?>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
		</div>
		<?php 
		if (!empty($error_password)) {

			echo '
			<div class="form-group">
			<p>'.$error_password.'
			</div>';
		}		
		?>
		<div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
		</div>
		<?php 
		if (!empty($error_email)) {

			echo '
			<div class="form-group">
			<p>'.$error_email.'
			</div>';
		}		
		?>
		<?php 
		if (!empty($error_msg)) {

			echo '
			<div class="form-group">
			<p>'.$error_msg.'
			</div>';
		}		
		?>
		
		<input type="submit" value="Submit" name="submit" class="btn text-white btn-lg" style="background-color: #033b59;">
	  	</form>
	<div class = "container"> 
		<div class = "row"> 
			<p> Have an account already? <a href = "login.php">Log in!</a>	
			</p>
		</div>
	</div>
	<?php } else {?>
		<body data-gr-c-s-loaded = "true">
		<!-- NAV BAR -->
		<nav class = "navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
			<div class = "container">
				<a class = "navbar-brand" href = "landingPage.php">GW Graduate Program</a>
				<div class = "navbar-collapse collapse" id = "navbarNavDropdown" > 
					<ul class = "navbar-nav ml-auto">
						<li class = "nav item active">
							<a class = "nav-link" href = "index.php">Home</a>
							</a>
						</li>
						<li class = "nav item">
							<a class = "nav-link" href = "logout.php">Logout</a>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav> 

		<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
			<div class = "container h-100">
				<div class = "row h-100 align-items-center">
					<div class = "col-lg-12">
						<h1 class = "display-4 text-center text-white mt-5 mb-2">Logged in as <?php echo $_SESSION['username'];?></h1>
						<p class = "lead mb-5 text-center text-white-50" id = button> Want to go back to the home page?
						</p>
						<p class = "lead" > <em><center></em></p>
						<a class = "btn btn-light btn-lg" href = "index.php">Click Here!</a>
					</div>
				</div>
			</div>
		</header>

	<?php }?>

</body>
</html>