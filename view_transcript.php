<!DOCTYPE html>

<html>  
<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
</head>
<?php 
session_start();
	$uid = $_SESSION['uid'];
	$program = $_SESSION['program'];
	$style = "";
	if(isset($_SESSION['alumn'])){
		$style = "style='display:none;'";
	} 
?>
<body> 
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" index="test" href="./student_home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav mr-auto">
			  <!-- Grad Tabs -->
			  <li class="nav-item">
				<a class="nav-link grad" id= "test" href="apply_for_grad.php" <?php echo $style;?>>Apply For Graduation</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link grad" id= "test" href="view_transcript.php">View Transcript</a>
			  </li>
			  <li class="nav-item">
				  <a class="nav-link button" id= "Edit Info" href="./edit_user_info.php" onclick=''>Edit Info</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id= "Logout" href="#"onclick="return logout()">Logout</a>
				</li>
				<script>
					function logout () {
						$.ajax({
							url: "./logout.php",
							type: "POST",
							data: {uid: '<?php echo $uid; ?>', type: "disapprove"},
							success: function(data){
								event.preventDefault();
								location.href = "./login.html";
							}
						});
					}
				</script>
			</ul>
		  </div>
		</nav>
	  </nav>
	  <!-- end of nav -->
	  <div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Transcript</h1>			</div>
		</div>
    </div>
	  
	</script>
	  <!-- F1 -->
	  <table class="table" id="tab">
		<thead>
		  <tr>
			<th scope="col">Course #</th>
            <th scope="col">Course ID</th>
            <th scope="col">Grade
		  </tr>
		</thead>
		<tbody>
		  
		  <?php

				//get all grades and iterate
				require_once("connectvars.php");
				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

				if(!$dbc){
					die("could not connect");
				}

				//make sure uid is a session variable
				//$uid = 1;
				$uid = $_SESSION['uid'];

				$query = "SELECT * FROM transcript WHERE uid='$uid';";
				


				if ($result = mysqli_query($dbc, $query)) {
					//echo "success";
			  } else {
					echo "Error: " . $query . "<br>" . mysqli_error($dbc);
			  }

			  $count = 1;
			  $gpa_sum = 0.0;
			  $credit_sum = 0.0;
				while($row = mysqli_fetch_array($result)){
					$cid = $row['cid'];
					$dept = $row['subject'];
					$grade = $row['grade'];

					$query = "SELECT credit FROM course WHERE department='$dept' AND cid='$cid';";
					$credit_res = mysqli_query($dbc, $query);
					$credit_row = mysqli_fetch_array($credit_res);
					$credit = $credit_row['credit'];

					if(strcmp($grade,"IP")==0){	//do not count incomplete classes
						continue;
					}

					$credit_sum += $credit;

					if(strcmp($grade,"A")==0){
							$gpa_sum += ($credit * 4);
			
					}else if(strcmp($grade,"A-")==0){
							$gpa_sum += ($credit * 3.7);
					}else if(strcmp($grade,"B+")==0){
							$gpa_sum += ($credit * 3.3);
					}else if(strcmp($grade,"B")==0){
							$gpa_sum += ($credit * 3);
					}else if(strcmp($grade,"B-")==0){
							$gpa_sum += ($credit * 2.7);
					}else if(strcmp($grade,"C+")==0){
							$gpa_sum += ($credit * 2.3);
					}else if(strcmp($grade,"C")==0){
							$gpa_sum += ($credit * 2);
					}else if(strcmp($grade,"F")==0){
							//add zero
					}else{
						//invalid grade
					}

					echo "	
						<tr>
							<th scope=row>$count</th>
							<td>$dept $cid</td>
							<td>$grade</td>
						</tr>
					";
					$count++;
				}
				if($credit_sum!=0){
					$gpa = round(($gpa_sum)/($credit_sum),2);
				}else{
					$gpa =0;
				}
				

		  ?>

		</tbody>
	  </table>
	  <h1><span class="badge badge-primary">Total GPA: <?php echo "$gpa"?> </span></h1>
</body>

</html>