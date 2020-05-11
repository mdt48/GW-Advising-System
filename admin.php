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

   // uid manual assignment for debugging 

    require_once('connectvars.php');
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
                    <h1 class = "display-4 text-center text-white mt-5 mb-2">Add Users</h1>
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
                $username = mysqli_real_escape_string($dbc, $_POST['username']);
                $password = mysqli_real_escape_string($dbc, $_POST['password']);
                $ssn = mysqli_real_escape_string($dbc, $_POST['ssn']);
                $email = mysqli_real_escape_string($dbc, $_POST['email']);
                $fname = mysqli_real_escape_string($dbc, $_POST['fname']);
                $lname = mysqli_real_escape_string($dbc, $_POST['lname']);
                $address = mysqli_real_escape_string($dbc, $_POST['address']);
                $date = mysqli_real_escape_string($dbc,$_POST['bday']);

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
                        $msg = "Here is your login info: \n Username: $username \n Password: $password";
						mail($email, "GW Graduate Program Login Info", $msg);
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

                $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
                $password = mysqli_real_escape_string($dbc, $_POST['apppassword']);
                $ssn = mysqli_real_escape_string($dbc, $_POST['appssn']);
                $email = mysqli_real_escape_string($dbc, $_POST['appemail']);
                $fname = mysqli_real_escape_string($dbc, $_POST['appfname']);
                $lname = mysqli_real_escape_string($dbc, $_POST['applname']);
                $address = mysqli_real_escape_string($dbc, $_POST['appaddress']);
                $date = mysqli_real_escape_string($dbc,$_POST['bday']);

                $query = "INSERT INTO people (ssn, username, email, birthDate, password, fname, lname, address) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
                mysqli_query($dbc, $query);

                $query = "select uid from people where username = '".$username."'";
                $data = mysqli_query($dbc, $query); 
                $row = mysqli_fetch_array($data);

                $query = "insert into applicant (uid, appStatus) values (".$row['uid'].",1)";
                mysqli_query($dbc, $query);
                
                $msg = "Here is your login info: \n Username: $username \n Password: $password";
                mail($email, "GW Graduate Program Login Info", $msg);

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

        if (isset($_POST['student'])) {

            // Search for existing user with name
            $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
            $query = "SELECT uid FROM people WHERE username = '".$username."'";
            $data = mysqli_query($dbc, $query);

            if (mysqli_num_rows($data) == 0) {
                $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
                $password = mysqli_real_escape_string($dbc, $_POST['apppassword']);
                $ssn = mysqli_real_escape_string($dbc, $_POST['appssn']);
                $email = mysqli_real_escape_string($dbc, $_POST['appemail']);
                $fname = mysqli_real_escape_string($dbc, $_POST['appfname']);
                $lname = mysqli_real_escape_string($dbc, $_POST['applname']);
                $address = mysqli_real_escape_string($dbc, $_POST['appaddress']);
                $date = mysqli_real_escape_string($dbc,$_POST['bday']);
                $program = $_POST['program'];
                $dept = $_POST['dept'];
                $adv = $_POST['adv'];
                $sem = $_POST['sem'];
                $year = $_POST['year'];

                $query = "INSERT INTO people (ssn, username, email, birthDate, password, fname, lname, address) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
                mysqli_query($dbc, $query);

                $query = "select uid from people where username = '".$username."'";
                $data = mysqli_query($dbc, $query); 
                $row = mysqli_fetch_array($data);

                $query = "INSERT INTO student (uid, advisoruid, program, ayear, asem, department) values (".$row['uid'].", ".$adv.", '".$program."', ".$year.", '".$sem."', '".$dept."')";
                mysqli_query($dbc, $query);
                
                $msg = "Here is your login info: \n Username: $username \n Password: $password";
                mail($email, "GW Graduate Program Login Info", $msg);

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
        if (isset($_POST['alumn'])) {

            // Search for existing user with name
            $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
            $query = "SELECT uid FROM people WHERE username = '".$username."'";
            $data = mysqli_query($dbc, $query);

            if (mysqli_num_rows($data) == 0) {
                $username = mysqli_real_escape_string($dbc, $_POST['appusername']);
                $password = mysqli_real_escape_string($dbc, $_POST['apppassword']);
                $ssn = mysqli_real_escape_string($dbc, $_POST['appssn']);
                $email = mysqli_real_escape_string($dbc, $_POST['appemail']);
                $fname = mysqli_real_escape_string($dbc, $_POST['appfname']);
                $lname = mysqli_real_escape_string($dbc, $_POST['applname']);
                $address = mysqli_real_escape_string($dbc, $_POST['appaddress']);
                $date = mysqli_real_escape_string($dbc,$_POST['bday']);
                $program = $_POST['program'];
                $dept = $_POST['dept'];
                $adv = $_POST['adv'];
                $sem = $_POST['sem'];
                $year = $_POST['year'];
                $gsem = $_POST['gsem'];
                $gyear = $_POST['gyear'];

                $query = "INSERT INTO people (ssn, username, email, birthDate, password, fname, lname, address) VALUES (".$ssn.", '".$username."', '".$email."', '".$date."', '".$password."', '".$fname."', '".$lname."', '".$address."')";
                mysqli_query($dbc, $query);

                $query = "select uid from people where username = '".$username."'";
                $data = mysqli_query($dbc, $query); 
                $row = mysqli_fetch_array($data);

                $query = "INSERT INTO student (uid, advisoruid, program, ayear, asem, department, grad_status, thesis, audited, grad_year, gsem) values (".$row['uid'].", ".$adv.", '".$program."', ".$year.", '".$sem."', '".$dept."', 'alumni', 1, 1, ".$gyear.", '".$sem."')";
                mysqli_query($dbc, $query);
                
                $msg = "Here is your login info: \n Username: $username \n Password: $password";
                mail($email, "GW Graduate Program Login Info", $msg);

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
                        <option value="9">Faculty Reviewer, Advisor and Instructor</option>
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
                    <label for="bday">Birthdate</label>
                    <input required name="bday" type="date" class="form-control">
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
        <h1>Add Student</h1>
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
                    <label for="bday">Birthdate</label>
                    <input required name="bday" type="date" class="form-control">
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
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="program">Program</label>
                    <select name="program" class="form-control" required>
                        <option value="masters">Masters</option>
                        <option value="phd">PhD</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="dept">Department</label>
                    <input required name="dept" type="text" maxlength="256" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="adv">Advisor</label>
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
                </div>
            </div><div class="form-row">
                <div class="form-group col-md-4">
                    <label for="sem">Semester</label>
                    <select name="sem" class="form-control" required>
                        <option value="fall">Fall</option>
                        <option value="spring">Spring</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="year">Year</label>	
                    <input type="number" class="form-control" min="2020" max="2050" step="1" value="2020" name="year" required>
                </div>
            </div>
            <button type="submit" name="student" class="btn btn-primary">Submit</button>

        </form>

        <br>
        <h1>Add Alumni</h1>
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
                    <label for="bday">Birthdate</label>
                    <input required name="bday" type="date" class="form-control">
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
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="program">Program</label>
                    <select name="program" class="form-control" required>
                        <option value="masters">Masters</option>
                        <option value="phd">PhD</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="dept">Department</label>
                    <input required name="dept" type="text" maxlength="256" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="adv">Advisor</label>
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
                </div>
            </div><div class="form-row">
                <div class="form-group col-md-4">
                    <label for="sem">Semester</label>
                    <select name="sem" class="form-control" required>
                        <option value="fall">Fall</option>
                        <option value="spring">Spring</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="year">Year</label>	
                    <input type="number" class="form-control" min="2020" max="2050" step="1" value="2020" name="year" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="gsem">Graduation Semester</label>
                    <select name="gsem" class="form-control" required>
                        <option value="fall">Fall</option>
                        <option value="spring">Spring</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="gyear">Graduation Year</label>	
                    <input type="number" class="form-control" min="2020" max="2050" step="1" value="2020" name="gyear" required>
                </div>
            </div>
            <button type="submit" name="alumn" class="btn btn-primary">Submit</button>

        </form>

        <br>

        <div class="row">	<p>
				<a class="btn text-white btn-lg" style = "background-color: #033b59;" href = "index.php">Go Back</a></p> </div>
		<br> <br> <br>
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

<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById("yesCheck").checked) {
			document.getElementById("total").required = true;
			document.getElementById("quant").required = true;
			document.getElementById("verbal").required = true;

        } else {
			document.getElementById("total").required = false;
			document.getElementById("quant").required = false;
			document.getElementById("verbal").required = false;
        }
    }
	
	function sumFunct() {
		var sum = 0;
		if (parseInt(document.getElementById("quant").value) > 170 || parseInt(document.getElementById("quant").value) <= 0) {
			document.getElementById("quant").value = 0;
		}
		else if (parseInt(document.getElementById("verbal").value) > 170 || parseInt(document.getElementById("verbal").value) <= 0) {
			document.getElementById("verbal").value = 0;
		}
		else {
			sum += parseInt(document.getElementById("quant").value);
			sum += parseInt(document.getElementById("verbal").value);
		}
		document.getElementById("total1").value = sum;
		document.getElementById("total").value = sum;
    }

	/*function disableReq() {

	}*/

</script>