<!DOCTYPE html>
<html>
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">
<title> GW Graduate Program - View Current Applications </title>
</head>

<body data-gr-c-s-loaded = "true">

<?php
  // Start the session
   session_start();

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

            // update all applications if complete
            $updateQuery = "SELECT * FROM users JOIN applicant ON users.gwid = applicant.gwid WHERE appStatus = 1";
            $updateData = mysqli_query($dbc, $updateQuery);
            while ($updateRow = mysqli_fetch_array($updateData)) {
                if ($updateRow['transcript'] == 1) {
                    $checkRecsQuery = "SELECT * FROM users JOIN recs ON users.gwid = recs.gwid WHERE users.gwid = ".$updateRow['gwid']." AND recName IS NOT NULL AND job IS NOT NULL AND
                        relation IS NOT NULL AND recs.email IS NOT NULL AND content IS NOT NULL AND org IS NOT NULL";
                    $checkRecsData = mysqli_query($dbc, $checkRecsQuery);
                    if (mysqli_num_rows($checkRecsData) >= 3) {
                        mysqli_query($dbc, "UPDATE applicant SET appStatus = 2 WHERE gwid = ".$updateRow['gwid']);
                    }
                }
            }

            if ($row['facultyType'] == 0) {
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
                // Faculty is a reviewer; default case (only allowed to review)
        

    ?>
    <div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">GWID</th>
                <th scope="col">Last Name</th>
                <th scope="col">First Name</th>
                <th scope="col">Email Address</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM users JOIN applicant ON users.gwid = applicant.gwid WHERE appStatus = 2 AND applicant.gwid NOT IN
            (SELECT studentGwid FROM recReview WHERE recReview.gwid = ".$_SESSION['gwid'].")";
        $data = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($data)) {
        ?>
            <form method="POST" action="review.php">
                <tr>
                    <th scope="row"><?php echo $row['gwid']; ?>
                    <td><?php echo $row['lname']; ?></td>
                    <td><?php echo $row['fname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"></td>
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
            else if ($row['facultyType'] == 1) {
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
                // Faculty is graduate secretary; can edit application, not review
    
    ?>

    <div class="container">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">GWID</th>
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
    $query = "SELECT * FROM users JOIN applicant ON users.gwid = applicant.gwid WHERE appStatus = 2 OR appStatus = 1";
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentGwid = ".$row['gwid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);
    ?>
        <tr>
            <th scope="row"><?php echo $row['gwid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php if ($row['appStatus'] == 1) echo "Incomplete"; else echo "Complete"; ?></td>
            <form method="POST" action="transcriptUpdate.php">
            <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="update" class="btn btn-primary">Update</button></td>
            </form>
            <?php
                if ($subrow['count'] >= 3) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php }
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
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
            else if ($row['facultyType'] == 2) {
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
                // faculty is cac; can make decision if application is ready

    ?>

    <div class="container">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">GWID</th>
            <th scope="col">Last Name</th>
            <th scope="col">First Name</th>
            <th scope="col">Email Address</th>
            <th scope="col"></th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM users JOIN applicant ON users.gwid = applicant.gwid WHERE appStatus = 2";
    $data = mysqli_query($dbc, $query);
    while ($row = mysqli_fetch_array($data)) {
        $sub = "SELECT COUNT(*) AS 'count' FROM reviewForm WHERE studentGwid = ".$row['gwid'];
        $subdata = mysqli_query($dbc, $sub);
        $subrow = mysqli_fetch_array($subdata);
        
        $reviewedSub = "SELECT * FROM reviewForm WHERE studentGwid = ".$row['gwid']." AND gwid = ".$_SESSION['gwid'];
        $reviewedData = mysqli_query($dbc, $reviewedSub);
    ?>
        <tr>
            <th scope="row"><?php echo $row['gwid']; ?></th>
            <td><?php echo $row['lname']; ?></td>
            <td><?php echo $row['fname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <?php if (mysqli_num_rows($reviewedData) == 0) {?>
            <form method="POST" action="review.php">
            <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="update" class="btn btn-primary">Review</button></td>
            </form>
            <?php
                }
                else {
                    ?>
                    <form method="POST" action="review.php">
                    <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="update" class="btn btn-primary" disabled>Review</button></td>
                    </form>
                    <?php }
                if ($subrow['count'] >= 3) {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="decide" class="btn btn-primary">Make Decision</button></td>
            </form>
            <?php } 
                else {
            ?>
            <form method="POST" action="decision.php">
            <td><input type="hidden" name="gwid" value="<?php echo $row['gwid']; ?>"><button type="submit" name="decide" class="btn btn-primary" disabled>Make Decision</button></td>
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