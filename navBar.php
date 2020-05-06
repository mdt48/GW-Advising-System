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

	if (isset($_SESSION['uid'])) {
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
						<a class = "nav-link" href = "login.html">Login</a>
					</li>
					<li class = "nav item">
						<a class = "nav-link" href = "createAcc.php">Create an Account</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
<?php } ?>