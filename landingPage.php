<!DOCTYPE html>
<html>
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">
<title> GW Graduate Program Landing Page </title>
</head>

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
					<a class = "nav-link" href = "login.html">Login</a>
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
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Apply for the GW Graduate Program</h1>
				<p class = "lead mb-5 text-center text-white-50" id = button> Apply for the experience of a lifetime. 
				Please make sure to create a GW account before applying for the GW Graduate Program. Otherwise,
				click the button below to begin your future as a GW graduate student
				</p>
				<p class = "lead" > <em><center></em></p>
				<a class = "btn btn-light btn-lg" href = "login.html">Apply Here!</a>
			</div>
		</div>
	</div>
</header>
<em><center></em>
				<a class = "btn" href = "reset.php">Reset DB</a>

				<?php
					if (isset($_POST['uid'])) {
						require_once('connectvars.php');
						$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
					
						$uid = $_POST['uid'];

						$query = "select * from student where uid = ".$uid;
						$data = mysqli_query($dbc, $query);
						$row = mysqli_num_rows($data);
						if (mysqli_num_rows($data) == 1) {
							$query = 'insert into transcript values('.$uid.', "CSCI", 6221, "B+", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6232, "A", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6233, "A", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6241, "A-", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6242, "A", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6283, "B", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6284, "B-", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
							$query = 'insert into transcript values('.$uid.', "CSCI", 6286, "C", 2017, "phd OR masters")';
							mysqli_query($dbc, $query);
						}						
					}
					
				?>
				
				<div class="container">
					<div class="row">
						<form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
							<input class="form-control mr-sm-2" name="uid" type="uid" placeholder="UID" id= "search_bar" aria-label="Search">
							<input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search" value = "Transcript">
						</form> 
					</div>
				</div>

</body>
</html>