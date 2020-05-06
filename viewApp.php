<?php 
	require_once('navBar.php');

	if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<!-- HEADER -->
<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">View Application</h1>
			</div>
		</div>
    </div>
</header>
<div class = "container">
	<div class = "row">
	<?php 
		$query = "select * from applicant where uid = '$uid'";
							
		$data = mysqli_query($dbc, $query);

		if (mysqli_num_rows($data) == 1) {
            $rowA = mysqli_fetch_array($data);

            //info from people
            $queryU = "select * from people where uid = '$uid'";				
            $dataU = mysqli_query($dbc, $queryU);           
            $rowU = mysqli_fetch_array($dataU);

            //info from degrees
            $queryD = "select * from degree where uid = '$uid'";				
            $dataD = mysqli_query($dbc, $queryD);  

            //info from examScore
            $queryE = "select * from examScore where uid = '$uid'";				
			$dataE = mysqli_query($dbc, $queryE);    
			
            //info from recs
            $queryR = "select email from recs where uid = '$uid'";				
            $dataR = mysqli_query($dbc, $queryR);    

			echo 'General information <br/><br/>';

			echo 'First Name: '.$rowU['fname'].' <br/>
			Last Name: '.$rowU['lname'].'<br/>
			Username: '.$rowU['username'].'<br/>
			Birthday: '.$rowU['birthDate'].'<br/>
			User Id: '.$rowU['uid'].'<br/>
			Address: '.$rowU['address'].'<br/><br/><br/>

			Application Information <br/> <br/>
			Applying to: ';
			if ($rowA['degProgram'] == "md") {
				echo 'MD<br/>';
			}
			else {
				echo 'PHD<br/>';
			}
			echo 'Areas of Interest: '.$rowA['aoi'].'<br/>
			Experience: '.$rowA['appExp'].'<br/>
			Transcript: ';
			if ($rowA['transcript'] == 0) {
				echo 'No<br/>';
			}
			else {
				echo 'Yes<br/>';
			}
			echo 'Admission: '.$rowA['admissionSemester'].' '.$rowA['admissionYear'].'<br/><br/><br/>';
			echo 'Previous Degrees <br/><br/>';

			while ($rowD = mysqli_fetch_array($dataD)) {
				echo 'Degree Type: '.$rowD['degType'].'<br/>
				School: '.$rowD['school'].'<br/>
				GPA: '.$rowD['gpa'].'<br/>
				Major: '.$rowD['major'].'<br/>
				Year of Graduation: '.$rowD['yearGrad'].'<br/>
				';
			}
			echo '<br/>';
			echo 'Exam Scores <br/><br/>';

			while ($rowE = mysqli_fetch_array($dataE)) {
				echo 'Subject: '.$rowE['examSubject'].'<br/>
				Score: '.$rowE['score'].'<br/>
				Year Taken: '.$rowE['yearTake'].'<br/><br/>
				';
			}
			echo '<br/>';
			echo 'Recommendations emailed to:<br/><br/>';
			while ($rowR = mysqli_fetch_array($dataR)) {
				echo $rowR['email'].'<br/>';
			}

			echo '
            </div>
			<div class = "row"><p>';
		}
	?>
	<br/><br/>
			<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
		</p>
	</div>
	<br/>
</div>

	<?php } else {  ?>
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