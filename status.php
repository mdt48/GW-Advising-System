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
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Application Status</h1>
			</div>
		</div>
    </div>
</header>
<div class = "container">
	<div class = "row">
		<p>
	<?php 
		if (isset($_POST['update'])) {
			$query = "DELETE FROM recs WHERE uid = ".$uid;
            $dbc->query($query);
            $query = "DELETE FROM degree WHERE uid = ".$uid;
			$dbc->query($query);
			$query = "DELETE FROM recReview WHERE studentuid = ".$uid;
			$dbc->query($query);
			$query = "DELETE FROM reviewForm WHERE studentuid = ".$uid;
			$dbc->query($query);
			
            $decisionQuery = "UPDATE applicant SET appStatus = 6 WHERE uid = ".$_SESSION['uid'];
            $decisionData = mysqli_query($dbc, $decisionQuery);
		}
		
		$query = "select appStatus, transcript, admissionYear from applicant where uid = '$uid'";
							
		$data = mysqli_query($dbc, $query);

		if (mysqli_num_rows($data) == 1) {

			$row = mysqli_fetch_array($data);

			$missing = 0;

			if ($row['appStatus'] == 1) {
				if ($row['transcript'] == NULL) {
					$missing += 1;
				}
				if ($row['admissionYear'] == NULL) {
					$missing += 3;
				}
				$query = "select uid from recs where uid = '$uid'";					
				$data = mysqli_query($dbc, $query);				
				$recs = mysqli_num_rows($data);				
				if ($recs != 0) {
					$query = "select count(recName) as total from recs where uid = '$uid' and recName is not null";
									
					$data = mysqli_query($dbc, $query);	
					
					$row = mysqli_fetch_array($data);
					if ($row['total'] != $recs) {
						$missing += 2;
						$row['total'] = $recs - $row['total'];
					}
				}
				if ($missing == 0) {
					$query = "update applicant set appStatus = 2 where uid = '$uid'";
									
					$data = mysqli_query($dbc, $query);	
				}
			}
			if ($missing == 1) {
				echo 'Application incomplete: Waiting for your transcript.<br/>';
			}
			else if ($missing == 2) {
				echo 'Application incomplete: Waiting for '.$row['total'].' of your recommendations.<br/>
				Please contact your references to make sure we receive their information by the deadline.<br/>';
			}
			else if ($missing == 3){
				echo 'Application incomplete: Waiting for your transcript and '.$row['total'].' of your recommendations.<br/>
				Please contact your references to make sure we receive their information by the deadline.<br/>';
			}
			else if ($row['appStatus'] == 2) {
				echo 'Application complete: We have received all your information and your application is currently under review. <br/>
				Check back in a couple of weeks to see our decision.';
			}
			else if ($row['appStatus'] == 3) {
				echo '<b>Congratulations!</b><br/><br/> Welcome to <i>The George Washington University</i>.<br/> We are pleased to have you as an incoming student. <br/><br/> As part of our decision we have decided to support your academic desires with financial aid. Details about this will come in the next few weeks.<br/>
				<br/>Go buff and blue! <br/> <br/> Want to Matriculate? Send us your tuition payment via a mailed check or press the button below.';
				echo '<br/><br/></p>';
				?>
				<form  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "accept.php">Matriculate</a>';
				<button type="submit" name="update" class="btn text-white btn-lg" style = "background-color: #033b59;">Decline</button></td>
				</form>
				<?php
			}
			else if ($row['appStatus'] == 4) {
				echo '<b>Congratulations!</b><br/><br/> Welcome to <i>The George Washington University</i>.<br/> We are pleased to have you as an incoming student. <br/><br/>Go buff and blue! <br/> <br/> Want to Matriculate? Send us your tuition payment via a mailed check or press the button below.';
				echo '<br/><br/></p>';
				?>
				<form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "accept.php">Matriculate</a>';
				<button type="submit" name="update" class="btn text-white btn-lg" style = "background-color: #033b59;">Decline</button></td>
				</form>
				<?php
			}
			else if ($row['appStatus'] == 5){
				echo 'Thank you for applying to <i>The George Washington University</i>.<br/>At this moment we are unable to receive you as a student.<br/>Please contact us if you have any questions about our decision process.';
			}
			else if ($row['appStatus'] == 6){
				echo 'Thank you for applying to <i>The George Washington University</i>.<br/>You have declined matriculation to this semester.';
			}
			else if ($row['appStatus'] == 7){
				echo 'Thank you for applying to <i>The George Washington University</i>.<br/>You have not paid matriculation by the deadline and we must rescind your admission.';
			}
			else {
				echo 'Missing more than transcript and / or recommendations. Please complete the application at your earliest convenience.';
			}
		}
	?>
	<br/><br/>
			<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
		
	</div>
</div>

	<?php } else {  ?>
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