<?php 

session_start();
require_once('connectvars.php');
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

$name = mysqli_real_escape_string($dbc,$_POST['name']);
$recid = mysqli_real_escape_string($dbc,$_POST['recid']);
$job = mysqli_real_escape_string($dbc,$_POST['job']);
$org = mysqli_real_escape_string($dbc, $_POST['org']);
$email = mysqli_real_escape_string($dbc,$_POST['email']);
$rel = mysqli_real_escape_string($dbc,$_POST['rel']);
$letter = mysqli_real_escape_string($dbc,$_POST['letter']);


if (isset($_POST['submit'])) {
    $query = "SELECT email, recId FROM recs WHERE email = '$email' AND recId = '$recid'";
    $data = mysqli_query($dbc, $query);
    if (mysqli_num_rows($data) != 0){
        $recsql = "UPDATE recs SET recName = '$name', job = '$job', relation = '$rel', content = '$letter', org = '$org' WHERE email = '$email' AND recId = '$recid'";
        $dbc->query($recsql);
        if(mysqli_query($dbc, $recsql) == false) {
            echo "Info was not recorded, please try again.";
        }
        else {
            echo "<script>window.location.href='recSubmitted.php';</script>";
        }	
    }
}
mysqli_close($dbc);


?>
