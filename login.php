<!DOCTYPE html>
<html>
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">
<title> Login </title>
</head>

<?php
	session_start();
	require_once('connectvars.php');

	//clear error message
	$error_msg = "";

	if (!(isset($_SESSION['uid']))) {
		if (isset($_POST['submit'])) {
			$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

			// Grab the user-entered log-in data
			$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
			$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

			if (!empty($user_username) && !empty($user_password)) {
                
				$query = "select username, uid from person where username = '$user_username' and password = '$user_password'";
						
				$data = mysqli_query($dbc, $query);
		
				// If The log-in is OK 
				if (mysqli_num_rows($data) == 1) {
							
				  $row = mysqli_fetch_array($data);
				  
				  $_SESSION['uid'] = $row['uid'];
				  
				  $home_url = "index.php";
				  
				  header('Location: ' . $home_url);
				}
				else {
				  // The username/password are incorrect so set an error message
				  $query = "select username from person where username = '$user_username'";
						
				  $data = mysqli_query($dbc, $query);

				  if ((mysqli_num_rows($data) == 0)) {
					$error_msg = 'Username does not exist.';
				  }
				  else {
					$error_msg = 'Password incorrect.';
				  }
				}
			}
			else {
				$error_msg = 'Missing username or password';
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
					<a class = "nav-link" href = "createAcc.php">Create an Account</a>
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
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Login</h1>
				<p class = "lead mb-5 text-center text-white-50" id = button> Please enter your username and password</p>
				
			</div>
		</div>
    </div>
</header>
    <form method = "post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class = "FormF">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" name = "username" placeholder="Enter your username" value="<?php if (!empty($user_username))echo $user_username; ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name = "password" placeholder="Enter your password">
		</div>
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
			<p> Don't have an account yet? <a href = "createAcc.php">Create an Account</a>	
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