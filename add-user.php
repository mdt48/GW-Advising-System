<?php

  //start the session
  require_once('connectvars.php');

  session_start();

  //open database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  echo '<link rel="stylesheet" type="text/css" href="style.css">';
  echo '<div id = "top"><h1>Add a user</h1></div>';

?>

<head>
  <title>Add user</title>
</head>

<body>
  <form method="post">
    <input type="text" name="input_fname" placeholder="Enter first name" required>
    <input type="text" name="input_lname" placeholder="Enter last name" required>
    <input type="text" name="input_uname" placeholder="Enter username" required>
    <input type="text" name="input_pass" placeholder="Enter password" required>
    <input type="text" name="input_email" placeholder="Enter email">
    <input type="text" name="input_address" placeholder="Enter street address">
    <select id="role" name="role" required>
      <option value="" diabled selected>Select a role...</option>
      <option value="masters_student">Student (Master's Program)</option>
      <option value="phd_student">Strudent (PhD Program)</option>
      <option value="gs">Graduate Secretary (GS)</option>
      <option value="faculty">Faculty</option>
      <option value="admin">Administrator</option>
    </select>
    <input name="Submit" type="submit">
  </form>
  <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      //take in info from the table
      $fname = $_POST['input_fname'];
      $lname = $_POST['input_lname'];
      $uname = $_POST['input_uname'];
      $pass = $_POST['input_pass'];
      $email = $_POST['input_email'];
      $address = $_POST['input_address'];
      $role = $_POST['role'];
      //generate a unique id for the person
      $found_unique_string = false;
      $new_id = "";
      while (!$found_unique_string) {
        $new_id = substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $check_id_query = mysqli_query($dbc, "SELECT * FROM person WHERE u_id = '$new_id';");
        echo "The new user's unique id is: ";
        echo($new_id);
        echo ".<br/><br/>";
        if (mysqli_num_rows($check_id_query) == 0) {
          $found_unique_string = true;
        }
      }
      //insert the person's info into the person table
      $insert_query = mysqli_query($dbc, "INSERT INTO person(u_id, username, password, fname, lname, address, email) VALUES ('$new_id', '$uname', '$pass', '$fname', '$lname', '$address', '$email');");
      //insert into role-relevant table now
      if ($role == "masters_student") {
        $role_query = mysqli_query($dbc, "INSERT INTO student(u_id, program) VALUES ('$new_id', 'Masters');");
      } else if ($role == "phd_student") {
        $role_query = mysqli_query($dbc, "INSERT INTO student(u_id, program) VALUES ('$new_id', 'PhD');");
      } else if ($role == "gs") {
        $role_query = mysqli_query($dbc, "INSERT INTO admin(u_id, isGS) VALUES ('$new_id', true);");
      } else if ($role == "faculty") {
        $role_query = mysqli_query($dbc, "INSERT INTO faculty(u_id) VALUES ('$new_id');");
      } else if ($role == "admin") {
        $role_query = mysqli_query($dbc, "INSERT INTO admin(u_id, isGS) VALUES ('$new_id', false);");
      }
    }
  ?>
  <a href="homepage.php">Home</a>
</body>