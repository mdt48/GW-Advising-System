<?php 
	require_once('navBar.php');

	if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

        if (isset($_POST['hide'])) {
            $query = "DELETE FROM examScore WHERE uid = ".$uid;
            $dbc->query($query);
            $query = "DELETE FROM recs WHERE uid = ".$uid;
            $dbc->query($query);
            $query = "DELETE FROM degree WHERE uid = ".$uid;
			$dbc->query($query);
			$query = "DELETE FROM recReview WHERE studentuid = ".$uid;
			$dbc->query($query);
			$query = "DELETE FROM reviewForm WHERE studentuid = ".$uid;
			$dbc->query($query);

			$query = "SELECT adv, degProgram from applicant where uid = ".$uid;
					
			$data = mysqli_query($dbc, $query);
		
			$row = mysqli_fetch_array($data);

			$query = "DELETE FROM applicant WHERE uid = ".$uid;
			$dbc->query($query);

			$query = "INSERT INTO student (uid, advisoruid, program) values (".$uid.", ".$row['adv'].", '".$row['degProgram']."')";
			$dbc->query($query);

			echo "<script>window.location.href='index.php';</script>";
		}
		else if (isset($_POST['matriculate'])) {
			$uidP = $_POST['uid'];
			
			$query = "DELETE FROM recs WHERE uid = ".$uidP;
            $dbc->query($query);
            $query = "DELETE FROM degree WHERE uid = ".$uidP;
			$dbc->query($query);
			$query = "DELETE FROM recReview WHERE studentuid = ".$uidP;
			$dbc->query($query);
			$query = "DELETE FROM reviewForm WHERE studentuid = ".$uidP;
			$dbc->query($query);

			$query = "SELECT adv, degProgram from applicant where uid = ".$uidP;
					
			$data = mysqli_query($dbc, $query);

			
		
			$row = mysqli_fetch_array($data);

			if ($row['degProgram'] == "md") {
				$row['degProgram'] = "masters";
			}

			$query = "INSERT INTO student (uid, advisoruid, program) values (".$uidP.", ".$row['adv'].", '".$row['degProgram']."')";
			$dbc->query($query);

			$home_url = "queueMatriculate.php";
				  
			header('Location: ' . $home_url);
		}
		else {
        
			$queryA = "select appStatus from applicant where uid = '$uid'";
								
			$dataA = mysqli_query($dbc, $queryA);

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
								<b>Card Information:</b> <br>
							
								<div class="form-group">
									<label for="fname">*First Name: </label>
									<input type="text" class="form-control" maxlength="255" onkeypress="return (event.charCode > 64 && 
									event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" id="fname" name = "fname" placeholder="Enter first name" required>
								</div>
								<div class="form-group">
									<label for="lname">*Last Name: </label>
									<input type="text" class="form-control" id="lname" maxlength="255" onkeypress="return (event.charCode > 64 && 
									event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" name = "lname" placeholder="Enter last name" required>
								</div>
								<div class="form-group">
									<label for="cc">*Card Number:</label>
									<input type="text" class="form-control" minlength="16" maxlength="16" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id="cc" name = "cc" placeholder="Enter a card Number" required>
								</div>
								<div class="form-group">
									<label for="cvv">*CVV:</label>
									<input type="text" class="form-control" minlength="3" maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id="cvv" name = "cvv" placeholder="Enter the cvv" required>
								</div>
								<div class="form-group">
									<label for="expireMM">*Expiration date:</label>
									<select name='expireMM' id='expireMM' class="form-control">
										<option value='' disable selected hidden>Month</option>
										<option value='01'>January</option>
										<option value='02'>February</option>
										<option value='03'>March</option>
										<option value='04'>April</option>
										<option value='05'>May</option>
										<option value='06'>June</option>
										<option value='07'>July</option>
										<option value='08'>August</option>
										<option value='09'>September</option>
										<option value='10'>October</option>
										<option value='11'>November</option>
										<option value='12'>December</option>
									</select> <br>
									<select name='expireYY' id='expireYY' class="form-control">
										<option value='' disable selected hidden>Year</option>
										<?php
											for ($i = 20; $i <= 30; $i++) {
												echo "<option value='".$i."'>20".$i."</option>";
											}
										?>
									</select> 
								</div>
								<div class="form-group" onchange="yesnoCheck()">
									<label for="degree">*Billing Address <br> Same as on file address?</label> </br>
									<input type="radio" id="yesCheck" name="ba" value="yes" required>
									<label for="yes">Yes</label><br>
									<input type="radio" id="noCheck" name="ba" value="no">
									<label for="no">No</label><br>
								</div>
								
								<div class="form-group">
									<label for="address" id="ifYes">Address: </label>
									<input type="text" id="ifYes"class="form-control" maxlength="255" id="address" name = "address" placeholder="Enter address" required>
								</div>
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

<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById("yesCheck").checked) {
			document.getElementById("address").required = true;

        } else {
			document.getElementById("address").required = false;
        }
    }
</script>