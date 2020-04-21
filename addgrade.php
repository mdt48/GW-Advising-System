<?php

    //start the session
    require_once('connectvars.php');

    session_start();

    echo '<link rel="stylesheet" type="text/css" href="style.css">';

    //open database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    $space = " ";

    //get u_id from other page
    if (isset($_GET["u_id"])) {
        $u_id = $_GET["u_id"];
        $studentquery = "SELECT * FROM person WHERE u_id = '$u_id'";
        $studentdata = mysqli_query($dbc, $studentquery);
        $student = mysqli_fetch_array($studentdata);
        echo '<div id = "top"><h1>'.$student['fname'].' '.$student['lname'].'\'s Classes</h1></div>';
    } else {
        echo '<div id = "top"><h1>Student\'s Classes</h1></div>';
    }

    if (isset($_GET["teach_id"])) {
        $teach_id = $_GET["teach_id"];
    }

    if ($_SESSION['whoareyou'] == "faculty") {
        $classquery = "SELECT * FROM takes c JOIN teaches d ON (c.c_id = d.c_id AND c.dept = d.dept AND c.year = d.year AND c.section = d.section AND c.semester = d.semester) WHERE d.u_id = '$teach_id' AND c.grade = 'IP' AND c.u_id = '$u_id'";
        $classdata = mysqli_query($dbc, $classquery);
    } else {
        $classquery = "SELECT * FROM takes WHERE u_id = '$u_id'";
        $classdata = mysqli_query($dbc, $classquery);
    }

    echo '<table>';
    while ($row = mysqli_fetch_array($classdata)) { //show the classes with a button to add a grade for each one
        ?><form action="newgrade.php" method="GET">
            <input type="text" name="grade" />
            <input type="submit" name="submit" value="Grade" />
            <input type="hidden" name ="dept" value="<?php echo $row["dept"]; ?>" />
            <input type="hidden" name ="c_id" value="<?php echo $row["c_id"]; ?>" />
            <input type="hidden" name ="semester" value="<?php echo $row["semester"]; ?>" />
            <input type="hidden" name ="year" value="<?php echo $row["year"]; ?>" />
            <input type="hidden" name ="section" value="<?php echo $row["section"]; ?>" />
            <input type="hidden" name ="u_id" value="<?php echo $u_id; ?>" />
        </form> <?php

        $class = $row["dept"].$space.$row["c_id"];
        echo $class;?><br><?php

    }

    echo '</table>';

    echo '<br/><br/><a href="grades.php">Back to all students</a>';


?>