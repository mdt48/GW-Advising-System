<?php 
require_once('navBar.php');

if (isset($_SESSION['uid'])) {
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

	$uid = $_SESSION['uid'];

	$flag = 0;

	$query = "select uid from staff where uid = '$uid'";

	$data = mysqli_query($dbc, $query);

	$flag += mysqli_num_rows($data);

	$query = "select uid from applicant where uid = '$uid'";

	$data = mysqli_query($dbc, $query);

	$flag += mysqli_num_rows($data);

	$query = "select uid from student where uid = '$uid'";

	$data = mysqli_query($dbc, $query);

	$flag += mysqli_num_rows($data);

	if ($flag == 0) {	
		$home_url = "application.html";
		
		header('Location: ' . $home_url);
	}

	else {

		$query = "select fname from people where uid = '$uid'";
							
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
	
		$queryA = "select uid from applicant where uid = '$uid' and uid not in (select uid from student)";
							
		$dataA = mysqli_query($dbc, $queryA);
		
		$queryS = "select uid from staff where uid = '$uid'";
							
		$dataS = mysqli_query($dbc, $queryS);
		
		$checkQ = "select * from reviewForm where studentuid = '$uid'";		
		$checkD = mysqli_query($dbc, $checkQ);

		if (mysqli_num_rows($dataA) == 1) {	
			echo '<a href="status.php"><h1>View Application Status</h1></a><br/>';
			echo '<a href="viewApp.php"><h1>View Application Contents</h1></a><br/>';
			if (mysqli_num_rows($checkD) == 0) {
				echo '<a href="editAcademic.php"><h1>Edit Academic Contents</h1></a><br/>';
			}
			echo '<a href="edit_user_info.php"><h1>Edit User Info</h1></a><br/>';
		}
		else if (mysqli_num_rows($dataS) == 1){
			$query = "select type from staff where uid = '$uid'";
							
			$data = mysqli_query($dbc, $query);
			if (mysqli_num_rows($data) == 1) {				
				$row = mysqli_fetch_array($data);
				//admin
				if ($row['type'] == 0) {
					echo '<a href="admin.php"><h1>Add Users</h1></a><br/>';
					echo '<a href="queue.php"><h1>Applications</h1></a><br/>';
					echo '<a href="queueMatriculate.php"><h1>Students to Matriculate</h1></a><br/>';
					echo '<a href="stats.php"><h1>Report</h1></a><br/>';
					//echo '<a href="view_all_accounts.php"><h1>View all Accounts</h1></a><br/>';
					echo '<a href="grades.php"><h1>View Grades</h1></a><br/>';
					echo '<a href="view-student-transcripts.php"><h1>View Transcripts</h1></a><br/>';
					echo '<a href="view-classes.php"><h1>View Classes</h1></a><br/>';
				}
				//gs
				else if ($row['type'] == 1) {
					echo '<a href="queue.php"><h1>Applications</h1></a><br/>';
					echo '<a href="queueMatriculate.php"><h1>Students to Matriculate</h1></a><br/>';
					echo '<a href="stats.php"><h1>Report</h1></a><br/>';
					echo '<a href="view-student-transcripts.php"><h1>View Transcripts</h1></a><br/>';
					echo '<a href="grades.php"><h1>View Grades</h1></a><br/>';
					echo '<a href="view-classes.php"><h1>View Classes</h1></a><br/>';	
					echo '<a href="view_all_students.php"><h1>View All Students</h1></a><br/>';				
				}
				//cac
				else if ($row['type'] == 2) {
					echo '<a href="queue.php"><h1>Applications</h1></a><br>';
				}
				//fr
				else if ($row['type'] == 3) {
					echo '<a href="queue.php"><h1>Applications</h1></a><br>';
				}
				//fa
				else if ($row['type'] == 4) {
					echo '<a href="view_all_students.php"><h1>View All Students</h1></a><br/>';
				}
				//fi
				else if ($row['type'] == 5) {
					echo '<a href="grades.php"><h1>View Grades</h1></a><br/>';
					echo '<a href="view-student-transcripts.php"><h1>View Student Transcripts</h1></a><br/>';
				}
				//fr&a
				else if ($row['type'] == 6) {
					echo '<a href="queue.php"><h1>Applications</h1></a><br>';					
					echo '<a href="view_all_students.php"><h1>View All Students</h1></a><br/>';
				}
				//fr&i
				else if ($row['type'] == 7) {
					echo '<a href="queue.php"><h1>Applications</h1></a><br>';
					echo '<a href="grades.php"><h1>View Grades</h1></a><br/>';
					echo '<a href="view-rosters.php"><h1>View Rosters</h1></a><br/>';
					echo '<a href="view-student-transcripts.php"><h1>View Student Transcripts</h1></a><br/>';
				}
				//fi&a
				else if ($row['type'] == 8) {
					echo '<a href="view_all_students.php"><h1>View All Students</h1></a><br/>';
					echo '<a href="grades.php"><h1>View Grades</h1></a><br/>';
					echo '<a href="view-student-transcripts.php"><h1>View Student Transcripts</h1></a><br/>';
				}
				//all three
				else if ($row['type'] == 9) {
					echo '<a href="queue.php"><h1>Applications</h1></a><br>';
					echo '<a href="view_all_students.php"><h1>View All Students</h1></a><br/>';
					echo '<a href="grades.php"><h1>View Grades</h1></a><br/>';
					echo '<a href="view-student-transcripts.php"><h1>View Student Transcripts</h1></a><br/>';
				}
				
				echo '<a href="edit_user_info.php"><h1>Edit User Info</h1></a><br/>';
			}

		}
		else {
			echo '<a href="view-transcript.php"><h1>View Transcript</h1></a><br/>';
			echo '<a href="edit_user_info.php"><h1>Edit User Info</h1></a><br/>';
			echo '<a href="register.php"><h1>Register</h1></a><br/>';
			echo '<a href="view-classes.php"><h1>View Classes</h1></a><br/>';
			echo '<a href="apply_for_grad.php"><h1>Apply for Graduation</h1></a><br/>';
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
					Want to log in? <a href = "login.html">Log In</a> <br/>
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