<?php
    require_once('navBar.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_SESSION['uid'])) {
        $query = "SELECT * FROM staff WHERE uid = '".$_SESSION['uid']."'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) > 0) {
            
            // user is a staff, allow access to page
            $row = mysqli_fetch_array($data);
            // user is a staff, allow access to page
            if ($row['type'] == 0 || $row['type'] == 1) {
                ?>
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Statistics</h1>
                            </div>
                        </div>
                    </div>
                </header>
                
                <div class="container">
                <?php
                    $where = "";
                    $result = "Currently viewing report of all programs, all semesters, and all years";
                    if (isset($_POST['submit'])) {
                        $program = $_POST['program'];
                        $semester = $_POST['sem'];
                        $year = $_POST['year'];

                        $where = "where ";
                        $result = "";

                        if ($program == "Program" || $program == "all") $programSelected = false;
                        else $programSelected = true;

                        if ($semester == "Semester" || $semester == "all") $semesterSelected = false;
                        else $semesterSelected = true;
                        
                        if ($year == NULL) $yearSelected = false;
                        else $yearSelected = true;

                        $result = "Currently viewing report of ";

                        //concatenate the query                    
                        if ($programSelected == true) {
                            $where = $where." degProgram = '".$program."'";
                            $result = $result.$program." program, ";
                        }
                        else $result = $result."all programs, ";

                        if ($semesterSelected == true) {
                            if ($programSelected == true) {
                                $where = $where ." and admissionSemester = '".$semester."'";
                            }
                            else {
                                $where = $where." admissionSemester = '".$semester."'";
                            }
                            $result = $result.$semester." semester, ";
                        }
                        else $result = $result."all semesters, ";

                        if ($yearSelected == true) {
                            if ($semesterSelected == true || $programSelected == true) {
                                $where = $where ." and admissionYear = ".$year;
                            }
                            else {
                                $where = $where." admissionYear = ".$year;
                            }                            
                            $result = $result."from ".$year.".";
                        }
                        else $result = $result."from all years.";

                        if ($yearSelected == false && $semesterSelected == false && $programSelected == false) {
                            $where = "";
                        }
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
                    <!--<input class="form-control mr-sm-2" name="uid" onkeypress = "return (event.charCode > 47 && event.charCode < 58)"  maxlength="7" type="search" placeholder="UID" id= "search_bar" aria-label="Search">
                    <input class="form-control mr-sm-2" name="lname" type="search" placeholder="Last Name" id= "search_bar" aria-label="Search" maxlength="255" onkeypress="return (event.charCode > 64 && 
			        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)">
                    <br><br><br>
                    <select name="order" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
                        <option selected hidden>Order</option>                 
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>     
                    </select>-->
                        <input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search">
                    </form> 
                <br>
                <b><?php echo $result;?></b>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Total Applicants</th>
                            <th scope="col">Total Admitted</th>
                            <th scope="col">Total Rejected</th>
                            <th scope="col">Average GRE Applicants</th>
                            <th scope="col">Average GRE Admitted</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
            //total applicants
            $queryT = "select count(*) as total from applicant ".$where;
            $dataT = mysqli_query($dbc, $queryT);
            $rowT = mysqli_fetch_array($dataT);
            
            //total admitted
            if ($where == "") {
                $spec = "where appStatus = 3 or appStatus = 4";
            }
            else {
                $spec = $where." and (appStatus = 3 or appStatus = 4)";
            }
            $queryTA= "select count(*) as total from applicant ".$spec;
            $dataTA = mysqli_query($dbc, $queryTA);
            $rowTA = mysqli_fetch_array($dataTA);

            //total rejected
            if ($where == "") {
                $spec = "where appStatus = 5";
            }
            else {
                $spec = $where." and appStatus = 5";
            }
            $queryTR= "select count(*) as total from applicant ".$spec;
            $dataTR = mysqli_query($dbc, $queryTR);
            $rowTR = mysqli_fetch_array($dataTR);

            //average applied score
            if ($where == "") {
                $spec = "where examSubject = 'total'";
            }
            else {
                $spec = $where." and examSubject = 'total'";
            }
            $queryAAp= "select round(avg(score), 2) as total from examScore join applicant on examScore.uid = applicant.uid ".$spec;
            $dataAAp = mysqli_query($dbc, $queryAAp);
            $rowAAp = mysqli_fetch_array($dataAAp);

            //average admitted score
            if ($where == "") {
                $spec = "where examSubject = 'total' and (appStatus = 3 or appStatus = 4)";
            }
            else {
                $spec = $where." and examSubject = 'total' and (appStatus = 3 or appStatus = 4)";
            }
            $queryAAd= "select round(avg(score), 2) as total from examScore join applicant on examScore.uid = applicant.uid ".$spec;
            $dataAAd = mysqli_query($dbc, $queryAAd);
            $rowAAd = mysqli_fetch_array($dataAAd);
        ?>
                <tr>
                    <th scope="row"><?php echo $rowT['total']; ?>
                    <th scope="row"><?php echo $rowTA['total']; ?>
                    <th scope="row"><?php echo $rowTR['total']; ?>
                    <th scope="row"><?php echo $rowAAp['total']; ?>
                    <th scope="row"><?php echo $rowAAd['total']; ?>
                </tr>
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