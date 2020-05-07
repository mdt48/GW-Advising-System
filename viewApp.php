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
	<h1>General Information</h1> <br>
    <dl class="row">
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
            $queryE = 'select * from examScore where uid = '.$uid.' and examSubject != "total" and examSubject != "verbal" and examSubject != "quantitative" order by examSubject asc';				
			$dataE = mysqli_query($dbc, $queryE);    
			
            //info from recs
            $queryR = "select email from recs where uid = '$uid'";				
			$dataR = mysqli_query($dbc, $queryR);  
			?> 
			<dt class="col-sm-3">First Name</dt>
			<dd class="col-sm-9"><?php echo $rowU['fname']; ?></dd>

			<dt class="col-sm-3">Last Name</dt>
			<dd class="col-sm-9"><?php echo $rowU['lname']; ?></dd>

			<dt class="col-sm-3">Email Address</dt>
			<dd class="col-sm-9"><?php echo $rowU['email']; ?></dd>
			
			<dt class="col-sm-3">Username</dt>
			<dd class="col-sm-9"><?php echo $rowU['username']; ?></dd>
			
			<dt class="col-sm-3">Birthday</dt>
			<dd class="col-sm-9"><?php echo $rowU['birthDate']; ?></dd>
			
			<dt class="col-sm-3">User ID</dt>
			<dd class="col-sm-9"><?php echo $rowU['uid']; ?></dd>
			
			<dt class="col-sm-3">Address</dt>
        	<dd class="col-sm-9"><?php echo $rowU['address']; ?></dd>
			</dl>
			<h1>Application</h1> <br/>
			<dl class="row">
			<dt class="col-sm-3">Degree Program</dt>
			<dd class="col-sm-9"><?php if ($rowA['degProgram'] == "md") {
					echo 'MD<br/>';
				}
				else {
					echo 'PHD<br/>';
				} ?></dd>

			<dt class="col-sm-3">Admission Semester/Year</dt>
			<dd class="col-sm-9"><?php echo $rowA['admissionSemester']." ".$rowA['admissionYear']; ?></dd>

			<dt class="col-sm-3">Areas of Interest</dt>
			<dd class="col-sm-9"><?php echo $rowA['aoi']; ?></dd>
			
			<dt class="col-sm-3">Transcript Link</dt>
			<dd class="col-sm-9"><?php echo $rowA['transcript']; ?></dd>

			<?php 
            	if (!($rowA['appExp'] == NULL)) {
			?>
				<dt class="col-sm-3">Experience</dt>
				<dd class="col-sm-9"><?php echo $rowA['appExp']; ?></dd>
			<?php }
			
			$degCount = 1;

			while ($rowD = mysqli_fetch_array($dataD)) {
				?>

				<dt class="col-sm-3">Degree <?php echo $degCount; ?></dt>
				<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-4">Type of Degree</dt>
					<dd class="col-sm-8"><?php echo $rowD['degType']; ?></dd>

					<dt class="col-sm-4">Issuing University</dt>
					<dd class="col-sm-8"><?php echo $rowD['school']; ?></dd>

					<dt class="col-sm-4">GPA</dt>
					<dd class="col-sm-8"><?php echo $rowD['gpa']; ?></dd>

					<dt class="col-sm-4">Field of Study</dt>
					<dd class="col-sm-8"><?php echo $rowD['major']; ?></dd>

					<dt class="col-sm-4">Year Graduating</dt>
					<dd class="col-sm-8"><?php echo $rowD['yearGrad']; ?></dd>

				</dl>
			</dd>
				<?php				
				$degCount++;
			}
			
            $queryEQ = 'select * from examScore where uid = '.$uid.' and examSubject = "quantitative"';				
			$dataEQ = mysqli_query($dbc, $queryEQ); 
			if ($rowEQ = mysqli_fetch_array($dataEQ)) { //if there is a GRE			
				$queryEV = 'select * from examScore where uid = '.$uid.' and examSubject = "verbal"';				
				$dataEV = mysqli_query($dbc, $queryEV);
				$rowEV = mysqli_fetch_array($dataEV);
				$queryET = 'select * from examScore where uid = '.$uid.' and examSubject = "total"';				
				$dataET = mysqli_query($dbc, $queryET);
				$rowET = mysqli_fetch_array($dataET);?>
				
				<dt class="col-sm-3">GRE</dt>
				<dd class="col-sm-9">
				<dl class="row">
						<dt class="col-sm-4">Verbal</dt>
						<dd class="col-sm-8"><?php echo $rowEV['score']; ?></dd>

						<dt class="col-sm-4">Quantitative</dt>
						<dd class="col-sm-8"><?php echo $rowEQ ['score']; ?></dd>
						
						<dt class="col-sm-4">Total</dt>
						<dd class="col-sm-8"><?php echo $rowET['score']; ?></dd>

						<dt class="col-sm-4">Year Taken</dt>
						<dd class="col-sm-8"><?php echo $rowET['yearTake']; ?></dd>
					</dl>

				</dd>

				<?php
			}
			
			$examCount = 1;

			while ($rowE = mysqli_fetch_array($dataE)) { 
				?>
				<dt class="col-sm-3">Exam <?php echo $examCount; ?></dt>
				<dd class="col-sm-9">

					<dl class="row">
						<dt class="col-sm-4">Subject</dt>
						<dd class="col-sm-8"><?php echo $rowE['examSubject']; ?></dd>

						<dt class="col-sm-4">Score</dt>
						<dd class="col-sm-8"><?php echo $rowE['score']; ?></dd>

						<dt class="col-sm-4">Year Taken</dt>
						<dd class="col-sm-8"><?php echo $rowE['yearTake']; ?></dd>
					</dl>

				</dd>
				<?php
				$examCount++;
			}
			if (mysqli_num_rows($dataR) >= 1) { ?>

				<dt class="col-sm-3">Reccomendations emailed to:</dt>
				 
				<dd class="col-sm-9"> 
					
    			<dl class="row">
				<?php
			}
			while ($rowR = mysqli_fetch_array($dataR)) { ?>

				
				<dd class="col-sm-8"><?php echo $rowR['email']; ?></dd>

				<?php 
			}

			?>
			</dl>
			</dd>
			<?php
		}
	?>
	</div>
	<div class = "row"><p>
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