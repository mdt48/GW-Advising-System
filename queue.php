<?php
    require_once('navBar.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (isset($_SESSION['uid'])) {
        $query = "SELECT * FROM staff WHERE uid = '".$_SESSION['uid']."'";
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) > 0) {
            // user is a staff, allow access to page
            $row = mysqli_fetch_array($data);

            // update all applications if complete
            $updateQuery = "SELECT * FROM applicant WHERE appStatus = 1";
            $updateData = mysqli_query($dbc, $updateQuery);
            while ($updateRow = mysqli_fetch_array($updateData)) {
                if ($updateRow['transcript'] == 1) {
                    $checkRecsQuery = "Select * from recs where uid = ".$updateRow['uid'];
                    $checkRecsData = mysqli_query($dbc, $checkRecsQuery);
                    $numRecs = mysqli_num_rows($checkRecsData);
                    if ($numRecs >= 1) {
                        $checkRecsQuery = "SELECT * from recs where recName is not null and uid = ".$updateRow['uid'];
                        $checkRecsData = mysqli_query($dbc, $checkRecsQuery);
                        if (mysqli_num_rows($checkRecsData) >= $numRecs) {
                            mysqli_query($dbc, "UPDATE applicant SET appStatus = 2 WHERE uid = ".$updateRow['uid']);
                        }
                    }
                }
            }

            if ($row['type'] == 3 || $row['type'] == 6 || $row['type'] == 7 || $row['type'] == 9) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
    <div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">User Id</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Email Address</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE appStatus = 2 AND applicant.uid NOT IN
            (SELECT studentuid FROM recReview WHERE recReview.uid = ".$_SESSION['uid'].")";
        $data = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($data)) {
        ?>
            <form method="POST" action="review.php">
                <tr>
                    <th scope="row"><?php echo $row['uid']; ?>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"></td>
                    <td><button type="submit" name="review" class="btn btn-primary">Review</button></td>
                </tr>
            </form>
            <?php
        }
        ?>
        </tbody>
    </table>
    </div>

    <?php

            }
            else if ($row['type'] == 1) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
    <div class="container">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">User Id</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email Address</th>
            <th scope="col">Application Status</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE appStatus = 2 OR appStatus = 1";
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentuid = ".$row['uid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);
    ?>
        <tr>
            <th scope="row"><?php echo $row['uid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php if ($row['appStatus'] == 1) echo "Incomplete"; else echo "Complete"; ?></td>
            <form method="POST" action="transcriptUpdate.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary">Update</button></td>
            </form>
            <?php
                if ($subrow['count'] >= 3) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php }
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
            </form>
            <?php } ?>
        </tr>
        
    
    <?php    
    }       
    ?>
    </tbody>
    </table>
    </div> 
    <?php
            }
            else if ($row['type'] == 2) {
                ?>
                <!-- HEADER -->
                <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
                    <div class = "container h-100">
                        <div class = "row h-100 align-items-center">
                            <div class = "col-lg-12">
                                <h1 class = "display-4 text-center text-white mt-5 mb-2">Current Applications</h1>
                            </div>
                        </div>
                    </div>
                </header>
                <?php
                // staff is cac; can make decision if application is ready

    ?>

    <div class="container">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">uid</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email Address</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM people JOIN applicant ON people.uid = applicant.uid WHERE appStatus = 2";
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentuid = ".$row['uid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);
        
        $reviewedSub = "SELECT * FROM reviewForm WHERE studentuid = ".$row['uid']." AND uid = ".$_SESSION['uid'];
        $reviewedData = mysqli_query($dbc, $reviewedSub);
    ?>
        <tr>
            <th scope="row"><?php echo $row['uid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <?php if (mysqli_num_rows($reviewedData) == 0) {?>
            <form method="POST" action="review.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary">Review</button></td>
            </form>
            <?php
                }
                else {
                    ?>
                    <form method="POST" action="review.php">
                    <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="update" class="btn btn-primary" disabled>Review</button></td>
                    </form>
                    <?php }
                if ($subrow['count'] >= 3) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php } 
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="uid" value="<?php echo $row['uid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
            </form>
            <?php } ?>
        </tr>
        
    
    <?php
    
    }
                
    ?>
    </tbody>
    </table>
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