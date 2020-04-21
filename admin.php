<!DOCTYPE html>
<html>
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<title> GW Graduate Program - System Administrator Dashboard </title>
</head>

<body data-gr-c-s-loaded = "true">

<?php
  // Start the session
   session_start();

   // GWID manual assignment for debugging 

    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_SESSION['gwid'])) {
        $query = "SELECT * FROM faculty WHERE gwid = '".$_SESSION['gwid']."'";
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

    // user is a faculty, allow access to page
    $row = mysqli_fetch_array($data);

    if ($row['facultyType'] == 3) {
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
    // Faculty is a system administrator, only level allowed to access page

        // Check if submit is activated to add a faculty
        if (isset($_POST['faculty'])) {

            // Search for existing user with name
            $username = mysqli_real_escape_string($dbc, $_POST['username']);
            $query = "SELECT gwid FROM users WHERE username = '".$username."'";
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

                $query = "INSERT INTO users (ssn, username, email, birthDate, userPassword, fname, lname, userAddress) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
                $data = mysqli_query($dbc, $query);

                $query = "SELECT gwid FROM users WHERE username = '".$_POST['username']."'";
                $data = mysqli_query($dbc, $query);

                if (mysqli_num_rows($data) != 0) {
                    $row = mysqli_fetch_array($data);
                    $gwid = $row['gwid'];

                    $years = mysqli_real_escape_string($dbc, $_POST['years']);
                    $dept = mysqli_real_escape_string($dbc, $_POST['dept']);
    
                    $query = "INSERT INTO faculty (gwid, facultyType, yearsWorking, department) VALUES (".$gwid.", ".$_POST['type'].", ".(int)$years.", '".$dept."')";
                    $data = mysqli_query($dbc, $query);

                    $query = "SELECT gwid FROM faculty WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);

                    if (mysqli_num_rows($data) != 0) {
                        ?>
                        <div class="container">
                        <div class="alert alert-success" role="alert">Successfully added faculty to the system!</div>
                        </div>
                        <?php
                    }
                    else {
                        ?>
                        <div class="container">
                        <div class="alert alert-danger" role="alert">ERROR: A database error occurred! Please try again.</div>
                        </div>
                        <?php
                        $query = "DELETE FROM users WHERE gwid = ".$gwid;
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
            $query = "SELECT gwid FROM users WHERE username = '".$username."'";
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

                $query = "INSERT INTO users (ssn, username, email, birthDate, userPassword, fname, lname, userAddress) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
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

        // Deleting a faculty member
        if (isset($_POST['delfac'])) {

            if (!empty($_POST['delusername']) || !empty($_POST['delgwid'])) {

                // Search for existing user with name
                $username = mysqli_real_escape_string($dbc, $_POST['delusername']);
                $gwid = mysqli_real_escape_string($dbc, $_POST['delgwid']);
                $username = "username = '".$username."'";
                $gwid = "users.gwid = ".$gwid;
                // Input for GWID or Username is empty, clear strings if this is the case
                if ($_POST['delgwid'] == "") {
                    $gwid = "";
                }
                if ($_POST['delusername'] == "") {
                    $username = "";
                }
                // Both have inputs, add OR condition
                if (!empty($_POST['delusername']) && !empty($_POST['delgwid'])) {
                    $gwid = " OR ".$gwid;
                }
                $query = "SELECT users.gwid FROM users JOIN faculty ON users.gwid = faculty.gwid WHERE ".$username.$gwid;
                $data = mysqli_query($dbc, $query);
                echo mysqli_error($dbc);

                if (mysqli_num_rows($data) == 1) {

                    $row = mysqli_fetch_array($data);
                    $gwid = $row['gwid'];

                    $query = "DELETE FROM faculty WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM users WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);

                    ?>
                    <div class="container">
                    <div class="alert alert-success" role="alert">Successfully deleted faculty member from the system!</div>
                    </div>
                    <?php
                }
                else if (mysqli_num_rows($data) == 0) {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: No match! The user you are trying to delete either does not exist or is not a faculty member. Please check your input and try again.</div>
                    </div>
                    <?php
                }
                else if (mysqli_num_rows($data) > 1) {
                    ?>
                    <div class="container">
                    <div class="alert alert-danger" role="alert">ERROR: No exact match! The GWID and Username provided match more than one user. Please check your input and try again.</div>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <div class="container">
                <div class="alert alert-danger" role="alert">ERROR: Not enough information! Please ensure that you are specifying either a GWID or a Username for the user you wish to delete.</div>
                </div>
                <?php
            }
        }
        // Deleting a applicant
        if (isset($_POST['delapp'])) {

            if (!empty($_POST['delusername']) || !empty($_POST['delgwid'])) {

                // Search for existing user with name
                // Search for existing user with name
                $username = mysqli_real_escape_string($dbc, $_POST['delusername']);
                $gwid = mysqli_real_escape_string($dbc, $_POST['delgwid']);
                $username = "username = '".$username."'";
                $gwid = "users.gwid = ".$gwid;
                // Input for GWID or Username is empty, clear strings if this is the case
                if ($_POST['delgwid'] == "") {
                    $gwid = "";
                }
                if ($_POST['delusername'] == "") {
                    $username = "";
                }
                // Both have inputs, add OR condition
                if (!empty($_POST['delusername']) && !empty($_POST['delgwid'])) {
                    $gwid = " OR ".$gwid;
                }
                $query = "SELECT users.gwid FROM users JOIN applicant ON users.gwid = applicant.gwid WHERE ".$username.$gwid;
                $data = mysqli_query($dbc, $query);
                echo mysqli_error($dbc);

                if (mysqli_num_rows($data) == 1) {

                    $row = mysqli_fetch_array($data);
                    $gwid = $row['gwid'];

                    $query = "DELETE FROM applicant WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM degree WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM examScore WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM recs WHERE gwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM recReview WHERE studentGwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM reviewForm WHERE studentGwid = ".$gwid;
                    $data = mysqli_query($dbc, $query);
                    echo mysqli_error($dbc);
                    $query = "DELETE FROM users WHERE gwid = ".$gwid;
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
                    <div class="alert alert-danger" role="alert">ERROR: No exact match! The GWID and Username provided match more than one user. Please check your input and try again.</div>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <div class="container">
                <div class="alert alert-danger" role="alert">ERROR: Not enough information! Please ensure that you are specifying either a GWID or a Username for the user you wish to delete.</div>
                </div>
                <?php
            }
        }    
    ?>

    <div class="container">

        <h1>Add Faculty</h1>
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
                    <label for="type">Type of Faculty</label>
                    <select name="type" class="form-control">
                        <option value="0">Regular Faculty</option>
                        <option value="1">Graduate Secretary</option>
                        <option value="2">CAC Faculty</option>
                        <option value="3">System Administrator</option>
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
            <button type="submit" name="faculty" class="btn btn-primary">Submit</button>

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

        <h1>Delete Faculty</h1>
        <p>Delete a faculty member by specifying their username, GWID, or both. The system will find and delete the faculty member whose information best matches the provided information.</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="delgwid">GWID</label>
                    <input name="delgwid" type="text" class="form-control" maxlength="9" onkeypress="return (event.charCode > 47 && 
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
        <p>Delete an applicant by specifying their username, GWID, or both. The system will find and delete the applicant whose information best matches the provided information.</p>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="delgwid">GWID</label>
                    <input name="delgwid" type="text" class="form-control" maxlength="9" onkeypress="return (event.charCode > 47 && 
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