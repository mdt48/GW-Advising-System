<?php
require_once ('navBar.php');

if (!isset($_SESSION['uid']))
{
?>
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

	<?php
}
else
{
    $uidFac = $_SESSION['uid'];

    $uid = $_POST['uid']; 

    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $query = "select type from staff where uid = '$uidFac'";

    $data = mysqli_query($dbc, $query);

    if (mysqli_num_rows($data) == 1)
    {
        $row = mysqli_fetch_array($data);
    }

    if ($row['type'] == 1 || $row['type'] == 0 || $row['type'] == 2) 
    {
        // User is staff, allow to access page
        // Check if submit is activated to set decision
        if (isset($_POST['submit'])) {

            $date = date('Y-m-d');
            // Update application with final decision
            $decisionQuery = "UPDATE applicant SET appStatus = ".$_POST['appStatus'].", adv = ".$_POST['adv'].", accDate = '".$date."' WHERE uid = ".$_POST['uid'];
            $decisionData = mysqli_query($dbc, $decisionQuery);
            header('Location: queue.php');

        }

    if (isset($_POST['uid'])) {

        ?>
        <!-- HEADER -->
        <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
            <div class = "container h-100">
                <div class = "row h-100 align-items-center">
                    <div class = "col-lg-12">
                        <h1 class = "display-4 text-center text-white mt-5 mb-2">Make Decision</h1>
                    </div>
                </div>
            </div>
        </header>
        <div class = "container">
    <?php   

        //THIS ENTIRE SECTION IS ON THE APPLICANT'S INFORMATION

        $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE people.uid = '".$_POST['uid']."'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);

        ?>

<h1>Application</h1>

<dl class="row">

    <dt class="col-sm-3">User ID</dt>
    <dd class="col-sm-9"><?php echo $row['uid']; ?></dd>

    <dt class="col-sm-3">First Name</dt>
    <dd class="col-sm-9"><?php echo $row['fname']; ?></dd>

    <dt class="col-sm-3">Last Name</dt>
    <dd class="col-sm-9"><?php echo $row['lname']; ?></dd>

    <dt class="col-sm-3">Email Address</dt>
    <dd class="col-sm-9"><?php echo $row['email']; ?></dd>

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
    <input type="hidden" name="rec<?php echo $recRow['recId']; ?>" value="<?php echo $recRow['recId']; ?>">

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
        <h1>Average</h1>

        <dl class="row">
        <?php
            $reviewsQuery = "SELECT distinct recId FROM recReview WHERE studentuid = '$uid'";				
            $reviewsData = mysqli_query($dbc, $reviewsQuery); 
            $avgCount = 1;
            while ($recReviewRow = mysqli_fetch_array($reviewsData) ) {
                $avgQ = "select avg(generic) as generic, avg(credible) as credible, round(avg(rating), 2) as rating from recReview where recId = ".$recReviewRow['recId'];
                $avgD = mysqli_query($dbc, $avgQ);
                $avgRow = mysqli_fetch_array($avgD);
            ?>
            <dt class="col-sm-4">Recommendation <?php echo $avgCount; ?></dt>
                    <dd class="col-sm-8">
                        <dl class="row">

                            <dt class="col-sm-5">Rating</dt>
                            <dd class="col-sm-7"><?php echo $avgRow['rating']; ?></dd>

                            <dt class="col-sm-5">Generic</dt>
                            <dd class="col-sm-7"><?php if ($avgRow['generic'] >= 0.6) echo "Yes"; else echo "No"; ?></dd>
                            
                            <dt class="col-sm-5">Credible</dt>
                            <dd class="col-sm-7"><?php if ($avgRow['credible'] >= 0.6) echo "Yes"; else echo "No"; ?></dd>
                            

                        </dl>
                    </dd>
                    
        <?php $avgCount++; } ?>
        <dt class="col-sm-4">Recommended Decision</dt>
                    <dd class="col-sm-8">
                        <dl class="row">
                            <?php                
                            $reviewsQuery = "SELECT avg(gas) as gas FROM reviewForm WHERE studentuid = '$uid'";				
                            $reviewsData = mysqli_query($dbc, $reviewsQuery); 
                            $recReviewRow = mysqli_fetch_array($reviewsData);
                            ?>
                            <dd class="col-sm-7">
                                <?php 
                                if ($recReviewRow['gas'] <= 0.6) {
                                    echo 'Reject';
                                }
                                else if ($recReviewRow['gas'] <= 1.5) {
                                    echo 'Borderline Admit';
                                }
                                else if ($recReviewRow['gas'] <= 2.5) {
                                    echo 'Admit without Aid';
                                }
                                else if ($recReviewRow['gas'] <= 3) {
                                    echo 'Admit with Aid';
                                }?></dd>
                        </dl>
                    </dd>
        </d1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-12">
                
                    <label for="appStatus">Final Decision</label>
                    <select name="appStatus" class="form-control">
                        <option value="5" selected>Reject</option>
                        <option value="4">Admitted</option>
                        <option value="3">Admitted with Aid</option>
                    </select>
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">

                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                
                    <label for="adv">Advisor (if admitted)</label>
                    <select name="adv" class="form-control" required>
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
                    <input type="hidden" name="uid" value="<?php echo $uid; ?>">

                </div>

            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit Decision</button>
            
        </form>
        <?php

        ?>
        </div>
        <div class="row">	<p>
				<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "queue.php">Go Back</a></p> </div>
		<br> <br> <br>
        <?php
    }
    else {
        ?>
        <!-- HEADER -->
        <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
            <div class = "container h-100">
                <div class = "row h-100 align-items-center">
                    <div class = "col-lg-12">
                        <h1 class = "display-4 text-center text-white mt-5 mb-2">Error</h1>
                        <p class = "lead mb-5 text-center text-white-50" id = button>Please select a candidate to update the decision!</p>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }

	?>

</div>
	
<?php
}
    else {
        ?>
        <!-- HEADER -->
        <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
            <div class = "container h-100">
                <div class = "row h-100 align-items-center">
                    <div class = "col-lg-12">
                        <h1 class = "display-4 text-center text-white mt-5 mb-2">Forbidden</h1>
                        <p class = "lead mb-5 text-center text-white-50" id = button>You don't have access to this page!</p>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }
} ?>

</body>
</html>