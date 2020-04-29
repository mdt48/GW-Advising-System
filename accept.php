<?php 
	require_once('navBar.php');

	if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

        if (isset($_POST['hide'])) {
			$uidP = $_POST['uid'];
            $query = "DELETE FROM examScore WHERE uid = ".$uidP;
            $dbc->query($query);
            $query = "DELETE FROM recs WHERE uid = ".$uidP;
            $dbc->query($query);
            $query = "DELETE FROM degree WHERE uid = ".$uidP;
			$dbc->query($query);
			$query = "DELETE FROM recReview WHERE uid = ".$uidP;
			$dbc->query($query);
			$query = "DELETE FROM reviewForm WHERE uid = ".$uidP;
			$dbc->query($query);

			$query = "SELECT adv from applicant where uid = ".$uidP;
			$qD = mysqli_query($dbc. $query);
			$row = mysqli_fetch_array($qD);

			$query = "DELETE FROM applicant WHERE uid = ".$uidP;
			$dbc->query($query);

			$query = "INSERT INTO student (uid, advisoruid) values (".$uidP.", ".$row['adv'].")";
			$dbc->query($query);
			
		}
		else {
        
			$queryA = "select appStatus from applicant where uid = '$uid'";
								
			$dataA = mysqli_query($dbc, $queryA);

			$queryS = "select type from staff where uid = '$uid'";
								
			$dataS = mysqli_query($dbc, $queryS);

			//applicant view
			if (mysqli_num_rows($dataA) == 1) {

				$row = mysqli_fetch_array($dataA);

				if ($row['appStatus'] == 3 || $row['appStatus'] == 4) {
					?>
					<!-- HEADER -->
					<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
						<div class = "container h-100">
							<div class = "row h-100 align-items-center">
								<div class = "col-lg-12">
									<h1 class = "display-4 text-center text-white mt-5 mb-2">Matriculation</h1>
								</div>
							</div>
						</div>
					</header>
					<div class = "container">
						<div class = "row">
						<form method = "post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class = "FormF">
						<div class="form-group">
							
								Has the student submitted a transcript yet? : <br/> <br/>
								<input type="radio" id="yes" name="transcript" value="1">
								<label for="yes">Yes</label><br>
								<input type="radio" id="no" name="transcript" value="0">
								<label for="no">No</label><br>
								<input type="hidden" id="uid" name="uid" value="<?php echo $uid; ?>"> <br>
								<input type="hidden" id="hide" name="hide" value="1"> <br>
								<input type="submit" value="Submit" name="submit" class="btn text-white btn-lg" style="background-color: #033b59;">
						</div>
						</form> <p>
								<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
								</p>
						</div>
					</div>
					<?php
				}
			}
			//staff view
			else if (mysqli_num_rows($dataS) == 1) {
				
				$row = mysqli_fetch_array($dataS);
				
				if ($row['type'] == 1) {
					$uidS = $_POST['uid']; 
					?>
					<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
					<div class = "container h-100">
						<div class = "row h-100 align-items-center">
							<div class = "col-lg-12">
								<h1 class = "display-4 text-center text-white mt-5 mb-2">Matriculation</h1>
								<p class = "lead mb-5 text-center text-white-50" id = button>
									Currently matriculating student uid: <?php echo $uidS; ?>.
								</p>
							</div>
						</div>
					</div>
				</header>
				<div class = "container">
					<div class = "row">
					<?php
				}
			}
		
	?>

	<?php }} else {  ?>
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