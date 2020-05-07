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
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Accepted Students</h1>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container">
                <?php
                    $where = "";
                    $order = "asc";
                    $result = "Currently viewing results of all programs, all semesters, and all years, order by asc";
                    if (isset($_POST['submit'])) {
                        $program = $_POST['program'];
                        $semester = $_POST['sem'];
                        $year = $_POST['year'];
                        $uidP = $_POST['uid'];
                        $lname = $_POST['lname'];
                        $order = $_POST['order'];
                        $by = $_POST['by'];

                        $result = "";

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

                        $result = "Currently viewing results of ";

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

                        if ($yearSelected == false && $semesterSelected == false && $programSelected == false && $uidSelected == false && $lnameSelected == false) {
                            $where = "";
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
                            <th scope="col">Date Admitted</th>
                            <th scope="col">Year</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Program</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
        <?php
        $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE (appStatus = 4 or appStatus = 3) and applicant.uid not in (select uid from student) ".$where;
        $data = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($data)) {
        ?>
            <form method="POST" action="accept.php">
                <tr>
                    <th scope="row"><?php echo $row['uid']; ?>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['accDate']; ?></td>
                    <td><?php echo $row['admissionYear']; ?></td>
                    <td><?php echo $row['admissionSemester']; ?></td>
                    <td><?php if ($row['degProgram'] == "md") echo "Masters"; else echo "PhD"; ?></td>
                    <input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
                    <input type="hidden" name="matriculate" value="<?php echo $row['uid']; ?>">
                    <td><button type="submit" name="review" class="btn btn-primary">Matriculate</button></td>
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