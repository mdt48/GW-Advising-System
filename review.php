<?php
    require_once('navBar.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_SESSION['uid'])) {
        $query = "SELECT * FROM staff WHERE uid = '".$_SESSION['uid']."'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) > 0) {
            // user is a staff, allow access to page
            $row = mysqli_fetch_array($data);
            if ($row['type'] == 2 || $row['type'] == 3 || $row['type'] == 6 || $row['type'] == 7 || $row['type'] == 9) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Review an Application</h1>
                            </div>
                        </div>
                    </div>
                </header>
                <?php
                // staff is a reviewer; default case (allowed to review)

                if (isset($_POST['uid'])) {

                $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE people.uid = '".$_POST['uid']."'";
                $data = mysqli_query($dbc, $query);
                $row = mysqli_fetch_array($data);
        

    ?>

<div class="container">
    <form action="submitreview.php" method="POST">
    <h1>Application</h1>

    <dl class="row">

        <dt class="col-sm-3">User Id</dt>
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
        
        <dt class="col-sm-3">Experience</dt>
        <dd class="col-sm-9"><?php echo $row['appExp']; ?></dd>

        <?php

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

$examQuery = "SELECT * FROM examScore WHERE uid = ".$row['uid'];
$examData = mysqli_query($dbc, $examQuery);
$examCount = 1;

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

?>
    
    </dl>

    <h1>Review</h1>

    <?php

    for ($i = 1; $i < $count; $i++) {

    ?>

        <h3>Recommendation <?php echo $i; ?></h3>
        <div class="form-row">
            <div class="form-group col">
                <label for="rating<?php echo $i; ?>">Rating</label>
                <select name="rating<?php echo $i; ?>" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group col">
                <label for="generic<?php echo $i; ?>">Generic</label>
                <select name="generic<?php echo $i; ?>" class="form-control">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="form-group col">
                <label for="credible<?php echo $i; ?>">Credible</label>
                <select name="credible<?php echo $i; ?>" class="form-control">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
        </div>

        <input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
    
    <?php 
    
        }

    ?>

        <h3>Graduate Admissions Committee</h3>

        <div class="form-group">
            <label for="rating">Rating</label>
            <select name="rating" class="form-control">
                <option value="0">Reject</option>
                <option value="1">Borderline Admit</option>
                <option value="2">Admit without Aid</option>
                <option value="3">Admit with Aid</option>
            </select>
        </div>
        <div class="form-group">
            <label for="missingCourses">Missing Courses</label>
            <input name="missingCourses" type="text" class="form-control" placeholder="Missing Classes" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
        </div>
        <div class="form-group">
            <label for="reason">Reason for Rejection (if applicable)</label>
            <select name="reason" class="form-control">
                <option selected value="NULL">N/A</option>
                <option value="A">Incomplete Record</option>
                <option value="B">Does not meet minimum requirements</option>
                <option value="C">Problem with Letters</option>
                <option value="D">Not competitive</option>
                <option value="E">Other reasons</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comments">Reviewer Comments</label>
            <input name="comments" type="text" class="form-control" placeholder="Comments" onkeypress="return (event.charCode > 64 && 
event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit Review</button>
        <br>
        <br>

    </form>
</div>

    <?php

                }

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
        }
        else {
            ?>
            <!-- HEADER -->
            <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                <div class = "container h-100">
                    <div class = "row h-100 align-items-center">
                        <div class = "col-lg-12">
                            <h1 class = "display-4 text-center text-white mt-5 mb-2">Error</h1>
                            <p class = "lead mb-5 text-center text-white-50" id = button>Please select a candidate to review!</p>
                        </div>
                    </div>
                </div>
            </header>
            <?php
        }
    }
    else {
        ?>
        <!-- HEADER -->
        <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
            <div class = "container h-100">
                <div class = "row h-100 align-items-center">
                    <div class = "col-lg-12">
                        <h1 class = "display-4 text-center text-white mt-5 mb-2">Please Login to Access this Page</h1>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }
      mysqli_close($dbc);

    ?>

</body>
</html>