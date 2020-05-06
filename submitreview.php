<?php

    session_start();
    require_once('connectvars.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_POST['submit'])) {

        $reason = mysqli_real_escape_string($dbc, $_POST['reason']);
        $reason = ", '".$reason."'";
        $reasonRequired = ", reasonReject";
        if ($_POST['reason'] == "NULL") {
            $reason = "";
            $reasonRequired = "";
        }
        $comments = mysqli_real_escape_string($dbc, $_POST['comments']);
        $comments = ", '".$comments."'";
        $commentsRequired = ", gasComm";
        if ($_POST['comments'] == "") {
            $comments = "";
            $commentsRequired = "";
        }
        $missingC = mysqli_real_escape_string($dbc, $_POST['missingCourses']);
        $missingC = ", '".$missingC."'";
        $missingCRequired = ", missingC";
        if ($_POST['missingCourses'] == "") {
            $missingC = "";
            $missingCRequired = "";
        }

        $query = "INSERT INTO reviewForm (uid, studentuid".$missingCRequired.", gas".$commentsRequired.$reasonRequired.") VALUES (".$_SESSION['uid'].", ".$_POST['uid'].$missingC.", ".$_POST['rating'].$comments.$reason.")";
        $data = mysqli_query($dbc, $query);

        if (isset($_POST['rating1'])) {
            $credible = 0;
            if ($_POST['credible1'] == '1') {
                $credible = 1;
            }
            $generic = 0;
            if ($_POST['generic1'] == '1') {
                $generic = 1;
            }
            $query = "INSERT INTO recReview (uid, studentuid, recId, rating, generic, credible) VALUES (".(int)$_SESSION['uid'].", ".(int)$_POST['uid'].", ".(int)$_POST['rec1'].", ".(int)$_POST['rating1'].", ".$generic.", ".$credible.")";
            $data = mysqli_query($dbc, $query);
        }
        if (isset($_POST['rating2'])) {
            $credible = 0;
            if ($_POST['credible2'] == '1') {
                $credible = 1;
            }
            $generic = 0;
            if ($_POST['generic2'] == '1') {
                $generic = 1;
            }
            $query = "INSERT INTO recReview (uid, studentuid, recId, rating, generic, credible) VALUES (".$_SESSION['uid'].", ".$_POST['uid'].", ".$_POST['rec2'].", ".$_POST['rating2'].", ".$generic.", ".$credible.")";
            $data = mysqli_query($dbc, $query);
        }
        if (isset($_POST['rating3'])) {
            $credible = 0;
            if ($_POST['credible3'] == '1') {
                $credible = 1;
            }
            $generic = 0;
            if ($_POST['generic3'] == '1') {
                $generic = 1;
            }
            $query = "INSERT INTO recReview (uid, studentuid, recId, rating, generic, credible) VALUES (".$_SESSION['uid'].", ".$_POST['uid'].", ".$_POST['rec3'].", ".$_POST['rating3'].", ".$generic.", ".$credible.")";
            $data = mysqli_query($dbc, $query);
        }
    }

    mysqli_close($dbc);
    header('Location: queue.php');

?>
