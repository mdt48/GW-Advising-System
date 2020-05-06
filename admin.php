<?php
    require_once('navBar.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_SESSION['uid'])) {
        $query = "SELECT * FROM staff WHERE uid = '".$_SESSION['uid']."'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) > 0) {

?>

<!-- NAV BAR -->
<nav class = "navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class = "container">
		<a class = "navbar-brand" href = "landingPage.php">GW Graduate Program</a>
		<div class = "navbar-collapse collapse" id = "navbarNavDropdown" > 
			<ul class = "navbar-nav ml-auto">
				<li class = "nav item active">
					<a class = "nav-link" href = "index.php">Home</a>
					</a>
				</li>
				<li class = "nav item">
					<a class = "nav-link" href = "logout.php">Logout</a>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>

<?php

    // user is a staff, allow access to page
    $row = mysqli_fetch_array($data);

    if ($row['type'] == 0) {
    ?>
    <!-- HEADER -->
    <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
        <div class = "container h-100">
            <div class = "row h-100 align-items-center">
                <div class = "col-lg-12">
                    <h1 class = "display-4 text-center text-white mt-5 mb-2">Administrator Dashboard</h1>
                </div>
            </div>
        </div>
    </header>
    <?php
    // staff is a system administrator, only level allowed to access page

        // Check if submit is activated to add a staff
        if (isset($_POST['staff'])) {

            // Search for existing user with name
            $username = mysqli_real_escape_string($dbc, $_POST['username']);
            $query = "SELECT uid FROM people WHERE username = '".$username."'";
            $data = mysqli_query($dbc, $query);

            if (mysqli_num_rows($data) == 0) {
                $input_date=$_POST['bday'];
                $date=date("Y-m-d H:i:s",strtotime($input_date));

                $username = mysqli_real_escape_string($dbc, $_POST['username']);
                $password = mysqli_real_escape_string($dbc, $_POST['password']);
                $ssn = mysqli_real_escape_string($dbc, $_POST['ssn']);
                $email = mysqli_real_escape_string($dbc, $_POST['email']);
                $fname = mysqli_real_escape_string($dbc, $_POST['fname']);
                $lname = mysqli_real_escape_string($dbc, $_POST['lname']);
                $address = mysqli_real_escape_string($dbc, $_POST['address']);

                $query = "INSERT INTO people (ssn, username, email, birthDate, password, fname, lname, address) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
                $data = mysqli_query($dbc, $query);

                $query = "SELECT uid FROM people WHERE username = '".$_POST['username']."'";
                $data = mysqli_query($dbc, $query);

                if (mysqli_num_rows($data) != 0) {
                    $row = mysqli_fetch_array($data);
                    $uid = $row['uid'];

                    $years = mysqli_real_escape_string($dbc, $_POST['years']);
                    $dept = mysqli_real_escape_string($dbc, $_POST['dept']);
    
                    $query = "INSERT INTO staff (uid, type, yearsWorking, department) VALUES (".$uid.", ".$_POST['type'].", ".(int)$years.", '".$dept."')";
                    $data = mysqli_query($dbc, $query);

                    $query = "SELECT uid FROM staff WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);

                    if (mysqli_num_rows($data) != 0) {
                        ?>
                        <div class="container">
                        <div class="alert alert-success" role="alert">Successfully added staff to the system!</div>
                        </div>
                        <?php
                    }
                    else {
                        ?>
                        <div class="container">
                        <div class="alert alert-danger" role="alert">ERROR: A database error occurred! Please try again.</div>
                        </div>
                        <?php
                        $query = "DELETE FROM people WHERE uid = ".$uid;
                    }
    
                    
                }
                else {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: A database error occurred! Please try again.</div>
                    </div>
                    <?php

                }

            }
            else {
                ?>
                <div class="container">
                <div class="alert alert-danger" role="alert">ERROR: The username you tried to add already exists!</div>
                </div>
                <?php
            }
        }

        if (isset($_POST['applicant'])) {

            // Search for existing user with name
            $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
            $query = "SELECT uid FROM people WHERE username = '".$username."'";
            $data = mysqli_query($dbc, $query);

            if (mysqli_num_rows($data) == 0) {

                $input_date=$_POST['appbday'];
                $date=date("Y-m-d H:i:s",strtotime($input_date));

                $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
                $password = mysqli_real_escape_string($dbc, $_POST['apppassword']);
                $ssn = mysqli_real_escape_string($dbc, $_POST['appssn']);
                $email = mysqli_real_escape_string($dbc, $_POST['appemail']);
                $fname = mysqli_real_escape_string($dbc, $_POST['appfname']);
                $lname = mysqli_real_escape_string($dbc, $_POST['applname']);
                $address = mysqli_real_escape_string($dbc, $_POST['appaddress']);

                $query = "INSERT INTO people (ssn, username, email, birthDate, password, fname, lname, address) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
                $data = mysqli_query($dbc, $query);

                ?>
                <div class="container">
                <div class="alert alert-success" role="alert">Successfully added applicant to the system!</div>
                </div>
                <?php
            }
            else {
                ?>
                <div class="container">
                <div class="alert alert-danger" role="alert">ERROR: The username you tried to add already exists!</div>
                </div>
                <?php
            }
        }

        // Deleting a staff member
        if (isset($_POST['delfac'])) {

            if (!empty($_POST['delusername']) || !empty($_POST['deluid'])) {

                // Search for existing user with name
                $username = mysqli_real_escape_string($dbc, $_POST['delusername']);
                $uid = mysqli_real_escape_string($dbc, $_POST['deluid']);
                $username = "username = '".$username."'";
                $uid = "people.uid = ".$uid;
                // Input for uid or Username is empty, clear strings if this is the case
                if ($_POST['deluid'] == "") {
                    $uid = "";
                }
                if ($_POST['delusername'] == "") {
                    $username = "";
                }
                // Both have inputs, add OR condition
                if (!empty($_POST['delusername']) && !empty($_POST['deluid'])) {
                    $uid = " OR ".$uid;
                }
                $query = "SELECT people.uid FROM people JOIN staff ON people.uid = staff.uid WHERE ".$username.$uid;
                $data = mysqli_query($dbc, $query);
                echo mysqli_error($dbc);

                if (mysqli_num_rows($data) == 1) {

                    $row = mysqli_fetch_array($data);
                    $uid = $row['uid'];

                    $query = "DELETE FROM staff WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM people WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);

                    ?>
                    <div class="container">
                    <div class="alert alert-success" role="alert">Successfully deleted staff member from the system!</div>
                    </div>
                    <?php
                }
                else if (mysqli_num_rows($data) == 0) {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: No match! The user you are trying to delete either does not exist or is not a staff member. Please check your input and try again.</div>
                    </div>
                    <?php
                }
                else if (mysqli_num_rows($data) > 1) {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: No exact match! The uid and Username provided match more than one user. Please check your input and try again.</div>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <div class="container">
                <div class="alert alert-danger" role="alert">ERROR: Not enough information! Please ensure that you are specifying either a uid or a Username for the user you wish to delete.</div>
                </div>
                <?php
            }
        }
        // Deleting a applicant
        if (isset($_POST['delapp'])) {

            if (!empty($_POST['delusername']) || !empty($_POST['deluid'])) {

                // Search for existing user with name
                // Search for existing user with name
                $username = mysqli_real_escape_string($dbc, $_POST['delusername']);
                $uid = mysqli_real_escape_string($dbc, $_POST['deluid']);
                $username = "username = '".$username."'";
                $uid = "people.uid = ".$uid;
                // Input for uid or Username is empty, clear strings if this is the case
                if ($_POST['deluid'] == "") {
                    $uid = "";
                }
                if ($_POST['delusername'] == "") {
                    $username = "";
                }
                // Both have inputs, add OR condition
                if (!empty($_POST['delusername']) && !empty($_POST['deluid'])) {
                    $uid = " OR ".$uid;
                }
                $query = "select people.uid from applicant, student, staff, people where applicant.uid =".$uid." or student.uid = ".$uid." or staff.uid = ".$uid;
                $data = mysqli_query($dbc, $query);
                echo mysqli_error($dbc);

                if (mysqli_num_rows($data) == 0) {

                    $row = mysqli_fetch_array($data);
                    $uid = $row['uid'];

                    $query = "DELETE FROM applicant WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM degree WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM examScore WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM recs WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM recReview WHERE studentuid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM reviewForm WHERE studentuid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM people WHERE uid = ".$uid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);

                    ?>
                    <div class="container">
                    <div class="alert alert-success" role="alert">Successfully deleted applicant from the system!</div>
                    </div>
                    <?php
                }
                else if (mysqli_num_rows($data) == 0) {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: No match! The user you are trying to delete either does not exist or is not an applicant. Please check your input and try again.</div>
                    </div>
                    <?php
                }
                else if (mysqli_num_rows($data) > 1) {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: No exact match! The uid and Username provided match more than one user. Please check your input and try again.</div>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <div class="container">
                <div class="alert alert-danger" role="alert">ERROR: Not enough information! Please ensure that you are specifying either a uid or a Username for the user you wish to delete.</div>
                </div>
                <?php
            }
        }    
    ?>

    <div class="container">

        <h1>Add staff</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="fname">First Name</label>
                    <input required name="fname" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 64 && 
                        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
                </div>
                <div class="form-group col-md-5">
                    <label for="lname">Last Name</label>
                    <input required name="lname" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 64 &&
                        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
                </div>
                <div class="form-group col-md-2">
                    <label for="ssn">SSN</label>
                    <input required name="ssn" type="text" class="form-control" maxlength="9" minlength="9" onkeypress="return (event.charCode > 47 && 
                        event.charCode < 58)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">Username</label>
                    <input required name="username" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58)">
                </div>
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input required name="password" type="password" class="form-control" maxlength="256" onkeypress="return (event.charCode > 32 &&
                        event.charCode < 127)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="bday">Birthdate</label>
                    <input required name="bday" type="date" class="form-control">
                </div>
                <div class="form-group col-md-7">
                    <label for="email">Email Address</label>
                    <input required name="email" type="email" class="form-control" maxlength="256">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="address">Address</label>
                    <input required name="address" type="text" class="form-control" placeholder="800 22nd St NW, Washington, D.C. 20052" maxlength="256" onkeypress="return (event.charCode > 64 &&
                        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46) || 
                        (event.charCode == 44)  || (event.charCode == 32)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="type">Type of staff</label>
                    <select name="type" class="form-control">
                        <option value="0">System Administrator</option>
                        <option value="1">Graduate Secretary</option>
                        <option value="2">CAC staff</option>
                        <option value="3">Faculty Reviewer</option>
                        <option value="4">Faculty Advisor</option>
                        <option value="5">Faculty Instructor</option>
                        <option value="6">Faculty Reviewer and Advisor</option>
                        <option value="7">Faculty Reviewer and Instructor</option>
                        <option value="8">Faculty Advisor and Instructor</option>
                        <option value="9">Faculty Reviewer, Advisor, and Instructor</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="years">Years Working</label>
                    <input required name="years" type="text" maxlength="256" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="dept">Department</label>
                    <input required name="dept" type="text" maxlength="256" class="form-control">
                </div>
            </div>
            <button type="submit" name="staff" class="btn btn-primary">Submit</button>

        </form>
        <br>
        <h1>Add Applicant</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="appfname">First Name</label>
                    <input required name="appfname" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 64 && 
                        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)">
                </div>
                <div class="form-group col-md-5">
                    <label for="applname">Last Name</label>
                    <input required name="applname" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 64 &&
                        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode == 32)">
                </div>
                <div class="form-group col-md-2">
                    <label for="appssn">SSN</label>
                    <input required name="appssn" type="text" class="form-control" maxlength="9" minlength="9" onkeypress="return (event.charCode > 47 && 
                        event.charCode < 58)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="appusername">Username</label>
                    <input required name="appusername" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58)">
                </div>
                <div class="form-group col-md-6">
                    <label for="apppassword">Password</label>
                    <input required name="apppassword" type="password" class="form-control" maxlength="256" onkeypress="return (event.charCode > 32 &&
                        event.charCode < 127)">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="appbday">Birthdate</label>
                    <input required name="appbday" type="date" class="form-control">
                </div>
                <div class="form-group col-md-7">
                    <label for="appemail">Email Address</label>
                    <input required name="appemail" type="email" class="form-control" maxlength="256">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col">
                    <label for="appaddress">Address</label>
                    <input required name="appaddress" type="text" class="form-control" placeholder="800 22nd St NW, Washington, D.C. 20052" maxlength="256" onkeypress="return (event.charCode > 64 &&
                        event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58) || (event.charCode == 46) || 
                        (event.charCode == 44)  || (event.charCode == 32)">
                </div>
            </div>
            <button type="submit" name="applicant" class="btn btn-primary">Submit</button>

        </form>

        <br>

        <h1>Delete staff</h1>
        <p>Delete a staff member by specifying their username, uid, or both. The system will find and delete the staff member whose information best matches the provided information.</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="deluid">uid</label>
                    <input name="deluid" type="text" class="form-control" maxlength="9" onkeypress="return (event.charCode > 47 && 
                        event.charCode < 58)">
                </div>
                <div class="form-group col-md-6">
                    <label for="delusername">Username</label>
                    <input name="delusername" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58)">
                </div>
            </div>
            <button type="submit" name="delfac" class="btn btn-primary">Delete User</button>
        </form>

        <br>

        <h1>Delete Applicant</h1>
        <p>Delete an applicant by specifying their username, uid, or both. The system will find and delete the applicant whose information best matches the provided information.</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="deluid">uid</label>
                    <input name="deluid" type="text" class="form-control" maxlength="9" onkeypress="return (event.charCode > 47 && 
                        event.charCode < 58)">
                </div>
                <div class="form-group col-md-6">
                    <label for="delusername">Username</label>
                    <input name="delusername" type="text" class="form-control" maxlength="256" onkeypress="return (event.charCode > 96 && event.charCode < 123) || (event.charCode > 47 && event.charCode < 58)">
                </div>
            </div>
            <button type="submit" name="delapp" class="btn btn-primary">Delete User</button>
        </form>

        <br>

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