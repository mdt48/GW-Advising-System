<?php

    //start the session
    require_once('connectvars.php');

    session_start();

    echo '<link rel="stylesheet" type="text/css" href="style.css">';?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel = "stylesheet" href="/css/heroic-features.css" >
  <link rel="stylesheet" type="text/css" href="style.css">    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  
  <header class = "bg py-5 mb-5" style = "background-color: #033b59; height: 15em;">
    <div class = "container h-100">
        <div class = "row h-100 align-items-center">
            <div class = "col-lg-12">
                <h1 class = "display-4 text-center text-white mt-5 mb-2">Enter Grades</h1></div>
        </div>
    </div>
  </header>
  <body style = "text-align: center;">

<?php

    //open database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $space = " ";

    //get u_id from other page
    if (isset($_GET["u_id"])) {
        $u_id = $_GET["u_id"];
        $studentquery = "SELECT * FROM people WHERE uid = '$u_id'";
        $studentdata = mysqli_query($dbc, $studentquery);
        $student = mysqli_fetch_array($studentdata);
        echo '<div id = "top"><h1>'.$student['fname'].' '.$student['lname'].'\'s Classes</h1></div>';
    } else {
        echo '<div id = "top"><h1>Student\'s Classes</h1></div>';
    }

    if (isset($_GET["teach_id"])) {
        $teach_id = $_GET["teach_id"];
    }

    if ($_SESSION['type'] == 5 || $_SESSION['type'] == 7 || $_SESSION['type'] == 8 || $_SESSION['type'] == 9) {
        $classquery = "SELECT * FROM takes c JOIN teaches d ON (c.cid = d.cid AND c.department = d.department AND c.year = d.year AND c.section = d.section AND c.semester = d.semester) WHERE d.uid = '$teach_id' AND c.grade = 'IP' AND c.uid = '$u_id'";
        $classdata = mysqli_query($dbc, $classquery);
    } else {
        $classquery = "SELECT * FROM takes WHERE uid = '$u_id'";
        $classdata = mysqli_query($dbc, $classquery);
    }

    echo '<table>';
    while ($row = mysqli_fetch_array($classdata)) { //show the classes with a button to add a grade for each one
        ?><form action="newgrade.php" method="GET">
            <input type="text" name="grade" required />
            <input type="submit" name="submit" value="Grade" />
            <input type="hidden" name ="dept" value="<?php echo $row["department"]; ?>" />
            <input type="hidden" name ="c_id" value="<?php echo $row["cid"]; ?>" />
            <input type="hidden" name ="semester" value="<?php echo $row["semester"]; ?>" />
            <input type="hidden" name ="year" value="<?php echo $row["year"]; ?>" />
            <input type="hidden" name ="section" value="<?php echo $row["section"]; ?>" />
            <input type="hidden" name ="u_id" value="<?php echo $u_id; ?>" />
        </form> <?php

        $class = $row["department"].$space.$row["cid"];
        echo $class;?><br><?php

    }

    echo '</table>';

    echo '<br/><br/><a href="grades.php">Back to all students</a>';


?>
</body>