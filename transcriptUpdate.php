<!DOCtype html>
<html>
<head>  
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel = "stylesheet" href="/css/heroic-features.css" >
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Update Transcript</title>
</head>
<body data-gr-c-s-loaded = "true">
<?php
session_start();
require_once ('connectvars.php');

if (!isset($_SESSION['uid']))
{
?>
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


	<?php
}
else
{
    $uidFac = $_SESSION['uid'];
    $uid = $_POST['uid'];
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $query = "select type from staff where uid = '$uidFac'";

    $data = mysqli_query($dbc, $query);

    if (mysqli_num_rows($data) == 1)
    {
        $row = mysqli_fetch_array($data);
    }
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
    if ($row['type'] == 1)
    {
?>
<!-- HEADER -->
<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Update Transcript Information</h1>
				<p class = "lead mb-5 text-center text-white-50" id = button>
					Currently updating the transcript status of student uid: <?php echo $uid; ?>.
				</p>
			</div>
		</div>
    </div>
</header>
<div class = "container">
	<div class = "row">
	<?php
        if (isset($_POST['transcript']))
        {
            $transcript = $_POST['transcript'];
			$uid = $_POST['uid'];
			
			$queryUpdate = "UPDATE applicant SET transcript = '$transcript' WHERE uid = '$uid'";
			$dbc->query($queryUpdate);

			$checkRecsQuery = "Select * from recs where uid = ".$updateRow['uid'];
			$checkRecsData = mysqli_query($dbc, $checkRecsQuery);
			$numRecs = mysqli_num_rows($checkRecsData);
			if ($numRecs >= 1) {
				$checkRecsQuery = "SELECT * from recs where recName is not null and uid = ".$updateRow['uid'];
				$checkRecsData = mysqli_query($dbc, $checkRecsQuery);
				if (mysqli_num_rows($checkRecsData) >= $numRecs) {
					mysqli_query($dbc, "UPDATE applicant SET appStatus = 2 WHERE uid = ".$updateRow['uid']);
				}
			}
        }
        $query = "select transcript from applicant where uid = '$uid'";

        $data = mysqli_query($dbc, $query);

        $row = mysqli_fetch_array($data);

        if ($row['transcript'] == 1)
        {
            echo '<p>This student\'s transcript has already been uploaded.</p></div><br/>';
        }
        else
        {
	?>
				<form method = "post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class = "FormF">
				<div class="form-group">
					
						Has the student submitted a transcript yet? : <br/> <br/>
						<input type="radio" id="yes" name="transcript" value="1">
						<label for="yes">Yes</label><br>
						<input type="radio" id="no" name="transcript" value="0">
						<label for="no">No</label><br>
						<input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>"> <br>
						<input type="submit" value="Submit" name="submit" class="btn text-white btn-lg" style="background-color: #033b59;">
				</div>
				</form>
				</div>
			<?php
        }

	?>
	<div class = "row">
	<p>
			<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "queue.php">Go Back</a>
	</p>	
	</div>
	</div>
	
	<?php
    }
    else
    { ?>
			<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
					<div class = "container h-100">
						<div class = "row h-100 align-items-center">
							<div class = "col-lg-12">
								<h1 class = "display-4 text-center text-white mt-5 mb-2">ERR: Incorrect access level</h1>
								<p class = "lead mb-5 text-center text-white-50" id = button> Want to go back to the home page?
								</p>
								<p class = "lead" > <em><center></em></p>
								<a class = "btn btn-light btn-lg" href = "index.php">Click Here!</a>
							</div>
						</div>
					</div>
				</header>

	<?php
    }
} ?>

</body>
</html>
