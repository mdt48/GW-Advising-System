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

$subj7 = mysqli_real_escape_string($dbc,$_POST['subj7']);
$subjScore7 = mysqli_real_escape_string($dbc,$_POST['subjScore7']);
$subjYearTaken7 = mysqli_real_escape_string($dbc,$_POST['subjYearTaken7']);
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


$uid = $_SESSION['uid'];

if (isset($_POST['submit']))
{
    
    //INSERT
    if ($result = $dbc->query("SELECT uid FROM people WHERE uid = '$uid'"))
    {
        $usersql = "UPDATE people SET fname = '$fname', lname = '$lname', ssn = '$SSN', birthDate = '$birthdate', address = '$addr' WHERE uid = '$uid'";
        if (mysqli_query($dbc, $usersql) == false)
        {
            echo "info was not inserted into user, please try again";
        }
    }
    //APPLICANT
    $applicantsql = "INSERT INTO applicant (uid, aoi, appExp, admissionYear, admissionSemester, degProgram, appStatus, transcript) VALUES ('$uid', '$aoi', '$workExp', '$appYear', '$appSem', '$program', '1', '0')";
    if (mysqli_query($dbc, $applicantsql) == false)
    {
        echo "info was not inserted into user, please try again";
    }
    else {
        //GRE
        if (is_null('$total'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $gretotalsql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', 'total', '$total', '$greYearTaken')";
            $dbc->query($gretotalsql);
        }
        
        if (is_null('$verbal'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $greverbalsql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', 'verbal', '$verbal', '$greYearTaken')";
            $dbc->query($greverbalsql);
        }
   
        if (is_null('$quant'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $grequantsql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', 'quantitative', '$quant', '$greYearTaken')";
            $dbc->query($grequantsql);
        }
        //GRE SUBJECTS
        if (is_null('$subj1') || is_null('$subjScore1'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj1sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj1', '$subjScore1', '$subjYearTaken1')";
            $dbc->query($subj1sql);
        }
        
        if (is_null('$subj2') || is_null('$subjScore2'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj2sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj2', '$subjScore2', '$subjYearTaken2')";
            $dbc->query($subj2sql);
        }
        
        if (is_null('$subj3') || is_null('$subjScore3'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj3sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj3', '$subjScore3', '$subjYearTaken3')";
            $dbc->query($subj3sql);
    
        }
        if (is_null('$subj4') || is_null('$subjScore4'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj4sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj4', '$subjScore4', '$subjYearTaken4')";
            $dbc->query($subj4sql);
        }
        if (is_null('$subj5') || is_null('$subjScore5'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj5sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj5', '$subjScore5', '$subjYearTaken5')";
            $dbc->query($subj5sql);
        }


        if (is_null('$subj6') || is_null('$subjScore6'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj6sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj6', '$subjScore6', '$subjYearTaken6')";
            $dbc->query($subj6sql);
        }

        if (is_null('$subj7') || is_null('$subjScore7'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $subj7sql = "INSERT INTO examScore (uid, examSubject, score, yearTake) VALUES ('$uid', '$subj7', '$subjScore7', '$subjYearTaken7')";
            $dbc->query($subj7sql);
        }

        //PRIOR DEGREE
        if (is_null('$pdMajor1') || is_null('$pdGPA1') || is_null('$pdCollege1'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $pd1sql = "INSERT INTO degree (uid, degType, school, gpa, major, yearGrad) VALUES ('$uid', '$pdType1', '$pdCollege1', '$pdGPA1', '$pdMajor1', '$pdYear1')";
            $dbc->query($pd1sql);
        }

        if (is_null('$pdMajor2') || is_null('$pdGPA2') || is_null('$pdCollege2'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $pd2sql = "INSERT INTO degree (uid, degType, school, gpa, major, yearGrad) VALUES ('$uid', '$pdType2', '$pdCollege2', '$pdGPA2', '$pdMajor2', '$pdYear2')";
            $dbc->query($pd2sql);
        }
        //Recs
        
        if (is_null('$recs1Email'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $rec1sql = "INSERT INTO recs (uid, email) VALUES ('$uid', '$rec1Email')";
            if (mysqli_query($dbc, $rec1sql) == false)
            {
                echo "rec1 was not inserted into recs, please try again";
            }
            else {
                $result = $dbc->query("SELECT recId FROM recs WHERE uid = '$uid' AND email = '$rec1Email'");
                $row = $result->fetch_object();
                $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp1-git-happens/git-happens/recommendation.html";
                mail($rec1Email, "GW Graduate Program Letter of Recommendation Request", $msg);
            }
        }

        if (is_null('$recs2Email'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $rec2sql = "INSERT INTO recs (uid, email) VALUES ('$uid', '$rec2Email')";
            if (mysqli_query($dbc, $rec2sql) == false)
            {
                echo "rec2 was not inserted into recs, please try again";
            }
            else {
                $result = $dbc->query("SELECT recId FROM recs WHERE uid = '$uid' AND email = '$rec2Email'");
                $row = $result->fetch_object();
                $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId . ". Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp1-git-happens/git-happens/recommendation.html";
                mail($rec2Email, "GW Graduate Program Letter of Recommendation Request", $msg);
            }
        }

        if (is_null('$recs3Email'))
        {
            echo "this entry/part of the entry is empty, not added to table";
        }
        else
        {
            $rec3sql = "INSERT INTO recs (uid, email) VALUES ('$uid', '$rec3Email')";
            if (mysqli_query($dbc, $rec3sql) == false)
            {
                echo "rec1 was not inserted into recs, please try again";
            }
            else {
                $result = $dbc->query("SELECT recId FROM recs WHERE uid = '$uid' AND email = '$rec2Email'");
                $row = $result->fetch_object();
                $msg = "You have been asked to send a recommendation letter for " . $fname . " " . $lname . ". Your recID is " . $row->recId .  "Please click on the link to fill out the recommendation form." . "http://gwupyterhub.seas.gwu.edu/~sp20DBp1-git-happens/git-happens/recommendation.html";
                mail($rec3Email, "GW Graduate Program Letter of Recommendation Request", $msg);
            }
        }
    }
    echo "<script>window.location.href='index.php';</script>";
    exit;
    mysqli_close($dbc);
}
?>
