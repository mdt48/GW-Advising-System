<?php 
	require_once('navBar.php');

	if (isset($_SESSION['uid'])) {
		if (isset($_POST['uid'])) $uid = $_POST['uid'];
		else $uid = $_SESSION['uid'];
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
<?php
	// this is all the shit for the updating and inserting and bitches
	if (isset($_POST['appSem'])) {
		//application
		$appSem = mysqli_real_escape_string($dbc,$_POST['appSem']);
		$appYear = mysqli_real_escape_string($dbc,$_POST['appYear']);
		$aoi = mysqli_real_escape_string($dbc,$_POST['aoi']);
		$transcript = mysqli_real_escape_string($dbc,$_POST['transcript']);
		$workExp = mysqli_real_escape_string($dbc,$_POST['workExp']);
		$program = mysqli_real_escape_string($dbc,$_POST['program']);
		//EXAMSCORE TABLE
		$total = mysqli_real_escape_string($dbc,$_POST['total']);
		$verbal = mysqli_real_escape_string($dbc,$_POST['verbal']);
		$quant = mysqli_real_escape_string($dbc,$_POST['quant']);
		$greYearTaken = mysqli_real_escape_string($dbc,$_POST['greYearTaken']);

		$subj1 = mysqli_real_escape_string($dbc,$_POST['subj1']);
		$subjScore1 = mysqli_real_escape_string($dbc,$_POST['subjScore1']);
		$subjYearTaken1 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken1']);

		$subj2 = mysqli_real_escape_string($dbc,$_POST['subj2']);
		$subjScore2 = mysqli_real_escape_string($dbc,$_POST['subjScore2']);
		$subjYearTaken2 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken2']);

		$subj3 = mysqli_real_escape_string($dbc,$_POST['subj3']);
		$subjScore3 = mysqli_real_escape_string($dbc,$_POST['subjScore3']);
		$subjYearTaken3 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken3']);

		$subj4 = mysqli_real_escape_string($dbc,$_POST['subj4']);
		$subjScore4 = mysqli_real_escape_string($dbc,$_POST['subjScore4']);
		$subjYearTaken4 = mysqli_real_escape_string($dbc, $_POST['subjYearTaken4']);

		$subj5 = mysqli_real_escape_string($dbc,$_POST['subj5']);
		$subjScore5 = mysqli_real_escape_string($dbc,$_POST['subjScore5']);
		$subjYearTaken5 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken5']);

		$subj6 = mysqli_real_escape_string($dbc,$_POST['subj6']);
		$subjScore6 = mysqli_real_escape_string($dbc,$_POST['subjScore6']);
		$subjYearTaken6 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken6']);
		
		$subj8 = mysqli_real_escape_string($dbc,$_POST['subj8']);
		$subjScore8 = mysqli_real_escape_string($dbc,$_POST['subjScore8']);
		$subjYearTaken8 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken8']);

		//DEGREE TABLE
		$pdType1 = mysqli_real_escape_string($dbc,$_POST['pdType1']);
		$pdYear1 = mysqli_real_escape_string($dbc,$_POST['pdYear1']);
		$pdMajor1 = mysqli_real_escape_string($dbc,$_POST['pdMajor1']);
		$pdGPA1 = mysqli_real_escape_string($dbc,$_POST['pdGPA1']);
		$pdCollege1 = mysqli_real_escape_string($dbc,$_POST['pdCollege1']);

		$pdType2 = mysqli_real_escape_string($dbc,$_POST['pdType2']);
		$pdYear2 = mysqli_real_escape_string($dbc,$_POST['pdYear2']);
		$pdMajor2 = mysqli_real_escape_string($dbc,$_POST['pdMajor2']);
		$pdGPA2 = mysqli_real_escape_string($dbc,$_POST['pdGPA2']);
		$pdCollege2 = mysqli_real_escape_string($dbc,$_POST['pdCollege2']);

		//RECS TABLE
		$flag = true;
		$status = 0;
		$query = "select count(recId) as total from recs where uid = '$uid'";					
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);

		$queryCheck = "select count(recId) as total from recs where uid = '$uid' and content is not null";					
		$dataCheck = mysqli_query($dbc, $queryCheck);
		$rowCheck = mysqli_fetch_array($dataCheck);

		$nameQ = "select fname, lname from people where uid = '$uid'";
		$dataQ = mysqli_query($dbc, $nameQ);
		$rowQ = mysqli_fetch_array($dataQ);
		$fname = $rowQ['fname'];
		$lname = $rowQ['lname'];
		
		//check if email from recs is enabled or disabled
		if (isset($_POST['rec1Email'])) $rec1Email = mysqli_real_escape_string($dbc,$_POST['rec1Email']);
		else $rec1Email = 4; //means disabled
		
		if (isset($_POST['rec2Email'])) $rec2Email = mysqli_real_escape_string($dbc,$_POST['rec2Email']);

		if (isset($_POST['rec3Email'])) $rec3Email = mysqli_real_escape_string($dbc,$_POST['rec3Email']);

		if ($rec1Email == 4 && $transcript != NULL) { //disabled and there's transcript
			if ($row['total'] == $rowCheck['total']) $status = 2; //the number of applications is equal to the number of full applications
			else $status = 1;
		}
		else if ($rec1Email != 4 && $transcript != NULL) { //enabled and there's transcript
			if ($rec1Email == NULL && $rec2Email == NULL && $rec3Email == NULL) $status = 2;
			else $status = 1;
		}
		else $status = 1; //there's no transcript

		//update the information in applicant
		$appsql = "UPDATE applicant SET aoi = '$aoi', appExp = '$workExp', admissionYear = '$appYear', admissionSemester = '$appSem', degProgram = '$program', appStatus = '$status', transcript = '$transcript' WHERE uid = '$uid'";
        if (mysqli_query($dbc, $appsql) == false)
        {   
			$flag = false;
		}
		
		//delete all the degrees and examScores
		$query = "DELETE FROM degree WHERE uid = ".$uid;
		$dbc->query($query);
		$query = "DELETE FROM examScore WHERE uid = ".$uid;
		$dbc->query($query);
		
			//GRE
			if ($total != NULL && $verbal != NULL && $quant != NULL)
			{
				$gretotalsql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', 'total', '$total', '$greYearTaken')";
				if (mysqli_query($dbc, $gretotalsql) == false)
				{
					$flag = false;
				}
				$greverbalsql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', 'verbal', '$verbal', '$greYearTaken')";
				if (mysqli_query($dbc, $greverbalsql) == false)
				{
					$flag = false;
				}
				$grequantsql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', 'quantitative', '$quant', '$greYearTaken')";
				if (mysqli_query($dbc, $grequantsql) == false)
				{
					$flag = false;
				}
			}
			
			//GRE SUBJECTS
			if ($subjScore1 != NULL) 
			{
				$subj1sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj1', '$subjScore1', '$subjYearTaken1')";
				if (mysqli_query($dbc, $subj1sql) == false)
				{
					$flag = false;
				}
			}
			
			if ($subjScore2 != NULL)
			{
				$subj2sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj2', '$subjScore2', '$subjYearTaken2')";
				if (mysqli_query($dbc, $subj2sql) == false)
				{
					$flag = false;
				}
			}
			
			if ($subjScore3 != NULL)
			{
				$subj3sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj3', '$subjScore3', '$subjYearTaken3')";
				if (mysqli_query($dbc, $subj3sql) == false)
				{
					$flag = false;
				}
		
			}
			if ($subjScore4 != NULL)
			{
				$subj4sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj4', '$subjScore4', '$subjYearTaken4')";
				if (mysqli_query($dbc, $subjScore4) == false)
				{
					$flag = false;
				}
			}
			if ($subjScore5 != NULL)
			{
				$subj5sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj5', '$subjScore5', '$subjYearTaken5')";
				if (mysqli_query($dbc, $subj5sql) == false)
				{
					$flag = false;
				}
			}
	
			if ($subjScore6 != NULL)
			{
				$subj6sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj6', '$subjScore6', '$subjYearTaken6')";
				if (mysqli_query($dbc, $subj6sql) == false)
				{
					$flag = false;
				}
			}
	
			if ($subjScore8 != NULL)
			{
				$subj8sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj8', '$subjScore8', '$subjYearTaken8')";
				if (mysqli_query($dbc, $subj8sql) == false)
				{
					$flag = false;
				}
			}
	
			//PRIOR DEGREE
			if ($pdMajor1 != NULL && $pdGPA1 != NULL && $pdCollege1 != NULL)
			{
				$pd1sql = "INSERT INTO degree (uid, degType, school, gpa, major, yearGrad) VALUES ('$uid', '$pdType1', '$pdCollege1', '$pdGPA1', '$pdMajor1', '$pdYear1')";
				if (mysqli_query($dbc, $pd1sql) == false)
				{
					$flag = false;
				}
			}
	
			if ($pdMajor2 != NULL && $pdGPA2 != NULL && $pdCollege2 != NULL)
			{
				$pd2sql = "INSERT INTO degree (uid, degType, school, gpa, major, yearGrad) VALUES ('$uid', '$pdType2', '$pdCollege2', '$pdGPA2', '$pdMajor2', '$pdYear2')";
				if (mysqli_query($dbc, $pd2sql) == false)
				{
					$flag = false;
				}
			}
			//Recs
			
			if ($rec1Email != 4) { //if it isn't disabled
				$checkEmailQ = "select * from recs where uid = '$uid'";		
				$checkEmailD = mysqli_query($dbc, $checkEmailQ);
				while ($checkEmailR = mysqli_fetch_array($checkEmailD)) { //while there are queries that need to be checked for
					if ($checkEmailR['email'] != $rec1Email && $checkEmailR['email'] != $rec2Email && $checkEmailR['email'] != $rec3Email) { //the email isn't equal to any of the ones stored;
						//message that their rec isn't required anymore
						$msg = "Your recommendation letter for " . $fname . " " . $lname . " is no longer required. Thank you for your time, GW Graduate Program.";
						mail($checkEmailR['email'], "GW Graduate Program", $msg);
						//delete their spot from the table
						$query = 'DELETE FROM recs WHERE recId = '.$checkEmailR['recId'];
						$dbc->query($query);
					}
					//at this point one of them was the same, so make that be null
					else if ($checkEmailR['email'] == $rec1Email) $rec1Email = NULL;
					else if ($checkEmailR['email'] == $rec2Email) $rec2Email = NULL;
					else $rec3Email = NULL;
				}
				
				if ($rec1Email != NULL)
				{
					$rec1sql = "INSERT INTO recs (uid, email) VALUES ('$uid', '$rec1Email')";
					if (mysqli_query($dbc, $rec1sql) == false)
					{
						$flag = false;
					}
					else {
						$result = $dbc->query("SELECT recId FROM recs WHERE uid = '$uid' AND email = '$rec1Email'");
						$row = $result->fetch_object();
						$msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp1-git-happens/git-happens/recommendation.html";
						mail($rec1Email, "GW Graduate Program Letter of Recommendation Request", $msg);
					}
				}
		
				if ($rec2Email != NULL)
				{
					$rec2sql = "INSERT INTO recs (uid, email) VALUES ('$uid', '$rec2Email')";
					if (mysqli_query($dbc, $rec2sql) == false)
					{
						$flag = false;
					}
					else {
						$result = $dbc->query("SELECT recId FROM recs WHERE uid = '$uid' AND email = '$rec2Email'");
						$row = $result->fetch_object();
						$msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp1-git-happens/git-happens/recommendation.html";
						mail($rec2Email, "GW Graduate Program Letter of Recommendation Request", $msg);
					}
				}
		
				if ($rec3Email != NULL)
				{
					$rec3sql = "INSERT INTO recs (uid, email) VALUES ('$uid', '$rec3Email')";
					if (mysqli_query($dbc, $rec3sql) == false)
					{
						$flag = false;
					}
					else {
						$result = $dbc->query("SELECT recId FROM recs WHERE uid = '$uid' AND email = '$rec2Email'");
						$row = $result->fetch_object();
						$msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId .  "Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp1-git-happens/git-happens/recommendation.html";
						mail($rec3Email, "GW Graduate Program Letter of Recommendation Request", $msg);
					}
				}
			}	
		
		if ($flag == true)
        {   
           ?>
			<div class="container">
                        <div class="alert alert-success" role="alert">Successfully changed information!</div>
                        </div>
		<?php	
		}
		else {
			?>
			<div class="container">
			<div class="alert alert-danger" role="alert">ERROR: Some of the information was not changed properly</div>
			</div><?php
		}
		
	}
		?>

<div class = "container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	<div class = "col-md-20 mb-5">
	    <h2>Academic Information</h2>
	</div>
	
	<?php 
		$query = "select * from applicant where uid = '$uid'";
							
		$data = mysqli_query($dbc, $query);

		if (mysqli_num_rows($data) == 1) {
            $rowA = mysqli_fetch_array($data);

            //info from degrees
            $queryD = "select * from degree where uid = '$uid'";				
			$dataD = mysqli_query($dbc, $queryD);  
			
			//info from examScores
            $queryE = 'select * from examScore where uid = '.$uid.' and examSubject != "total" and examSubject != "verbal" and examSubject != "quantitative" order by examSubject asc';				
			$dataE = mysqli_query($dbc, $queryE);  
			$rowE = mysqli_fetch_array($dataE);
			
            //info from recs
            $queryR = "select email from recs where uid = '$uid'";				
			$dataR = mysqli_query($dbc, $queryR);  
            ?>            
            <div class = "form-group">
            <b><label for="appDate">Application Date*</label></b></br>
			<select id="appSem" name="appSem" required>
                <?php
                    if ($rowA['admissionSemester'] == "fall") {
                        ?>        
                            <option value="fall">Fall</option>
                            <option value="spring">Spring</option>
                        <?php
                    }
                    else {
                        ?>   
                        <option value="spring">Spring</option>
                        <option value="fall">Fall</option>
                        <?php
                    }
                ?>
			</select>
			<input type="number" min="2020" max="2050" step="1" value="<?php echo $rowA['admissionYear'];?>" name="appYear" required>
            </div>

            <div class="form-group">
                <b><label for="aio">Areas of Interest*</label></b>
                <input type="text" class="form-control" maxlength="255" id="aoi" name = "aoi" value="<?php echo $rowA['aoi']; ?>" placeholder="Enter areas of interest" required>
            </div>
            <div class="form-group">
                <b><label for="workExp">Past Work Experience (Optional)</label></b>
                <textarea class="form-control" maxLength = "255" id="workExp" name = "workExp" placeholder="Enter past work experience"><?php echo $rowA['appExp']; ?></textarea>
			</div>
			
			<div class="form-group" onchange="yesnoCheck()">
				<b><label for="degree">Application Degree Program Type*</label> </br></b>
				<?php if ($rowA['degProgram'] == "md") { ?>
				<input type="radio" id="noCheck" name="program" value="md" required checked>
				<label for="md">Masters Program</label><br>
				<input type="radio" id="yesCheck" name="program" value="phd" required>
				<label for="phd">Doctoral Program</label><br>
			<?php	}
				else { ?>
				<input type="radio" id="noCheck" name="program" value="md" required >
				<label for="md">Masters Program</label><br>
				<input type="radio" id="yesCheck" name="program" value="phd" required checked>
				<label for="phd">Doctoral Program</label><br>
			<?php	} ?>
			</div>
			<div class="form-group">
			<b><label for="pDeg">Prior Degrees (Optional)</label> </br></b>
			<table id="pDeg" class="form" border="1">
				<tbody>
						<tr>
							<th>Type of Prior Degree</th>
							<th>Year Degree Received</th>
							<th>Major</th>
							<th>GPA</th>
							<th>University</th>
						</tr>
						<tr>
							<td>
								
							<select id="pdType1" name="pdType1">
			<?php

			$rowD = mysqli_fetch_array($dataD);
			if ($rowD['degType'] == "BS") { ?> 
				<option value="BS">Bachelors of Science</option>
				<option value="BA">Bachelors of Arts</option>
				<option value="MS">Masters</option>
				<option value="PhD">Doctoral</option>
			<?php
			}
			 else if ($rowD['degType'] == "MS") {?> 
				<option value="MS">Masters</option>
				<option value="BA">Bachelors of Arts</option>
				<option value="BS">Bachelors of Science</option>
				<option value="PhD">Doctoral</option>			
			<?php
			}
			else if ($rowD['degType'] == "PhD") {?> 
				<option value="PhD">Doctoral</option>		
				<option value="BA">Bachelors of Arts</option>
				<option value="BS">Bachelors of Science</option>
				<option value="MS">Masters</option>	
				<?php
			}
			else {?> 
				<option value="BA">Bachelors of Arts</option>
				<option value="BS">Bachelors of Science</option>
				<option value="MS">Masters</option>
				<option value="PhD">Doctoral</option>			
				<?php			
			}?>
							</select>
						</td>
						<td>
							<input type="number" min = "1940" max = "2020" step = "1" value = "<?php echo $rowD['yearGrad']?>" id ="pdYear1" name="pdYear1">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
							event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxLength = "255" id ="pdMajor1" name="pdMajor1" value = "<?php echo $rowD['major']?>">
						</td>
						<td>
							<input type="text"  maxLength = "4" onkeypress = "return (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46)" id = "pdGPA1" name="pdGPA1" value = "<?php echo $rowD['gpa']?>">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
							event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxlength = "255" id = "pdCollege1" name="pdCollege1" value = "<?php echo $rowD['school']?>">
						</td>
				</tr>
				<tr>
							<td>
								
							<select id="pdType2" name="pdType2">
			<?php

			$rowD = mysqli_fetch_array($dataD);
			if ($rowD['degType'] == "BS") { ?> 
				<option value="BS">Bachelors of Science</option>
				<option value="BA">Bachelors of Arts</option>
				<option value="MS">Masters</option>
				<option value="PhD">Doctoral</option>
			<?php
			}
			 else if ($rowD['degType'] == "MS") {?> 
				<option value="MS">Masters</option>
				<option value="BA">Bachelors of Arts</option>
				<option value="BS">Bachelors of Science</option>
				<option value="PhD">Doctoral</option>			
			<?php
			}
			else if ($rowD['degType'] == "PhD") {?> 
				<option value="PhD">Doctoral</option>		
				<option value="BA">Bachelors of Arts</option>
				<option value="BS">Bachelors of Science</option>
				<option value="MS">Masters</option>	
				<?php
			}
			else {?> 
				<option value="BA">Bachelors of Arts</option>
				<option value="BS">Bachelors of Science</option>
				<option value="MS">Masters</option>
				<option value="PhD">Doctoral</option>			
				<?php			
			}?>
							</select>
						</td>
						<td>
							<input type="number" min = "1940" max = "2020" step = "1" value = "<?php echo $rowD['yearGrad']?>" id ="pdYear2" name="pdYear2">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
							event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxLength = "255" id ="pdMajor2" name="pdMajor2" value = "<?php echo $rowD['major']?>">
						</td>
						<td>
							<input type="text"  maxLength = "4" onkeypress = "return (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46)" id = "pdGPA2" name="pdGPA2" value = "<?php echo $rowD['gpa']?>">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
							event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxlength = "255" id = "pdCollege2" name="pdCollege2" value = "<?php echo $rowD['school']?>">
						</td>
				</tr>
				</tbody>
				</table>
				</div>
		<div class="form-group">
            <b><label for="transcript">Transcript (if link not given, transcript must be emailed)</label></b>
            <input type="text" class="form-control" maxlength="255" id="transcript" name = "transcript" placeholder="Enter link to registrar" value = "<?php echo $rowA['transcript'];?>" >
		</div>
				
			<?php					
            $queryEQ = 'select * from examScore where uid = '.$uid.' and examSubject = "quantitative"';				
			$dataEQ = mysqli_query($dbc, $queryEQ); 
			$rowEQ = mysqli_fetch_array($dataEQ);
			$queryEV = 'select * from examScore where uid = '.$uid.' and examSubject = "verbal"';				
			$dataEV = mysqli_query($dbc, $queryEV);
			$rowEV = mysqli_fetch_array($dataEV);
			$queryET = 'select * from examScore where uid = '.$uid.' and examSubject = "total"';				
			$dataET = mysqli_query($dbc, $queryET);
			$rowET = mysqli_fetch_array($dataET);
			?>
			<div class="form-group">
				<table id="ifYes" class="form">
					<tbody>
						<tr><th>GRE Scores</th></tr>
						<tr>
								<th>Verbal</th>
								<th>Quantitative</th>
								<th>Total</th>
								<th>Year Taken</th>
						</tr>
						<tr>
								<td>
									<input type="text" maxlength="3" onchange="sumFunct()" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "verbal" name="verbal" value = "<?php echo $rowEV['score']?>">
								</td>
								<td>
									<input type="text" maxlength="3" onchange="sumFunct()" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "quant" name="quant" value = "<?php echo $rowEQ['score']?>">
								</td>
								<td>
									<input type="text" maxlength="3" id = "total1" name="total1" value = "<?php echo $rowET['score']?>" disabled>
									<input type="hidden" maxlength="3" id = "total" name="total" value = "<?php echo $rowET['score']?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" value = "<?php echo $rowET['yearTake']?>" id = "greYearTaken" name="greYearTaken">
								</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="form-group">
			<b><label for="greSubj">GRE Advanced and TOEFL Tests (Optional)</label> </br></b>
				<table id="dataTable" rowspan = "7" colspan = "3" class="form" border="1">
					<thread>
						<tr>
							<th>Subject</th>
							<th>Score</th>
							<th>Year Taken</th>
						</tr>
						<tbody>
						<tr>
							<td>
								<input type="text"   maxlength="255" value = "Biology" id = "subj10" name="subj10" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden" value = "Biology" id = "subj1" name="subj1">
							</td>
							<td>
								<?php
								if ($rowE['examSubject'] == "Biology") { ?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore1" name="subjScore1" value = "<?php echo $rowE['score'] ?>">
							</td>
							<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken1" name="subjYearTaken1" value = "<?php echo $rowE['yearTake'] ?>">
							</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore1" name="subjScore1">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken1" name="subjYearTaken1">
							</td>
							<?php } ?>
						</tr>
						<tr>
							<td>
								<input type="text"   maxlength="255" value = "Chemistry" id = "subj20" name="subj20" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden" value = "Chemistry" id = "subj2" name="subj2">
								</td>
								<td>
								<?php
								if ($rowE['examSubject'] == "Chemistry") { ?>

								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore2" name="subjScore2" value = "<?php echo $rowE['score'] ?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken2" name="subjYearTaken2" value = "<?php echo $rowE['yearTake'] ?>">
								</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore2" name="subjScore2">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken2" name="subjYearTaken2">
							</td>
							<?php } ?>
						</tr>
						<tr>
							<td>
								<input type="text"   maxlength="255" value = "Literature" id = "subj30" name="subj30" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden"   maxlength="255" value = "Literature" id = "subj3" name="subj3">
								</td>
								<td>
								<?php
								if ($rowE['examSubject'] == "Literature") { ?>

								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore3" name="subjScore3" value = "<?php echo $rowE['score'] ?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken3" name="subjYearTaken3" value = "<?php echo $rowE['yearTake'] ?>">
								</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore3" name="subjScore3">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken3" name="subjYearTaken3">
							</td>
							<?php } ?>
						</tr>
						<tr>
							<td>
								<input type="text"   maxlength="255" value = "Mathematics" id = "subj40" name="subj40" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden"   maxlength="255" value = "Mathematics" id = "subj4" name="subj4">	
							</td>
								<td>
								<?php
								if ($rowE['examSubject'] == "Mathematics") { ?>

								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore4" name="subjScore4" value = "<?php echo $rowE['score'] ?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken4" name="subjYearTaken4" value = "<?php echo $rowE['yearTake'] ?>">
								</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore4" name="subjScore4">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken4" name="subjYearTaken4">
							</td>
							<?php } ?>
						</tr>
						<tr>
							<td>
								<input type="text"   maxlength="255" value = "Physics" id = "subj50" name="subj50" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden"   maxlength="255" value = "Physics" id = "subj5" name="subj5">	
							</td>
								<td>
								<?php
								if ($rowE['examSubject'] == "Physics") { ?>

								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore5" name="subjScore5" value = "<?php echo $rowE['score'] ?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken5" name="subjYearTaken5" value = "<?php echo $rowE['yearTake'] ?>">
								</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore5" name="subjScore5">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken5" name="subjYearTaken5">
							</td>
							<?php } ?>
						</tr>
						<tr>
							<td>
								<input type="text"   maxlength="255" value = "Psychology" id = "subj60" name="subj60" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden"   maxlength="255" value = "Psychology" id = "subj6" name="subj6">	
							</td>
								<td>
								<?php
								if ($rowE['examSubject'] == "Psychology") { ?>

								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore6" name="subjScore6" value = "<?php echo $rowE['score'] ?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken6" name="subjYearTaken6" value = "<?php echo $rowE['yearTake'] ?>">
								</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore6" name="subjScore6">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken6" name="subjYearTaken6">
							</td>
							<?php } ?>
						</tr>
						<tr>
						<td>
								<input type="text"   maxlength="255" value = "TOEFL" id = "subj80" name="subj80" onkeypress = "return (event.charCode > 0 && event.charCode < 1)" disabled>
								<input type="hidden"   maxlength="255" value = "TOEFL" id = "subj8" name="subj8">	
							</td>
								<td>
								<?php
								if ($rowE['examSubject'] == "TOEFL") { ?>

								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore8" name="subjScore8" value = "<?php echo $rowE['score'] ?>">
								</td>
								<td>
									<input type="number" min="1940" max="2020" step="1" id = "subjYearTaken8" name="subjYearTaken" value = "<?php echo $rowE['yearTake'] ?>">
								</td>
								<?php 
								$rowE = mysqli_fetch_array($dataE);	
								} else {
								?>
								<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore8" name="subjScore8">
							</td>
							<td>
								<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken8" name="subjYearTaken8">
							</td>
							<?php } ?>
							
						</tr>
						</tbody>
					</thead>
				</table>
		</div>
		<?php 
		$query = "select count(recId) as total from recs where uid = '$uid'";					
		$data = mysqli_query($dbc, $query);
		$row = mysqli_fetch_array($data);

		$queryCheck = "select count(recId) as total from recs where uid = '$uid' and content is null";					
		$dataCheck = mysqli_query($dbc, $queryCheck);
		$rowCheck = mysqli_fetch_array($dataCheck);

		$queryStaff = "SELECT * FROM staff WHERE uid = '".$_SESSION['uid']."'";
		$dataStaff = mysqli_query($dbc, $queryStaff);
		$rowStaff = mysqli_num_rows($dataStaff);
 
		if ($row['total'] == 0 || $row['total'] == $rowCheck['total'] || $rowStaff['type'] == 1 || $rowStaff['type'] == 0) {
			?>
			<div class="form-group">
				<b><label for="recs">Recommendation Letter Contacts</label></br></b>
				<label for="rec1">Recommender 1</label></br>
				<label for="rec1Email">Email:</label>
				<?php $rowR = mysqli_fetch_array($dataR);?>
				<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec1Email" name="rec1Email" value = "<?php echo $rowR['email']; ?>"></br>
				<?php
				$rowR = mysqli_fetch_array($dataR);?>
				<label for="rec2">Recommender 2</label></br>
				<label for="rec2Email">Email:</label>
				<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec2Email" name="rec2Email" value = "<?php echo $rowR['email']; ?>"></br>
				<?php
				$rowR = mysqli_fetch_array($dataR);?>
				<label for="rec3">Recommender 3</label></br>
				<label for="rec3Email">Email:</label>
				<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec3Email" name="rec3Email" value = "<?php echo$rowR['email']; ?>"></br>
			</div>
			<?php
		}
		else {
		?>	
			<div class="form-group">
				<b><label for="recs">Recommendation Letter Contacts</label></br></b>
				<label for="rec1">Recommender 1</label></br>
				<label for="rec1Email">Email:</label>
				<?php $rowR = mysqli_fetch_array($dataR);?>
				<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec1Email" name="rec1Email" value = "<?php echo $rowR['email']; ?>" disabled></br>
				<?php
				$rowR = mysqli_fetch_array($dataR);?>
				<label for="rec2">Recommender 2</label></br>
				<label for="rec2Email">Email:</label>
				<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec2Email" name="rec2Email" value = "<?php echo $rowR['email']; ?>" disabled></br>
				<?php
				$rowR = mysqli_fetch_array($dataR);?>
				<label for="rec3">Recommender 3</label></br>
				<label for="rec3Email">Email:</label>
				<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec3Email" name="rec3Email" value = "<?php echo$rowR['email']; ?>" disabled></br>
			</div>
		<?php	} ?>	
			<input type="hidden" name="uid" value="<?php echo $uid?>" >
			<input type="submit" value="Submit" name="submit">
	  </form>
		</div>
	<?php
		$select = "select * from applicant where uid = ".$_SESSION['uid'];
		$data = mysqli_query($dbc, $select);
		if (mysqli_num_rows($data) == 1) {
			?>
		<div class="row">	<p>
			<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a></p> </div>
		<br> <br> <br>
			<?php
		}
		else {
			?>
			<div class="row">	<p>
				<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "queue.php">Go Back</a></p> </div>
		<br> <br> <br>
			<?php
		}
	}

} else {  ?>
	</div>
	<br/>
</div>

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

<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById("yesCheck").checked) {
			document.getElementById("total").required = true;
			document.getElementById("quant").required = true;
			document.getElementById("verbal").required = true;

        } else {
			document.getElementById("total").required = false;
			document.getElementById("quant").required = false;
			document.getElementById("verbal").required = false;
        }
    }
	
	function sumFunct() {
		var sum = 0;
		if (parseInt(document.getElementById("quant").value) > 170 || parseInt(document.getElementById("quant").value) <= 0) {
			document.getElementById("quant").value = 0;
		}
		else if (parseInt(document.getElementById("verbal").value) > 170 || parseInt(document.getElementById("verbal").value) <= 0) {
			document.getElementById("verbal").value = 0;
		}
		else {
			sum += parseInt(document.getElementById("quant").value);
			sum += parseInt(document.getElementById("verbal").value);
		}
		document.getElementById("total1").value = sum;
		document.getElementById("total").value = sum;
	}
	
</script>