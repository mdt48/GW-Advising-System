<!DOCtype html>
<html>
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">
<title>Home</title>
</head>
<body data-gr-c-s-loaded = "true">

<?php 
	session_start();
	require_once('connectvars.php');

	if (isset($_SESSION['gwid'])) {
?>
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
<?php 
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$gwid = $_SESSION['gwid'];

	$flag = 0;

	$query = "select gwid from faculty where gwid = '$gwid'";

	$data = mysqli_query($dbc, $query);

	$flag += mysqli_num_rows($data);

	$query = "select gwid from applicant where gwid = '$gwid'";

	$data = mysqli_query($dbc, $query);

	$flag += mysqli_num_rows($data);

	if ($flag == 0) {	
		$home_url = "application.html";
		
		header('Location: ' . $home_url);
	}

	else {

		$query = "select fname from users where gwid = '$gwid'";
							
		$data = mysqli_query($dbc, $query);

		$row = mysqli_fetch_array($data);
?>
<!-- HEADER -->
<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Welcome Back<?php if (!empty($row['fname'])) {echo ', '.$row['fname'];}?></h1>
			</div>
		</div>
    </div>
</header>
<div class = "container">
	<?php 
	
		$query = "select gwid from applicant where gwid = '$gwid'";
							
		$data = mysqli_query($dbc, $query);

		if (mysqli_num_rows($data) == 1) {	
			echo '<a href="status.php"><h1>View Application Status</h1></a><br/>';
			echo '<a href="viewApp.php"><h1>View Application Contents</h1></a><br/>';
		}
		else {
			$query = "select facultyType from faculty where gwid = '$gwid'";
							
			$data = mysqli_query($dbc, $query);

			if (mysqli_num_rows($data) == 1) {				
				$row = mysqli_fetch_array($data);
				if ($row['facultyType'] == 2) {
					echo '<a href="queue.php"><h1>Applications to review</h1></a>';
				}
				else if ($row['facultyType'] == 0) {
					echo '<a href="queue.php"><h1>Applications to review</h1></a>';
				}
				else if ($row['facultyType'] == 1) {
					echo '<a href="queue.php"><h1>Applications to review </h1></a>';
				}
				else if ($row['facultyType'] == 3) {
					echo '<a href="admin.php"><h1>Add users</h1></a>';
				}
			}

		}
	}
	?>
</div>

	<?php } else {  ?>
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
						<a class = "nav-link" href = "login.php">Login</a>
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
					<h3 class = "display-4 text-center text-white mt-5 mb-2">Error: Not logged in</h3>
					<p class = "lead mb-5 text-center text-white-50" id = button>
					Want to log in? <a href = "login.php">Log In</a> <br/>
					Don't have an account yet? <a href = "createAcc.php">Create Account</a> <br/>
					Want to go home?
					</p>
						<p class = "lead" > <em><center></em></p>
						<a class = "btn btn-light btn-lg" href = "landingPage.php">Click Here!</a>
		</div>
	</header>

	<?php }?>

</body>
</html>