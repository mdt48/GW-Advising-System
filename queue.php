<?php
    require_once('navBar.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $totalRev = 1;
    if (isset($_SESSION['uid'])) {
        $query = "SELECT * FROM staff WHERE uid = '".$_SESSION['uid']."'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) > 0) {
            // user is a staff, allow access to page
            $row = mysqli_fetch_array($data);

            // update all applications if complete
            $updateQuery = "SELECT * FROM applicant WHERE appStatus = 1";
            $updateData = mysqli_query($dbc, $updateQuery);
            while ($updateRow = mysqli_fetch_array($updateData)) {
                if ($updateRow['transcript'] != NULL) {
                    $checkRecsQuery = "Select * from recs where uid = ".$updateRow['uid'];
                    $checkRecsData = mysqli_query($dbc, $checkRecsQuery);
                    $numRecs = mysqli_num_rows($checkRecsData);
                    if ($numRecs > 0) {
                        $checkRecsQuery = "SELECT * from recs where recName is not null and uid = ".$updateRow['uid'];
                        $checkRecsData = mysqli_query($dbc, $checkRecsQuery);
                        if (mysqli_num_rows($checkRecsData) >= $numRecs) {
                            mysqli_query($dbc, "UPDATE applicant SET appStatus = 2 WHERE uid = ".$updateRow['uid']);
                        }
                    }
                }
            }
            //fr
            if ($row['type'] == 3 || $row['type'] == 6 || $row['type'] == 7 || $row['type'] == 9) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
    <div class="container">
    <?php
        $where = "";
        $order = "asc";
        $result = "Currently viewing report all applications order by asc";
        if (isset($_POST['submit'])) {
            $uidP = $_POST['uid'];
            $lname = $_POST['lname'];
            $order = $_POST['order'];
            $by = $_POST['by'];

            $result = "";

            if ($uidP == NULL) $uidSelected = false;
            else $uidSelected = true;

            if ($lname == NULL) $lnameSelected = false;
            else $lnameSelected = true;

            $result = "Currently viewing applications of ";

            //concatenate the query          

            if ($uidSelected == true) {
                $where = $where ." and applicant.uid like '%".$uidP."%'";
                $result = $result."UID is ".$uidP;
            }

            if ($lnameSelected == true) {
                $where = $where ." and lname like '%".$lname."%'";
                if ($uidSelected == true) $result = $result."and last name is ".$lname;
            }

            if ($uidSelected == false && $lnameSelected == false) {
                $where = "";
            }
            $where = $where." order by ".$by." ".$order;
            $result = $result.", order by ".$by." ".$order;
        }
    ?>
    <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input class="form-control mr-sm-2" name="uid" onkeypress = "return (event.charCode > 47 && event.charCode < 58)"  maxlength="7" type="search" placeholder="UID" id= "search_bar" aria-label="Search">
        <input class="form-control mr-sm-2" name="lname" type="search" placeholder="Last Name" id= "search_bar" aria-label="Search" maxlength="255" onkeypress="return (event.charCode > 64 && 
        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)">
        <br><br><br>
        <select name="order" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="asc" selected hidden>Order</option>                 
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>     
        </select>
        <select name="by" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="lname" selected hidden>By</option>                 
            <option value="lname">Last Name</option>
            <option value="appDate">Date</option>     
        </select>
            <input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search">
        </form> 
        
    <b><?php echo $result;?></b>  
    <br>             
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">User Id</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Date Applied</th>
                <th scope="col">Year</th>
                <th scope="col">Semester</th>
                <th scope="col">Program</th>               
                <th scope="col">Number Reviews</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE appStatus = 2 AND applicant.uid NOT IN
            (SELECT studentuid FROM recReview WHERE recReview.uid = ".$_SESSION['uid'].") ".$where;
        $data = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($data)) {    
            $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentuid = ".$row['uid'];
            $subdata = mysqli_query($dbc, $sub);
            $subrow = mysqli_fetch_array($subdata);
        ?>
            <form method="POST" action="review.php">
                <tr>
                    <th scope="row"><?php echo $row['uid']; ?>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['appDate']; ?></td>
                    <td><?php echo $row['admissionYear']; ?></td>
                    <td><?php echo $row['admissionSemester']; ?></td>
                    <td><?php if ($row['degProgram'] == "md") echo "Masters"; else echo "PhD"; ?></td>                   
                    <td><?php echo $subrow['count']; ?></td>
                    <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"></td>
                    <td><button type="submit" name="review" class="btn btn-primary">Review</button></td>
                </tr>
            </form>
            <?php
        }
        ?>
        </tbody>
    </table>
    
    <a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
    </div>

    <?php

            }
            //gs
            else if ($row['type'] == 1) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
    <div class="container">
    <?php
        $where = " (appStatus = 2 OR appStatus = 1) ";
        $order = "asc";
        $result = "Currently viewing results of all programs, all semesters, and all years, order by asc";
        if (isset($_POST['submit'])) {
            $program = $_POST['program'];
            $semester = $_POST['sem'];
            $year = $_POST['year'];
            $uidP = $_POST['uid'];
            $lname = $_POST['lname'];
            $status = $_POST['status'];
            $order = $_POST['order'];
            $by = $_POST['by'];

            if ($program == "Program" || $program == "all") $programSelected = false;
            else $programSelected = true;

            if ($semester == "Semester" || $semester == "all") $semesterSelected = false;
            else $semesterSelected = true;
            
            if ($year == NULL) $yearSelected = false;
            else $yearSelected = true;

            if ($uidP == NULL) $uidSelected = false;
            else $uidSelected = true;

            if ($lname == NULL) $lnameSelected = false;
            else $lnameSelected = true;

            if ($status == NULL || $status == "all") $statusSelected = false;
            else $statusSelected = true;

            $result = "Currently viewing results of ";


            if ($statusSelected == false) $where = " (appStatus = 2 OR appStatus = 1) ";
            else {
                if ($status == "i") $where = "appStatus = 1 ";
                else $where = "appStatus = 2 ";
            }

            //concatenate the query                    
            if ($programSelected == true) {
                $where = $where."and degProgram = '".$program."'";
                $result = $result.$program." program, ";
            }
            else $result = $result."all programs, ";

            if ($semesterSelected == true) {
                $where = $where ." and admissionSemester = '".$semester."'";
                $result = $result.$semester." semester, ";
            }
            else $result = $result."all semesters, ";

            if ($yearSelected == true) {
                $where = $where ." and admissionYear = ".$year;
                $result = $result."from ".$year;
            }
            else $result = $result."from all years";

            if ($uidSelected == true) {
                $where = $where ." and applicant.uid like '%".$uidP."%'";
                $result = $result.", UID is ".$uidP;
            }

            if ($lnameSelected == true) {
                $where = $where ." and lname like '%".$lname."%'";
                $result = $result.", last name is ".$lname;
            }

            $where = $where." order by ".$by." ".$order;
            $result = $result.", order by ".$by." ".$order;
        }
    ?>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <select name="program" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search">        
            <option selected hidden>Program</option>                
            <option value="all">All</option>                
            <option value="md">MD</option>
            <option value="phd">PHD</option>    
        </select>
        <select name="sem" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option selected hidden>Semester</option>               
            <option value="all">All</option>                          
            <option value="fall">Fall</option>
            <option value="spring">Spring</option>     
        </select>
        <input class="form-control mr-sm-2" name="year" type="search" placeholder="Year" id= "search_bar" aria-label="Search">
        <input class="form-control mr-sm-2" name="uid" onkeypress = "return (event.charCode > 47 && event.charCode < 58)"  maxlength="7" type="search" placeholder="UID" id= "search_bar" aria-label="Search">
        <input class="form-control mr-sm-2" name="lname" type="search" placeholder="Last Name" id= "search_bar" aria-label="Search" maxlength="255" onkeypress="return (event.charCode > 64 && 
        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)">
        <br><br><br>
        <select name="status" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="all" selected hidden>Status</option>                 
            <option value="all">All</option>                 
            <option value="c">Complete</option>
            <option value="i">Incomplete</option>     
        </select>
        <select name="order" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="asc" selected hidden>Order</option>                 
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>     
        </select>
        <select name="by" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="lname" selected hidden>By</option>                 
            <option value="lname">Last Name</option>
            <option value="appDate">Date</option>     
        </select>
            <input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search">
        </form> 
        <br>
        
    <b><?php echo $result;?><br></b>
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">User Id</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Date Applied</th>
            <th scope="col">Year</th>
            <th scope="col">Semester</th>
            <th scope="col">Program</th>
            <th scope="col">Application Status</th>
            <th scope="col">Number Reviews</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid where ".$where;
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentuid = ".$row['uid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);
    ?>
        <tr>
            <th scope="row"><?php echo $row['uid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['appDate']; ?></td>
            <td><?php echo $row['admissionYear']; ?></td>
            <td><?php echo $row['admissionSemester']; ?></td>
            <td><?php if ($row['degProgram'] == "md") echo "Masters"; else echo "PhD"; ?></td>
            <td><?php if ($row['appStatus'] == 1) echo "Incomplete"; else echo "Complete"; ?></td>
            <td><?php echo $subrow['count']; ?></td>
            <form method="POST" action="editAcademic.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
            <button type="submit" name="update" class="btn btn-primary">Update</button></td>
            </form>
            <?php
                if ($subrow['count'] >= 1) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php }
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
            </form>
            <?php } ?>
        </tr>
        
    
    <?php    
    }       
    ?>
    </tbody>
    </table>
    
    <a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
    </div> 
    <?php
            }
            //admin
            else if ($row['type'] == 0) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
        
         
		  
    <div class="container">  
    <?php
        $where = " (appStatus = 2 OR appStatus = 1) ";
        $order = "asc";
        $result = "Currently viewing results of all programs, all semesters, and all years, order by asc";
        if (isset($_POST['submit'])) {
            $program = $_POST['program'];
            $semester = $_POST['sem'];
            $year = $_POST['year'];
            $uidP = $_POST['uid'];
            $lname = $_POST['lname'];
            $status = $_POST['status'];
            $order = $_POST['order'];
            $by = $_POST['by'];

            if ($program == "Program" || $program == "all") $programSelected = false;
            else $programSelected = true;

            if ($semester == "Semester" || $semester == "all") $semesterSelected = false;
            else $semesterSelected = true;
            
            if ($year == NULL) $yearSelected = false;
            else $yearSelected = true;

            if ($uidP == NULL) $uidSelected = false;
            else $uidSelected = true;

            if ($lname == NULL) $lnameSelected = false;
            else $lnameSelected = true;

            if ($status == NULL || $status == "all") $statusSelected = false;
            else $statusSelected = true;

            $result = "Currently viewing results of ";


            if ($statusSelected == false) $where = " (appStatus = 2 OR appStatus = 1) ";
            else {
                if ($status == "i") $where = "appStatus = 1 ";
                else $where = "appStatus = 2 ";
            }

            //concatenate the query                    
            if ($programSelected == true) {
                $where = $where."and degProgram = '".$program."'";
                $result = $result.$program." program, ";
            }
            else $result = $result."all programs, ";

            if ($semesterSelected == true) {
                $where = $where ." and admissionSemester = '".$semester."'";
                $result = $result.$semester." semester, ";
            }
            else $result = $result."all semesters, ";

            if ($yearSelected == true) {
                $where = $where ." and admissionYear = ".$year;
                $result = $result."from ".$year;
            }
            else $result = $result."from all years";

            if ($uidSelected == true) {
                $where = $where ." and applicant.uid like '%".$uidP."%'";
                $result = $result.", UID is ".$uidP;
            }

            if ($lnameSelected == true) {
                $where = $where ." and lname like '%".$lname."%'";
                $result = $result.", last name is ".$lname;
            }

            $where = $where." order by ".$by." ".$order;
            $result = $result.", order by ".$by." ".$order;
        }
    ?>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <select name="program" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search">        
            <option selected hidden>Program</option>                
            <option value="all">All</option>                
            <option value="md">MD</option>
            <option value="phd">PHD</option>    
        </select>
        <select name="sem" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option selected hidden>Semester</option>               
            <option value="all">All</option>                          
            <option value="fall">Fall</option>
            <option value="spring">Spring</option>     
        </select>
        <input class="form-control mr-sm-2" name="year" type="search" placeholder="Year" id= "search_bar" aria-label="Search">
        <input class="form-control mr-sm-2" name="uid" onkeypress = "return (event.charCode > 47 && event.charCode < 58)"  maxlength="7" type="search" placeholder="UID" id= "search_bar" aria-label="Search">
        <input class="form-control mr-sm-2" name="lname" type="search" placeholder="Last Name" id= "search_bar" aria-label="Search" maxlength="255" onkeypress="return (event.charCode > 64 && 
        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)">
        <br><br><br>
        <select name="status" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="all" selected hidden>Status</option>                 
            <option value="all">All</option>                 
            <option value="c">Complete</option>
            <option value="i">Incomplete</option>     
        </select>
        <select name="order" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="asc" selected hidden>Order</option>                 
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>     
        </select>        
        <select name="by" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="lname" selected hidden>By</option>                 
            <option value="lname">Last Name</option>
            <option value="appDate">Date</option>     
        </select>
            <input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search">
        </form> 
        <br>
        
    <b><?php echo $result;?><br></b>
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">User Id</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Date Applied</th>
            <th scope="col">Year</th>
            <th scope="col">Semester</th>
            <th scope="col">Program</th>
            <th scope="col">Application Status</th>
            <th scope="col">Number Reviews</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid where ".$where;
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentuid = ".$row['uid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);

        $reviewedSub = "SELECT * FROM reviewForm WHERE studentuid = ".$row['uid']." AND uid = ".$_SESSION['uid'];
        $reviewedData = mysqli_query($dbc, $reviewedSub);
    ?>
        <tr>
            <th scope="row"><?php echo $row['uid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['appDate']; ?></td>
            <td><?php echo $row['admissionYear']; ?></td>
            <td><?php echo $row['admissionSemester']; ?></td>
            <td><?php if ($row['degProgram'] == "md") echo "Masters"; else echo "PhD"; ?></td>
            <td><?php if ($row['appStatus'] == 1) echo "Incomplete"; else echo "Complete"; ?></td>
            <td><?php echo $subrow['count']; ?></td>
            <form method="POST" action="editAcademic.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
            <button type="submit" name="update" class="btn btn-primary">Update</button></td>
            </form>
            
            <?php if (mysqli_num_rows($reviewedData) == 0) {
                if ($row['appStatus'] == 1) {
                ?>
                <form method="POST" action="review.php">
                <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary" disabled>Review</button></td>
                </form>
            <?php }
            else {
                ?>
                <form method="POST" action="review.php">
                <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary">Review</button></td>
                </form>
                <?php
            }
                }
                else {
                    ?>
                    <form method="POST" action="review.php">
                    <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary" disabled>Review</button></td>
                    </form>
                    <?php }
             
                if ($subrow['count'] >= 1) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php }
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
            </form>
            <?php } ?>
        </tr>
        
    
    <?php    
    }       
    ?>
    </tbody>
    </table>
    
    <a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
    </div> 
    <?php
            }
            //cac
            else if ($row['type'] == 2) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
                <?php
                // staff is cac; can make decision if application is ready

    ?>

    <div class="container">
    <?php
        $where = "";
        $order = "asc";
        $result = "Currently viewing report all applications order by asc";
        if (isset($_POST['submit'])) {
            $uidP = $_POST['uid'];
            $lname = $_POST['lname'];
            $order = $_POST['order'];
            $by = $_POST['by'];

            $result = "";

            if ($uidP == NULL) $uidSelected = false;
            else $uidSelected = true;

            if ($lname == NULL) $lnameSelected = false;
            else $lnameSelected = true;

            $result = "Currently viewing applications of ";

            //concatenate the query          

            if ($uidSelected == true) {
                $where = $where ." and applicant.uid like '%".$uidP."%'";
                $result = $result."UID is ".$uidP;
            }

            if ($lnameSelected == true) {
                $where = $where ." and lname like '%".$lname."%'";
                if ($uidSelected == true) $result = $result."and last name is ".$lname;
            }

            if ($uidSelected == false && $lnameSelected == false) {
                $where = "";
            }
            
            $where = $where." order by ".$by." ".$order;
            $result = $result.", order by ".$by." ".$order;
        }
    ?>
    <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <input class="form-control mr-sm-2" name="uid" onkeypress = "return (event.charCode > 47 && event.charCode < 58)"  maxlength="7" type="search" placeholder="UID" id= "search_bar" aria-label="Search">
        <input class="form-control mr-sm-2" name="lname" type="search" placeholder="Last Name" id= "search_bar" aria-label="Search" maxlength="255" onkeypress="return (event.charCode > 64 && 
        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)">
        <br><br><br>
        <select name="order" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="asc" selected hidden>Order</option>                 
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>     
        </select>
        <select name="by" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
            <option value="lname" selected hidden>By</option>                 
            <option value="lname">Last Name</option>
            <option value="appDate">Date</option>     
        </select>
            <input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search">
        </form> 
        
    <b><?php echo $result;?></b>  
    <br>      
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">User Id</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Date Applied</th>
            <th scope="col">Year</th>
            <th scope="col">Semester</th>
            <th scope="col">Program</th>
            <th scope="col">Number Reviews</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE appStatus = 2 ".$where;
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentuid = ".$row['uid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);
        
        $reviewedSub = "SELECT * FROM reviewForm WHERE studentuid = ".$row['uid']." AND uid = ".$_SESSION['uid'];
        $reviewedData = mysqli_query($dbc, $reviewedSub);
    ?>
        <tr>
            <th scope="row"><?php echo $row['uid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['appDate']; ?></td>
            <td><?php echo $row['admissionYear']; ?></td>
            <td><?php echo $row['admissionSemester']; ?></td>
            <td><?php if ($row['degProgram'] == "md") echo "Masters"; else echo "PhD"; ?></td>
            <td><?php echo $subrow['count']; ?></td>
            <?php if (mysqli_num_rows($reviewedData) == 0) {?>
            <form method="POST" action="review.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary">Review</button></td>
            </form>
            <?php
                }
                else {
                    ?>
                    <form method="POST" action="review.php">
                    <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary" disabled>Review</button></td>
                    </form>
                    <?php }
                if ($subrow['count'] >= 1) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php } 
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
            </form>
            <?php } ?>
        </tr>
        
    
    <?php
    
    }
                
    ?>
    </tbody>
    </table>
    
    <a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
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