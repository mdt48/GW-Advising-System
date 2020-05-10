<?php 
	require_once('navBar.php');
	
	if (isset($_SESSION['uid'])) {
	     $uid = $_POST['uid'];
		    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	?>
<!-- HEADER -->
<header class = "bg py-5 mb-5" style = "background-color: #033b59;">
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Edit Information</h1>
			</div>
		</div>
	</div>
</header>
<?php
	//section to update db
	if (isset($_POST['submit'])) {
	    
	    $flag = true;
	    
	    //ALL INFORMATION (USER TABLE)
	    $fname = mysqli_real_escape_string($dbc, $_POST['fname']);
	    $lname = mysqli_real_escape_string($dbc,$_POST['lname']);
	    $SSN = mysqli_real_escape_string($dbc,$_POST['SSN']);
	    $birthdate = mysqli_real_escape_string($dbc,$_POST['birthdate']);
	    $addr = mysqli_real_escape_string($dbc,$_POST['addr']);
	    $email = mysqli_real_escape_string($dbc,$_POST['email']);
	    $username = mysqli_real_escape_string($dbc,$_POST['username']);
	    $password = mysqli_real_escape_string($dbc,$_POST['password']);
	
	
	    //Update
	    if ($dbc->query("SELECT uid FROM people WHERE uid = '$uid'"))
	    {
	        $usersql = "UPDATE people SET fname = '$fname', lname = '$lname', ssn = '$SSN', birthDate = '$birthdate', address = '$addr', username = '$username', password = '$password', email = '$email' WHERE uid = '$uid'";
	        if (mysqli_query($dbc, $usersql) == false)
	        {   
	            $flag = false;
	        }
	    }
	
	    //Applicant stuff
	    if ($_POST['type'] == "Applicant") {
	        if ($_POST['category'] == "Not yet Applied") {
	            //APP INFO
	            //APPLICANT TABLE
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
	            $rec1Name = mysqli_real_escape_string($dbc,$_POST['rec1Name']);
	            $rec1Email = mysqli_real_escape_string($dbc,$_POST['rec1Email']);
	            $rec2Name = mysqli_real_escape_string($dbc,$_POST['rec2Name']);
	            $rec2Email = mysqli_real_escape_string($dbc,$_POST['rec2Email']);
	            $rec3Name = mysqli_real_escape_string($dbc,$_POST['rec3Name']);
	            $rec3Email = mysqli_real_escape_string($dbc,$_POST['rec3Email']);
	
	            if (isset($_POST['submit']))
	            {    
	                $status = 1;
	                $_POST['category'] = "Incomplete";
	                //APPLICANT   
	                if ($transcript != NULL && $rec1Email == NULL && $rec2Email == NULL && $rec3Email == NULL) {
	                    $status = 2;
	                    $_POST['category'] = "Complete";
	                }
	
	                $date = date('Y-m-d');
	
	                $applicantsql = "INSERT INTO applicant (uid, aoi, appExp, admissionYear, admissionSemester, degProgram, appStatus, transcript, appDate) VALUES ('$uid', '$aoi', '$workExp', '$appYear', '$appSem', '$program', '$status', '$transcript', '$date')";
	                
	                if (mysqli_query($dbc, $applicantsql) == false)
	                {
	                    $flag = false;
	                }
	                else {
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
	                            $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form.http://gwupyterhub.seas.gwu.edu/~sp20DBp2-git-good/git-good/recommendation.html";
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
	                            $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form. http://gwupyterhub.seas.gwu.edu/~sp20DBp2-git-good/git-good/recommendation.html";
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
	                            $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form. http://gwupyterhub.seas.gwu.edu/~sp20DBp2-git-good/git-good/recommendation.html";
	                            mail($rec3Email, "GW Graduate Program Letter of Recommendation Request", $msg);
	                        }
	                    }
	                }
	        }
	
	    
	 
	    }
	    else {
	        if (isset($_POST['appStatus'])) {
	            $usersql = "UPDATE applicant SET appStatus = ".$_POST['appStatus']." WHERE uid = '$uid'";
	            if (mysqli_query($dbc, $usersql)) {
	                $flag = true;
	                if ($_POST['appStatus'] == 6) $_POST['category'] = "Declined";
	                else if ($_POST['appStatus'] == 4) $_POST['category'] = "Admitted";
	                else $_POST['category'] = "Admitted with Aid";
	            }
	            else $flag = false;
	        }
	        if (isset($_POST['adv'])) {
	            $usersql = "UPDATE applicant SET adv = ".$_POST['adv']." WHERE uid = '$uid'";
	            if (mysqli_query($dbc, $usersql)) $flag = true;
	            else $flag = false;
	        }
	    }
	}
	if ($_POST['type'] == 'Staff') {
	    $usersql = "UPDATE staff SET type = ".$_POST['role'].", yearsWorking = ".$_POST['years'].", department = '".$_POST['dept']."'  WHERE uid = '$uid'";
	    if (mysqli_query($dbc, $usersql)) {
	        $flag = true;
	        if ($_POST['role'] == 0) {
	            $_POST['category'] = "Admin";
	        }
	        else if ($_POST['role'] == 1) {
	            $_POST['category'] = "Graduate Secretary";
	        }
	        else if ($_POST['role'] == 2) {
	            $_POST['category'] = "CAC";
	        }
	        else if ($_POST['role'] == 3) {
	            $_POST['category'] = "Faculty Reviewer";
	        }
	        else if ($_POST['role'] == 4) {
	            $_POST['category'] = "Faculty Advisor";
	        }
	        else if ($_POST['role'] == 5) {
	            $_POST['category'] = "Faculty Instructor";
	        }
	        else if ($_POST['role'] == 6) {
	            $_POST['category'] = "Faculty Reviewer and Advisor";
	        }
	        else if ($_POST['role'] == 7){
	            $_POST['category'] = "Faculty Reviewer and Instructor";
	        }
	        else if ($_POST['role'] == 8){
	            $_POST['category'] = "Faculty Advisor and Instructor";
	        }
	        else {
	            $_POST['category'] = "Faculty Reviewer, Advisor and Instructor";
	        }
	    }
	    else $flag = false;
	
	    
	
	}
	if ($flag == true) {   
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
</div>
<?php
	}
	}?>
<div class = "container">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<?php 
			//everyone's stuff
			 $queryP = "select * from people where uid = '$uid'";
			 $dataP = mysqli_query($dbc, $queryP);
			 $rowP = mysqli_fetch_array($dataP);?>
		<div class = "col-md-20 mb-5">
			<h1>Personal Information</h1>
		</div>
		<div class="form-group">
			<b><label for="fname">First Name*</label></b>
			<input type="text" class="form-control" maxlength="255" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" id="fname" name = "fname" value ="<?php echo $rowP['fname']?>"  placeholder="Enter first name" required>
		</div>
		<div class="form-group">
			<b><label for="lname">Last Name*</label></b>
			<input type="text" class="form-control" id="lname" maxlength="255" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)" name = "lname" value ="<?php echo $rowP['lname']?>" placeholder="Enter last name" required>
		</div>
		<div class="form-group">
			<b><label for="lname">Username*</label></b>
			<input type="text" class="form-control" id="lname" maxlength="255" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)" name = "username" value ="<?php echo $rowP['username']?>" placeholder="Enter username" required>
		</div>
		<div class="form-group">
			<b><label for="lname">Password*</label></b>
			<input type="text" class="form-control" id="lname" maxlength="255" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)  || (event.charCode == 33) || (event.charCode == 46) || (event.charCode == 45)" name = "password" value ="<?php echo $rowP['password']?>" placeholder="Enter password" required>
		</div>
		<div class="form-group">
			<b><label for="lname">Email*</label></b>
			<input type="text" class="form-control" id="lname" maxlength="255" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)" name = "email" value ="<?php echo $rowP['email']?>" placeholder="Enter email" required>
		</div>
		<div class="form-group">
			<b><label for="SSN">Social Security Number*</label></b>
			<input type="text" class="form-control" minlength="9" maxlength="9" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id="SSN" name = "SSN" value ="<?php echo $rowP['ssn']?>" placeholder="Enter social security number" required>
		</div>
		<div class="form-group">
			<b><label for="birthdate">Birthdate*</label></b>
			<input type="date" class="form-control" pattern = "(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))
				" id="birthdate" value ="<?php echo $rowP['birthDate']?>" placeholder="Enter YYYY-MM-DD" name = "birthdate" required>
		</div>
		<div class="form-group">
			<b><label for="addr">Address*</label></b>
			<input type="text" class="form-control" maxlength="255" id="addr" name = "addr" value ="<?php echo $rowP['address']?>" placeholder="Enter street, city, state/province, zip/postal code, and country" required>
		</div>
		</br>
		<?php 
			//applicant stuff
			 if  ($_POST['type'] == 'Applicant') {	
			    //if the person hasn't applied yet they can apply thru the admin
			     if ($_POST['category'] == "Not yet Applied") { ?>
		<div class = "col-md-20 mb-5">
			<h1>Application Information</h1>
		</div>
		<div class = "form-group">
			<b><label for="appDate">Application Date*</label></b></br>
			<label for="appSem">
				Application Semester</label required>
				<select id="appSem" name="appSem">
					<option value="fall">Fall</option>
					<option value="spring">Spring</option>
				</select>
			<label for="appYear">Application Year</label>
			<input type="number" min="2020" max="2050" step="1" value="2020" name="appYear" required>
		</div>
		<div class="form-group">
			<b><label for="aio">Areas of Interest*</label></b>
			<input type="text" class="form-control" maxlength="255" id="aoi" name = "aoi" placeholder="Enter areas of interest" required>
		</div>
		<div class="form-group">
			<b><label for="workExp">Past Work Experience (Optional)</label></b>
			<textarea class="form-control" maxLength = "255" id="workExp" name = "workExp" placeholder="Enter past work experience"></textarea>
		</div>
		<div class="form-group" onchange="yesnoCheck()">
			<b><label for="degree">Application Degree Program Type*</label> </br></b>
			<input type="radio" id="noCheck" name="program" value="md" required>
			<label for="md">Masters Program</label><br>
			<input type="radio" id="yesCheck" name="program" value="phd">
			<label for="phd">Doctoral Program</label><br>
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
								<option value="BA">Bachelors of Arts</option>
								<option value="BS">Bachelors of Science</option>
								<option value="MS">Masters</option>
								<option value="PhD">Doctoral</option>
							</select>
						</td>
						<td>
							<input type="number" min = "1940" max = "2020" step = "1" value = "2020" id ="pdYear1" name="pdYear1">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
								event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxLength = "255" id ="pdMajor1" name="pdMajor1">
						</td>
						<td>
							<input type="text"  maxLength = "4" onkeypress = "return (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46)" id = "pdGPA1" name="pdGPA1">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
								event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxlength = "255" id = "pdCollege1" name="pdCollege1">
						</td>
					</tr>
					<tr>
						<td>
							<select id="pdType2" name="pdType2">
								<option value="BA">Bachelors of Arts</option>
								<option value="BS">Bachelors of Science</option>
								<option value="MS">Masters</option>
								<option value="PhD">Doctoral</option>
							</select>
						</td>
						<td>
							<input type="number" min = "1940" max = "2020" step = "1" value = "2020" id ="pdYear2" name="pdYear2">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
								event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxLength = "255" id ="pdMajor2" name="pdMajor2">
						</td>
						<td>
							<input type="text"  maxLength = "4" onkeypress = "return (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46)" id = "pdGPA2" name="pdGPA2">
						</td>
						<td>
							<input type="text"  onkeypress="return (event.charCode > 64 && 
								event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxlength = "255" id = "pdCollege2" name="pdCollege2">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="form-group">
			<b><label for="transcript">Transcript (if link not given, transcript must be emailed)</label></b>
			<input type="text" class="form-control" maxlength="255" id="transcript" name = "transcript" placeholder="Enter link to registrar" >
		</div>
		<div class="form-group">
			<table id="ifYes" class="form">
				<tbody>
					<tr>
						<th>GRE Scores</th>
					</tr>
					<tr>
						<th>Verbal</th>
						<th>Quantitative</th>
						<th>Total</th>
						<th>Year Taken</th>
					</tr>
					<tr>
						<td>
							<input type="text" maxlength="3" onchange="sumFunct()" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "verbal" name="verbal">
						</td>
						<td>
							<input type="text" maxlength="3" onchange="sumFunct()" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "quant" name="quant">
						</td>
						<td>
							<input type="text" maxlength="3" id = "total1" name="total1" disabled>
							<input type="hidden" maxlength="3" id = "total" name="total">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "greYearTaken" name="greYearTaken">
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
							<input type="text"   maxlength="255" value = "Biology" id = "subj1" name="subj1" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore1" name="subjScore1">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken1" name="subjYearTaken1">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text"   maxlength="255" value = "Chemistry" id = "subj2" name="subj2" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore2" name="subjScore2">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken2" name="subjYearTaken2">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text"   maxlength="255" value = "Literature" id = "subj3" name="subj3" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore3" name="subjScore3">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken3" name="subjYearTaken3">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text"  maxlength="255" value = "Mathematics"  id = "subj4" name="subj4" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"   maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore4" name="subjScore4">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken4" name="subjYearTaken4">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text"   maxlength="255" value = "Physics" id = "subj5" name="subj5" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore5" name="subjScore5">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken5" name="subjYearTaken5">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text"   maxlength="255" value = "Psychology" id = "subj6" name="subj6" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore6" name="subjScore6">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken6" name="subjYearTaken6">
						</td>
					</tr>
					<tr>
						<td>
							<input type="text"   maxlength="255" value = "TOEFL" id = "subj8" name="subj8" onkeypress = "return (event.charCode > 0 && event.charCode < 1)">
						</td>
						<td>
							<input type="text"  maxlength="3" onkeypress = "return (event.charCode > 47 && event.charCode < 58)" id = "subjScore8" name="subjScore8">
						</td>
						<td>
							<input type="number" min="1940" max="2020" step="1" value="2020" id = "subjYearTaken8" name="subjYearTaken8">
						</td>
					</tr>
				</tbody>
				</thead>
			</table>
		</div>
		<div class="form-group">
			<b><label for="recs">Recommendation Letter Contacts</label></br></b>
			<label for="rec1">Recommender 1</label></br>
			<label for="rec1Name">Name:</label>
			<input type="text" id="rec1Name" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxlength="255" name="rec1Name"></br>
			<label for="rec1Email">Email:</label>
			<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec1Email" name="rec1Email"></br>
			<label for="rec2">Recommender 2</label></br>
			<label for="rec2Name">Name:</label>
			<input type="text" id="rec2Name" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxLength = "255" name="rec2Name"></br>
			<label for="rec2Email">Email:</label>
			<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec2Email" name="rec2Email"></br>
			<label for="rec3">Recommender 3</label></br>
			<label for="rec3Name">Name:</label>
			<input type="text" id="rec3Name" onkeypress="return (event.charCode > 64 && 
				event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)" maxLength = "255" name="rec3Name"></br>
			<label for="rec3Email">Email:</label>
			<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" id="rec3Email" name="rec3Email"></br>
		</div>
		<?php
			}
			
			else {
			   $query = "SELECT * FROM applicant where uid = ".$uid;
			   $data = mysqli_query($dbc, $query);
			   $row = mysqli_fetch_array($data); 
			   ?>
		<h1>Application</h1>
		<dl class="row">
			<dt class="col-sm-3">Application Status</dt>
			<dd class="col-sm-9"><?php echo $_POST['category'];?></dd>
			<dt class="col-sm-3">Degree Program</dt>
			<dd class="col-sm-9"><?php if ($row['degProgram'] == "md") {
				echo 'MD<br/>';
				}
				else {
				echo 'PHD<br/>';
				} ?></dd>
			<dt class="col-sm-3">Admission Semester/Year</dt>
			<dd class="col-sm-9"><?php echo $row['admissionSemester']." ".$row['admissionYear']; ?></dd>
			<dt class="col-sm-3">Areas of Interest</dt>
			<dd class="col-sm-9"><?php echo $row['aoi']; ?></dd>
			<dt class="col-sm-3">Transcript Link</dt>
			<dd class="col-sm-9"><?php echo $row['transcript']; ?></dd>
			<?php 
				if (!($row['appExp'] == NULL)) {
				?>
			<dt class="col-sm-3">Experience</dt>
			<dd class="col-sm-9"><?php echo $row['appExp']; ?></dd>
			<?php }
				$degQuery = "SELECT * FROM degree WHERE uid = ".$row['uid'];
				$degData = mysqli_query($dbc, $degQuery);
				$degCount = 1;
				
				while ($degRow = mysqli_fetch_array($degData)) {
				    ?>
			<dt class="col-sm-3">Degree <?php echo $degCount; ?></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-4">Type of Degree</dt>
					<dd class="col-sm-8"><?php echo $degRow['degType']; ?></dd>
					<dt class="col-sm-4">Issuing University</dt>
					<dd class="col-sm-8"><?php echo $degRow['school']; ?></dd>
					<dt class="col-sm-4">GPA</dt>
					<dd class="col-sm-8"><?php echo $degRow['gpa']; ?></dd>
					<dt class="col-sm-4">Field of Study</dt>
					<dd class="col-sm-8"><?php echo $degRow['major']; ?></dd>
					<dt class="col-sm-4">Year Graduating</dt>
					<dd class="col-sm-8"><?php echo $degRow['yearGrad']; ?></dd>
				</dl>
			</dd>
			<?php
				$degCount++;
				}
				
				?>
			<?php
				$examQuery = 'select * from examScore where uid = '.$row['uid'].' and examSubject != "total" and examSubject != "verbal" and examSubject != "quantitative" order by examSubject asc';				
				$examData = mysqli_query($dbc, $examQuery);
				$examCount = 1;
				
				$queryEQ = 'select * from examScore where uid = '.$row['uid'].' and examSubject = "quantitative"';				
				            $dataEQ = mysqli_query($dbc, $queryEQ); 
				            if ($rowEQ = mysqli_fetch_array($dataEQ)) { //if there is a GRE			
				                $queryEV = 'select * from examScore where uid = '.$row['uid'].' and examSubject = "verbal"';				
				                $dataEV = mysqli_query($dbc, $queryEV);
				                $rowEV = mysqli_fetch_array($dataEV);
				                $queryET = 'select * from examScore where uid = '.$row['uid'].' and examSubject = "total"';				
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
				
				while ($examRow = mysqli_fetch_array($examData)) {
				?>
			<dt class="col-sm-3">Exam <?php echo $examCount; ?></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-4">Subject</dt>
					<dd class="col-sm-8"><?php echo $examRow['examSubject']; ?></dd>
					<dt class="col-sm-4">Score</dt>
					<dd class="col-sm-8"><?php echo $examRow['score']; ?></dd>
					<dt class="col-sm-4">Year Taken</dt>
					<dd class="col-sm-8"><?php echo $examRow['yearTake']; ?></dd>
				</dl>
			</dd>
			<?php
				$examCount++;
				}
				
				
				$recQuery = "SELECT * FROM recs WHERE uid = ".$row['uid'];
				$recData = mysqli_query($dbc, $recQuery);
				$count = 1;
				
				while ($recRow = mysqli_fetch_array($recData)) {
				?>
			<dt class="col-sm-3">Recommendation <?php echo $count; ?></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-4">Recommendation ID</dt>
					<dd class="col-sm-8"><?php echo $recRow['recId']; ?></dd>
					<dt class="col-sm-4">Recommender Email Address</dt>
					<dd class="col-sm-8"><?php echo $recRow['email']; ?></dd>
					<dt class="col-sm-4">Recommender Name</dt>
					<dd class="col-sm-8"><?php echo $recRow['recName']; ?></dd>
					<dt class="col-sm-4">Recommender Job Title</dt>
					<dd class="col-sm-8"><?php echo $recRow['job']; ?></dd>
					<dt class="col-sm-4">Relation to Applicant</dt>
					<dd class="col-sm-8"><?php echo $recRow['relation']; ?></dd>
					<dt class="col-sm-4">Recommender's Organization</dt>
					<dd class="col-sm-8"><?php echo $recRow['org']; ?></dd>
					<dt class="col-sm-4">Content</dt>
					<dd class="col-sm-8"><?php echo $recRow['content']; ?></dd>
				</dl>
			</dd>
			<?php
				$count++;
				}
				
				?>
		</dl>
		<?php       
			if ($_POST['category'] != "Pending review" && $_POST['category'] != "Incomplete") { ?>
		<h1>Reviews</h1>
		<dl class="row">
			<?php
				//THIS ENTIRE SECTION IS ON REVIEW FORMS
				//info from review forms
				$reviewsQuery = "SELECT * FROM reviewForm WHERE studentuid = '$uid'";				
				$reviewsData = mysqli_query($dbc, $reviewsQuery); 
				$reviewCount = 1;
				while ($reviewsRow = mysqli_fetch_array($reviewsData)) {
				
				    $queryFac = "SELECT * FROM staff JOIN people ON staff.uid = people.uid where staff.uid = ".$reviewsRow['uid'];				
				    $dataFac = mysqli_query($dbc, $queryFac);
				    $rowFac = mysqli_fetch_array($dataFac);
				
				    ?>
			<dt class="col-sm-3">Review <?php echo $reviewCount; ?></dt>
			<dd class="col-sm-9">
				<dl class="row">
					<dt class="col-sm-4">Reviewer</dt>
					<dd class="col-sm-8">
						<dl class="row">
							<dt class="col-sm-5">Reviewer Name</dt>
							<dd class="col-sm-7"><?php echo $rowFac['fname']." ".$rowFac['lname']; ?></dd>
							<dt class="col-sm-5">Reviewer Department</dt>
							<dd class="col-sm-7"><?php echo $rowFac['department']; ?></dd>
						</dl>
					</dd>
					<?php 
						$recReviewQuery = "SELECT * FROM recReview WHERE uid = ".$rowFac['uid']." AND studentuid = ".$uid;
						$recReviewData = mysqli_query($dbc, $recReviewQuery);
						$recCount = 1;
						
						while ($recReviewRow = mysqli_fetch_array($recReviewData)) {
						?>
					<dt class="col-sm-4">Recommendation <?php echo $recCount; ?></dt>
					<dd class="col-sm-8">
						<dl class="row">
							<dt class="col-sm-5">Recommendation ID</dt>
							<dd class="col-sm-7"><?php echo $recReviewRow['recId']; ?></dd>
							<dt class="col-sm-5">Rating</dt>
							<dd class="col-sm-7"><?php echo $recReviewRow['rating']; ?></dd>
							<dt class="col-sm-5">Generic</dt>
							<dd class="col-sm-7"><?php if ($recReviewRow['generic'] = 1) echo "Yes"; else echo "No"; ?></dd>
							<dt class="col-sm-5">Credible</dt>
							<dd class="col-sm-7"><?php if ($recReviewRow['credible'] = 1) echo "Yes"; else echo "No"; ?></dd>
						</dl>
					</dd>
					<?php $recCount++; } ?>
					<dt class="col-sm-4">Missing Courses</dt>
					<dd class="col-sm-8"><?php if ($reviewsRow['missingC'] == NULL) echo "None"; else echo $examRow['missingC']; ?></dd>
					<dt class="col-sm-4">Recommended Decision</dt>
					<dd class="col-sm-8"><?php if ($reviewsRow['gas'] == 0) echo "Reject"; else if ($reviewsRow['gas'] == 1) echo "Borderline Admit"; else if ($reviewsRow['gas'] == 2) echo "Admit Without Aid"; else if ($reviewsRow['gas'] == 3) echo "Admit With Aid";?></dd>
					<dt class="col-sm-4">Reason for Rejection</dt>
					<dd class="col-sm-8"><?php if ($reviewsRow['reasonReject'] == NULL) echo "Not Applicable"; else if ($reviewsRow['reasonReject'] == "A") echo "Incomplete Record"; 
						else if ($reviewsRow['reasonReject'] == "B") echo "Does not meet minimum requirements"; else if ($reviewsRow['reasonReject'] == "C") echo "Problem with Letters";
						else if ($reviewsRow['reasonReject'] == "D") echo "Not Competitive"; else if ($reviewsRow['reasonReject'] == "E") echo "Other reasons"; ?></dd>
					<dt class="col-sm-4">Comments</dt>
					<dd class="col-sm-8"><?php if ($reviewsRow['gasComm'] == NULL) echo "None"; else echo $examRow['gasComm']; ?></dd>
				</dl>
			</dd>
			<?php $reviewCount++; } ?>
		</dl>
		<?php
			//person already admitted, change admission advisor
			if ($_POST['category'] == "Admitted with Aid" || $_POST['category'] == "Admitted") { ?>
		<div class = "col-md-20 mb-5">
			<h1>Admission Information</h1>
		</div>
		<div class = "form-group">
			<label for="adv">Advisor </label>
			<select name="adv" class="form-control" required>
				<?php
					$queryAdv = "select adv, fname, lname from applicant join people on applicant.adv = people.uid where applicant.uid = ".$uid;
					$adv = mysqli_query($dbc, $queryAdv);
					$rowAdv = mysqli_fetch_array($adv);
					?>
				<option value="<?php echo $rowAdv['uid'];?>"><?php echo $rowAdv['fname'].' '.$rowAdv['lname'];?></option>
				<?php
					$queryAdv = "select people.uid, people.fname, people.lname from staff join people on people.uid = staff.uid where staff.uid != ".$rowAdv['adv']." and (staff.type = 4 or staff.type = 6 or staff.type = 8 or staff.type = 9)";
					           
					$adv = mysqli_query($dbc, $queryAdv);
					while ($rowAdv = mysqli_fetch_array($adv)) {
					    ?>
				<option value="<?php echo $rowAdv['uid'];?>"><?php echo $rowAdv['fname'].' '.$rowAdv['lname'];?></option>
				<?php
					}
					?>
			</select>
		</div>
		<?php
			}
			//declined, but can change the status back to admitted with aid or no aid, and give advisor
			//can only view app
			if ($_POST['category'] == "Declined") { ?>
		<div class = "col-md-20 mb-5">
			<h1>Admission Information</h1>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="appStatus">Revert Decision</label>
				<select name="appStatus" class="form-control">
					<option value="6">Declined</option>
					<option value="4">Admitted</option>
					<option value="3">Admitted with Aid</option>
				</select>
				<input type="hidden" name="uid" value="<?php echo $uid; ?>">
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="adv">Advisor</label>
				<select name="adv" class="form-control">
					<?php
						$queryAdv = "select people.uid, people.fname, people.lname from staff join people on people.uid = staff.uid where staff.type = 4 or staff.type = 6 or staff.type = 8 or staff.type = 9;";
						            
						$adv = mysqli_query($dbc, $queryAdv);
						while ($rowAdv = mysqli_fetch_array($adv)) {
						    ?>
					<option value="<?php echo $rowAdv['uid'];?>"><?php echo $rowAdv['fname'].' '.$rowAdv['lname'];?></option>
					<?php
						}
						?>
				</select>
			</div>
		</div>
		<?php
			}
			    
			}
			}			
			?>
		<?php    
			}
			//faculty
			else if ($_POST['type'] == "Staff") { 
			    $query = "SELECT * FROM staff where uid = ".$uid;
			    $data = mysqli_query($dbc, $query);
			    $row = mysqli_fetch_array($data); ?>
		<div class = "col-md-20 mb-5">
			<h1>Faculty Information</h1>
		</div>
		<div class="form-row">
			<?php if ($_POST['uid'] != $_SESSION['uid']) {?>
			<div class="form-group col-md-12">
				<label for="role">Type of staff</label>
				<select name="role" class="form-control">
					<option value="0" 
						<?php
							if ($_POST['category'] == "Admin") {
							    echo 'selected';
							}
							?>
						>System Administrator</option>
					<option value="1" 
						<?php
							if ($_POST['category'] == "Graduate Secretary") {
							    echo 'selected';
							}
							?>
						>Graduate Secretary</option>
					<option value="2" 
						<?php
							if ($_POST['category'] == "CAC") {
							    echo 'selected';
							}
							?>
						>CAC staff</option>
					<option value="3" 
						<?php
							if ($_POST['category'] == "Faculty Reviewer") {
							    echo 'selected';
							}
							?>
						>Faculty Reviewer</option>
					<option value="4" 
						<?php
							if ($_POST['category'] == "Faculty Advisor") {
							    echo 'selected';
							}
							?>
						>Faculty Advisor</option>
					<option value="5" 
						<?php
							if ($_POST['category'] == "Faculty Instructor") {
							    echo 'selected';
							}
							?>
						>Faculty Instructor</option>
					<option value="6" 
						<?php
							if ($_POST['category'] == "Faculty Reviewer and Advisor") {
							    echo 'selected';
							}
							?>
						>Faculty Reviewer and Advisor</option>
					<option value="7" 
						<?php
							if ($_POST['category'] == "Faculty Reviewer and Instructor") {
							    echo 'selected';
							}
							?>
						>Faculty Reviewer and Instructor</option>
					<option value="8" 
						<?php
							if ($_POST['category'] == "Faculty Advisor and Instructor") {
							    echo 'selected';
							}
							?>
						>Faculty Advisor and Instructor</option>
					<option value="9" 
						<?php
							if ($_POST['category'] == "Faculty Reviewer, Advisor and Instructor") {
							    echo 'selected';
							}
							?>
						>Faculty Reviewer, Advisor and Instructor</option>
				</select>
			</div>
			<?php } ?>
			<div class="form-group col-md-12">
				<label for="years">Years Working</label>
				<input required name="years" type="text" maxlength="256" value="<?php echo $row['yearsWorking'];?>" placeholder="Enter the years this person has been working for GWU" class="form-control">
			</div>
			<div class="form-group col-md-12">
				<label for="dept">Department</label>
				<input required name="dept" type="text" maxlength="256" value="<?php echo $row['department'];?>" placeholder="Enter the department this person works in" class="form-control">
			</div>
		</div>
		<?php
			}
			?>
		<input type="hidden" name="uid" value="<?php echo $_POST['uid']; ?>">
		<input type="hidden" name="type" value="<?php echo $_POST['type']; ?>">
		<input type="hidden" name="category" value="<?php echo $_POST['category']; ?>">
		<input type="submit" value="Submit" name="submit">
	</form>
	<div class="row">
		<p>
			<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "queueEdit.php">Go Back</a>
		</p>
	</div>
	<br> <br> <br> 
	<?php }else {  ?>
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
		<p class = "lead" >
			<em>
		<center></em></p>
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