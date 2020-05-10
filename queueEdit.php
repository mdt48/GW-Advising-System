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
            if ($row['type'] == 0) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Edit Information Menu</h1>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="container">
                <?php
                    $query = "select * from people where email != 'void' ";
                    $order = "asc";
                    $result = "Currently viewing results of all programs, all semesters, and all years, order by asc";
                    if (isset($_POST['submit'])) {
                        $uidP = $_POST['uid'];
                        $lname = $_POST['lname'];
                        $order = $_POST['order'];
                        $by = $_POST['by'];
                        $type = $_POST['type'];

                        if ($uidP == NULL) $uidSelected = false;
                        else $uidSelected = true;

                        if ($lname == NULL) $lnameSelected = false;
                        else $lnameSelected = true;

                        //if it's a specific table
                        if ($type == 'staff') {
                            $query = "select * from people join staff on people.uid = staff.uid where email != 'void' ";
                        }
                        else if ($type == 'student') {
                            $query = "select * from people join student on people.uid = student.uid where email != 'void' ";
                        }
                        else {
                            $query = "select * from people where email != 'void' ";
                        }

                        //if it's a uid
                        if ($uidSelected == true) {
                            $query = $query ." and uid like '%".$uidP."%'";
                        }

                        //if it's a lastname 
                        if ($lnameSelected == true) {
                            $query = $query ." and lname like '%".$lname."%'";
                        }

                        if ($type == 'app') {
                            $query = $query ." and uid not in (select uid from student) and uid not in (select uid from staff)";
                        }

                        $result = "Currently viewing results of ";
                        $query = $query." order by people.".$by." ".$order;
                        $result = $result.", order by ".$by." ".$order;
                    }
                    if (isset($_POST['Delete'])) {
                        $flag = true;
                        if ($_POST['type'] == "Staff") {
                            $queryD = "DELETE FROM recReview WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM reviewForm WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM staff WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM people WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                        }
                        else if ($_POST['type'] == "Student") {                            
                            $queryD = "DELETE FROM transcript WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM form WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM takes WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM student WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            $queryD = "DELETE FROM people WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                        }
                        else {                            
                            $queryD = "DELETE FROM recs WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM recReview WHERE studentuid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM reviewForm WHERE studentuid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "DELETE FROM reviewForm WHERE studentuid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);
                            $queryD = "UPDATE people SET username = null, email = 'void' WHERE uid = ".$_POST['uid'];
                            $data = mysqli_query($dbc, $queryD);
                            echo mysqli_error($dbc);     
                            if ($_POST['category'] == "Admitted" || $_POST['category'] == "Admitted with Aid") {
                                $queryD = "UPDATE applicant SET appStatus = 7 WHERE uid = ".$_POST['uid'];
                                $data = mysqli_query($dbc, $queryD);
                                echo mysqli_error($dbc);
                            }
                            else if ($_POST['category'] != "Rejected") {
                                $queryD = "UPDATE applicant SET appStatus = null WHERE uid = ".$_POST['uid'];
                                $data = mysqli_query($dbc, $queryD);
                                echo mysqli_error($dbc);
                            }                      
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
                    }
                ?>
                    <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input class="form-control mr-sm-2" name="uid" onkeypress = "return (event.charCode > 47 && event.charCode < 58)"  maxlength="7" type="search" placeholder="UID" id= "search_bar" aria-label="Search">
                    <input class="form-control mr-sm-2" name="lname" type="search" placeholder="Last Name" id= "search_bar" aria-label="Search" maxlength="255" onkeypress="return (event.charCode > 64 && 
			        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32) || (event.charCode == 45)">
                    <br><br><br>
                    <select name="type" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
                        <option value="all" selected hidden>Type</option>                  
                        <option value="all">All</option>                
                        <option value="staff">Staff</option>
                        <option value="app">Applicants</option>     
                        <option value="student">Students</option>  
                    </select>
                    <select name="order" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
                        <option value="asc" selected hidden>Order</option>                 
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>     
                    </select>
                    <select name="by" class="form-control mr-sm-2"  id= "search_bar" aria-label="Search"> 
                        <option value="lname" selected hidden>By</option>                 
                        <option value="lname">Last Name</option>
                        <option value="uid">UID</option>     
                    </select>
                        <input class="form-control mr-sm-2" name="submit" type="submit" id= "search_bar" aria-label="Search">
                    </form> 
                    <br>
                    
                <b><?php //echo $result;?><br></b>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">User Id</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Type</th>
                            <th scope="col">Category</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            
                        </tr>
                    </thead>
                    <tbody>
        <?php
        $data = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($data)) {
            $queryA = "select uid, appStatus from applicant where uid = ".$row['uid']." and uid not in (select uid from student)";                       
            $dataA = mysqli_query($dbc, $queryA);
            $rowA = mysqli_fetch_array($dataA);

            $queryS = "select type from staff where uid = ".$row['uid'];				
		    $dataS = mysqli_query($dbc, $queryS);
            $rowS = mysqli_fetch_array($dataS);

            $queryT = "select grad_year from student where uid = ".$row['uid'];
			$dataT = mysqli_query($dbc, $queryT);
            $rowT = mysqli_fetch_array($dataT);
            
            if (mysqli_num_rows($dataA) == 1) {
                $type = "Applicant";
                if ($rowA['appStatus'] == 1) {
                    $category = "Incomplete";
                }
                else if ($rowA['appStatus'] == 2) {
                    $category = "Pending review";
                }
                else if ($rowA['appStatus'] == 3) {
                    $category = "Admitted with Aid";
                }
                else if ($rowA['appStatus'] == 4) {
                    $category = "Admitted";
                }
                else if ($rowA['appStatus'] == 5) {
                    $category = "Rejected";
                }
                else if ($rowA['appStatus'] == 6) {
                    $category = "Declined";
                }
                else {
                    $category = "Missed Matriculation";
                }
            }
            else if (mysqli_num_rows($dataS) == 1) {
                $type = "Staff";
                if ($rowS['type'] == 0) {
                    $category = "Admin";
                }
                else if ($rowS['type'] == 1) {
                    $category = "Graduate Secretary";
                }
                else if ($rowS['type'] == 2) {
                    $category = "CAC";
                }
                else if ($rowS['type'] == 3) {
                    $category = "Faculty Reviewer";
                }
                else if ($rowS['type'] == 4) {
                    $category = "Faculty Advisor";
                }
                else if ($rowS['type'] == 5) {
                    $category = "Faculty Instructor";
                }
                else if ($rowS['type'] == 6) {
                    $category = "Faculty Reviewer and Advisor";
                }
                else if ($rowS['type'] == 7){
                    $category = "Faculty Reviewer and Instructor";
                }
                else if ($rowS['type'] == 8){
                    $category = "Faculty Advisor and Instructor";
                }
                else {
                    $category = "Faculty Reviewer, Advisor and Instructor";
                }
            }
            else if (mysqli_num_rows($dataT) == 1) {
                $type = "Student";
                if ($rowT['grad_year'] == NULL) {
                    $category = "Current Student";
                }
                else {
                    $category = "Alumni";
                }
            }
            else {
                $type = "Applicant";
                $category = "Not yet Applied";
            }
        ?>
                <tr>
                    <th scope="row"><?php echo $row['uid']; ?>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $type; ?></td>
                    <td><?php echo $category; ?></td>
                    <form method="POST" action="editAcc.php">
                    <input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
                    <input type="hidden" name="type" value="<?php echo $type; ?>">
                    <input type="hidden" name="category" value="<?php echo $category; ?>">
                    <td><button type="submit" name="Edit" class="btn btn-primary">Edit Information</button></td>
                    </form>
                    <?php 
                        if ($_SESSION['uid'] != $row['uid']) {?>
                            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="uid" value="<?php echo $row['uid']; ?>">
                            <input type="hidden" name="type" value="<?php echo $type; ?>">
                            <input type="hidden" name="category" value="<?php echo $category; ?>">
                            <td><button type="submit" name="Delete" class="btn btn-primary">Delete Account</button></td>
                            </form>
                    <?php  }
                    ?>
                </tr>
            <?php
        }
        ?>
        </tbody>
    
    </table>
    
    <a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a>
    
    </div>
    <br>
    <br>
        
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