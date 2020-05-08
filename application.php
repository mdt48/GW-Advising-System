<?php
session_start();
require_once ('connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//peopleAL INFORMATION (USER TABLE)
$fname = mysqli_real_escape_string($dbc, $_POST['fname']);
$lname = mysqli_real_escape_string($dbc,$_POST['lname']);
$SSN = mysqli_real_escape_string($dbc,$_POST['SSN']);
$birthdate = mysqli_real_escape_string($dbc,$_POST['birthdate']);
$addr = mysqli_real_escape_string($dbc,$_POST['addr']);
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

$flag = true;

$uid = $_SESSION['uid'];

if (isset($_POST['submit']))
{    
    //INSERT
    if ($result = $dbc->query("SELECT uid FROM people WHERE uid = '$uid'"))
    {
        $usersql = "UPDATE people SET fname = '$fname', lname = '$lname', ssn = '$SSN', birthDate = '$birthdate', address = '$addr' WHERE uid = '$uid'";
        if (mysqli_query($dbc, $usersql) == false)
        {   
            $flag = false;
        }
    }

    //APPLICANT   
    if ($transcript != NULL && $rec1Email == NULL && $rec2Email == NULL && $rec3Email == NULL) $status = 2;
    else $status = 1;

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
                $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/sp20DBp2-git-good/git-good/recommendation.html";
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
                $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp2-git-good/git-good/recommendation.html";
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
                $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/sp20DBp2-git-good/git-good/recommendation.html";
                mail($rec3Email, "GW Graduate Program Letter of Recommendation Request", $msg);
            }
        }
    }
    if ($flag == true) echo "<script>window.location.href='index.php';</script>";
    mysqli_close($dbc);
}
?>
