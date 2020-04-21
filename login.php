<html lang="en"> 
<head>
    <title>Registration</title>
    <div id = "top"><h1>Login</h1></div>
</head>

<?php
        require_once('connectvars.php');
	session_start();
	echo '<link rel="stylesheet" type="text/css" href="style.css">';
	//the line below gives an error when you log out, because there is no username variable anymore 

	if (!(isset($_SESSION['username']))){
	    if (isset($_POST['submit'])){

		// Connect to the database
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
		// Get the username and password that the user entered
		$user_username = mysqli_real_escape_string($dbc, trim($_POST['username']));
		$user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

		// Check to see if the user exists in the database
		// Query must check not only if the username and password exist in person but also if the user id of that person exists in the specified table

		if (!empty($user_username) && !empty($user_password)) {

		    // Checking type of user to know which homepage to be directed to
		    
		    // Student logged in
		    if ($_POST['whatuser'] == "gradstudent") {
		        // Retrieves data queried from the database
		        $query = "SELECT * FROM person p, student s WHERE p.username='$user_username' and p.password='$user_password' and p.u_id=s.u_id";
		        $data = mysqli_query($dbc, $query);
		        // If the username and password are valid, login
			if (mysqli_num_rows($data) == 1){
		            $_SESSION['whoareyou'] =  "gradstudent";
			    $_SESSION['username'] = $user_username;
			    $row = mysqli_fetch_assoc($data);
			    $_SESSION['u_id'] = $row['u_id'];
			    // Go to users homepage
                            $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/homepage.php';
			    header('Location: ' . $home_url);
			}
			else {
			    echo "<p> <font color=red>Username, password, or user type is incorrect. Please try again.</font> </p>";
			}	
		    }

		    // GS logged in
		    else if ($_POST['whatuser'] == "GS") {
                        // Retrieves data queried from the database
			$query = "SELECT * FROM person p, admin a WHERE p.username='$user_username' and p.password='$user_password' and p.u_id=a.u_id";
			$data = mysqli_query($dbc, $query);
			// If the username and passowrd are valid, login
			if (mysqli_num_rows($data) == 1) {
			    // Check that the user is specified as a GS in the admin table
			    $row = mysqli_fetch_assoc($data);
                            if ($row['isGS'] == true){

			        $_SESSION['whoareyou'] = "GS";
			        $_SESSION['username'] = $user_username;
			        $_SESSION['u_id'] = $row['u_id'];
			        // Go to users homepage
                                $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/homepage.php';
			        header('Location: ' . $home_url);
			    }
			}
			else {
                            echo "<p> <font color=red>Username, password, or user type is incorrect. Please try again.</font> </p>";
                        }
		    }

	 	    // Faculty logged in
		    else if ($_POST['whatuser'] == "faculty") {
                        // Retrieve data queried from the database
			$query = "SELECT * FROM person p, faculty f WHERE p.username='$user_username' and p.password='$user_password' and p.u_id=f.u_id";
			$data = mysqli_query($dbc, $query);
			// If the username and password are valid, login
			if (mysqli_num_rows($data) == 1) {
			    $_SESSION['whoareyou'] = "faculty";
			    $_SESSION['username'] = $user_username;
			    $row = mysqli_fetch_assoc($data);
			    $_SESSION['u_id'] = $row['u_id'];
			    // Go to users homepage
                            $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/homepage.php';
                            header('Location: ' . $home_url);
			}
			else {
                            echo "<p> <font color=red>Username, password, or user type is incorrect. Please try again.</font> </p>";
                        }
		    }

		    // Admin logged in
		    else if ($_POST['whatuser'] == "admin") {
                        // Retrieve data queried from the database
			$query = "SELECT * FROM person p, admin a WHERE p.username='$user_username' and p.password='$user_password' and p.u_id=a.u_id";
			$data = mysqli_query($dbc, $query);
			// If the username and password are valid, login
			if (mysqli_num_rows($data) == 1) {
			    // Check that the user is specified as an admin in the admin table
			    $row = mysqli_fetch_assoc($data);
			    if ($row['isGS'] == false) {

			        $_SESSION['whoareyou'] = "admin";
			        $_SESSION['username'] = $user_username;
			        $_SESSION['u_id'] = $row['u_id'];
			        // Go to users homepage
			        $home_url = 'http://' . $_SERVER["HTTP_HOST"] . dirname($_SERVER["PHP_SELF"]) . '/homepage.php';
			        header('Location: ' . $home_url);
			    }
			}
			else {
                            echo "<p> <font color=red>Username, password, or user type is incorrect. Please try again.</font> </p>";
                        }
		    }

		    // If they did not select what type of user they are
		    else {
			$error_msg = "ERROR: You must select what type of user";
			echo $error_msg;
		    }

		}

		// If one or both of the usernmae and passwored fields were blank
		else {
	 	    $error_msg = "ERROR: enter username and password";
		    echo $error_msg;	
		}
	    }
	}

?>

<body>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <label for="username">Username: </label>
                <input type="text" id="username" name="username" required/>
                <br />

                <label for="password">Password: </label>
                <input type="password" id="passwrod" name="password" required/>
                <br />
		
		<input type="radio" value="gradstudent" name="whatuser" required/>
		<label for="gradstudent">Grad Student</label>
		<br />

                <input type="radio" value="GS" name="whatuser" required/>
		<label for="GS">GS</label>
		<br />

                <input type="radio" value="faculty" name="whatuser" required/>
		<label for="faculty">Faculty</label>
		<br />

                <input type="radio" value="admin" name="whatuser" required/>
		<label for="admin">Admin</label>
		<br />

                <input type="submit" value="Login" name="submit" /> <br />
</form>
</body>
