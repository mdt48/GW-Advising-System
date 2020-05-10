<!DOCTYPE html>

<html>  

<head>  
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<script src="./functions.js" ></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel = "stylesheet" href="/css/heroic-features.css" >

</head>
<?php 
session_start();
	$uid = $_SESSION['uid'];
?>
<body> 
<form method="post">
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" index="test" href="./index.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		  <ul class="navbar-nav mr-auto">
			  <!-- Grad Tabs -->
			  <li class="nav-item">
				<a class="nav-link grad" id= "test" href="apply_for_grad.php">Apply For Graduation</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link grad" id= "test" href="view_transcript.php">View Transcript</a>
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
	 
	
	</script>
	  <!-- F1 -->
	  <?php 
	  require_once("connectvars.php");
	  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	  $query = "SELECT * FROM form WHERE uid='$uid';";
	  $result = mysqli_query($dbc, $query);
	  $num_rows = mysqli_num_rows ($result);
	  if($num_rows != 0){
		?>
		
			<div class = "container h-100">
			<div class = "row h-100 align-items-center">
				<div class = "col-lg-12">
					<h1 class = "display-4 text-center text-black mt-5 mb-2">Form 1 Already Submitted!</h1>			</div>
			</div>
		</div>
		  
	 <?php 
	
	
	$uid = $_SESSION['uid'];
				$query = "SELECT grad_status FROM student WHERE uid='$uid';";
				$result = mysqli_query($dbc, $query);
				$row = mysqli_fetch_array($result);
				$gStat = $row['grad_status'];
				
				if(strcmp($gStat,"f1")==0){
					echo "Approved";
					echo "
							<br />
							<br />
							<button type='submit' class='btn btn-primary btn-md float-left f1' id='masters' name='masters' style='margin-right:20px;'>Apply For Masters</button>
							
							<button type='submit' class='btn btn-primary btn-md float-left f1' id='phd' name='phd'>Apply For PHD</button>
							";
				}else{
					
					echo "Form 1 not yet Approved or Denied. Check Back Later". $gStat;
				}
			?>
		</h1>
		<br />
				<?php	
					if(isset($_POST['masters'])){
						require_once("connectvars.php");
						$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
						if(!$dbc){
							die("could not connect");
						}
						$uid = $_SESSION['uid'];

						$query = "SELECT audited, program FROM student WHERE uid='$uid';";
						$result = mysqli_query($dbc, $query);
						$row = mysqli_fetch_array($result);
						if($row['audited']){
							echo '<script type="text/javascript">alert("You have already been audited");</script>';
							exit;
						}else if(strcmp($row['program'],"masters")!=0){
							echo '<script type="text/javascript">alert("You are not in the Masters program");</script>';
							exit;
						}
						
						//core courses
						$CSCI_6212 = false;
						$CSCI_6221 = false;
						$CSCI_6461 = false;

						$gpa_sum = 0.0;
						$credit_sum = 0;
						$numOutsideCS = 0;
						$numBs = 0;

						$query = "SELECT * FROM transcript join course on transcript.cid = course.cid WHERE uid='$uid' and course.department = transcript.subject;";
						$result = mysqli_query($dbc, $query);

						while($row = mysqli_fetch_array($result)){
							//core classes
							if(!$CSCI_6212){
								if(strcmp($row['department'],"CSCI")==0){
									if($row['cid']==6212){
										$CSCI_6212 = true;
									}
								}
							}
							if(!$CSCI_6221){
								if(strcmp($row['department'],"CSCI")==0){
									if($row['cid']==6221){
										$CSCI_6221 = true;
									}
								}
							}
							if(!$CSCI_6461){
								if(strcmp($row['department'],"CSCI")==0){
									if($row['cid']==6461){
										$CSCI_6461 = true;
									}
								}
							}

							//gpa calc
							$cid = $row['cid'];
							$dept = $row['department'];
							$grade = $row['grade'];

							if(strcmp($dept,"CSCI")!=0){
								$numOutsideCS++;
							}
		
							// $query = "SELECT credit FROM donotshowerror WHERE department='$dept' AND cid='$cid';";
							// $credit_res = mysqli_query($dbc, $query);
							// $credit_row = mysqli_fetch_array($credit_res);
							$credit = $row['credit'];

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
									$numBs++;
							}else if(strcmp($grade,"B-")==0){
									$gpa_sum += ($credit * 2.7);
									$numBs++;
							}else if(strcmp($grade,"C+")==0){
									$gpa_sum += ($credit * 2.3);
									$numBs++;
							}else if(strcmp($grade,"C")==0){
									$gpa_sum += ($credit * 2);
									$numBs++;
							}else if(strcmp($grade,"F")==0){
									//add zero
									$numBs++;
							}else{
								//invalid grade
							}



						}

						if($credit_sum!=0){
							$gpa = round(($gpa_sum)/($credit_sum),2);
						}else{
							$gpa = 0;
						}
						echo '<script type="text/javascript">alert("'.$numBs.'");</script>';
						if($CSCI_6212 && $CSCI_6221 && $CSCI_6461 && $gpa >= 3.0 && $credit_sum >= 30 && $numBs <= 2 && $numOutsideCS <=2){
							$query = "UPDATE student SET audited=1 WHERE uid='$uid';";
							mysqli_query($dbc, $query);
							echo '<script type="text/javascript">alert("The system has approved you for a Masters degree");</script>';
						}else{
							echo '<script type="text/javascript">alert("You have failed to reach Masters degree requirements");</script>';
							$error_msg = "Failed to meet degree requirements: ";
							if(!($CSCI_6212 && $CSCI_6221 && $CSCI_6461)){
								$error_msg .= "(Core CS classes not taken) ";
							}
							if(!($gpa>=3.0)){
								$error_msg .= "(GPA is too low) ";
							}
							if(!($credit_sum>=30)){
								$error_msg .= "(Not enough credits) ";
							}
							if(!($numBs<=2)){
								$error_msg .= "(Too many grades below B) ";
							}
							if(!($numOutsideCS<=2)){
								$error_msg .= "(Too many courses outside CS) ";
							}
							echo '<script type="text/javascript">alert("'.$error_msg.'");</script>';
						}

					}
					if(isset($_POST['phd'])){
						require_once("connectvars.php");
						$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		
						if(!$dbc){
							die("could not connect");
						}
						$uid = $_SESSION['uid'];

						$query = "SELECT audited, program, thesis FROM student WHERE uid='$uid';";
						$result = mysqli_query($dbc, $query);
						$row = mysqli_fetch_array($result);
						if($row['audited']){
							echo '<script type="text/javascript">alert("You have already been approved");</script>';
							exit;
						}else if(strcmp($row['program'],"phd")!=0){
							echo '<script type="text/javascript">alert("You are not in the PHD program");</script>';
							exit;
						} else if (!$row['thesis']){
							echo '<script type="text/javascript">alert("Youre thesis has not been approved");</script>';
							exit;
						}

						$gpa_sum = 0.0;
						$credit_sum = 0;
						$CS_credits = 0;
						$numBs = 0;

						$query = "SELECT * FROM transcript join course on transcript.cid = course.cid WHERE uid='$uid' and course.department = transcript.subject;";
						$result = mysqli_query($dbc, $query);

						while($row = mysqli_fetch_array($result)){
							//gpa calc
							$cid = $row['cid'];
							$dept = $row['department'];
							$grade = $row['grade'];

							// $query = "SELECT credit FROM donotshowerror WHERE department='$dept' AND cid='$cid';";
							// $credit_res = mysqli_query($dbc, $query);
							// $credit_row = mysqli_fetch_array($credit_res);
							$credit = $row['credit'];

							
							if(strcmp($grade,"IP")==0){	//do not count incomplete classes
								continue;
							}

							$credit_sum += $credit;
							if(strcmp($dept,"CSCI")==0){
								$CS_credits +=$credit;
							}

							//calc gpa
							if(strcmp($grade,"A")==0){
								$gpa_sum += ($credit * 4);
							}else if(strcmp($grade,"A-")==0){
									$gpa_sum += ($credit * 3.7);
							}else if(strcmp($grade,"B+")==0){
									$gpa_sum += ($credit * 3.3);
							}else if(strcmp($grade,"B")==0){
									$gpa_sum += ($credit * 3);
									$numBs++;
							}else if(strcmp($grade,"B-")==0){
									$gpa_sum += ($credit * 2.7);
									$numBs++;
							}else if(strcmp($grade,"C+")==0){
									$gpa_sum += ($credit * 2.3);
									$numBs++;
							}else if(strcmp($grade,"C")==0){
									$gpa_sum += ($credit * 2);
									$numBs++;
							}else if(strcmp($grade,"F")==0){
									//add zero
									$numBs++;
							}else{
								//invalid grade
							}

						}
						if($credit_sum!=0){
							$gpa = round(($gpa_sum)/($credit_sum),2);
						}else{
							$gpa = 0;
						}

						$query = "SELECT thesis FROM student WHERE uid='$uid';";
						$result = mysqli_query($dbc, $query);
						$row = mysqli_fetch_array($result);
						$thesis = $row['thesis'];
						
						
						if($gpa >= 3.5 && $credit_sum >=36 && $CS_credits >= 30 && $numBs <= 1 && $thesis){
							$query = "UPDATE student SET audited=1 WHERE uid='$uid';";
							mysqli_query($dbc, $query);
							echo '<script type="text/javascript">alert("The system has approved you for a PHD degree");</script>';
						}else{
							//echo '<script type="text/javascript">alert("You have failed to reach PHD degree requirements");</script>';
							$error_msg = "Failed to meet degree requirements: ";
							if(!($gpa >= 3.5)){
								$error_msg .= "(GPA is too low) ";
							}
							if(!($credit_sum >= 36)){
								$error_msg .= "(Not enough credits) ";
							}
							if(!($CS_credits>=30)){
								$error_msg .= "(Not enough CS credits) ";
							}
							if(!($numBs <= 1)){
								$error_msg .= "(Too many grades below B) ";
							}
							if(!($thesis)){
								$error_msg .= "(Thesis not approved) ";
							}
							echo '<script type="text/javascript">alert("'.$error_msg.'");</script>';
						}

					}
	} else {?>
		<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-black mt-5 mb-2">Step 1: Complete Form 1</h1>			</div>
		</div>
    </div>
	  <table class="table" id="tab">
		<thead>
		  <tr>
			<th scope="col">Course #</th>
			<th scope="col">Course ID</th>
		  </tr>
		</thead>
		<tbody>
		  <tr>
			<th scope="row">1</th>
			<td>
				<div class="form-group row">
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c1">
					</div>
				  </div>
			</td>
		  </tr>
		  <tr>
			<th scope="row">2</th>
			<td>
				<div class="form-group row">
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c2">
					</div>
				  </div>
			</td>
			<tr>
				<th scope="row">3</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c3">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
				<th scope="row">4</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c4">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
				<th scope="row">5</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c5">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
			<th scope="row">6</th>
			<td>
				<div class="form-group row">
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c6">
					</div>
				  </div>
			</td>
		  </tr>
		  <tr>
			<th scope="row">7</th>
			<td>
				<div class="form-group row">
					<div class="col-sm-10">
					  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c7">
					</div>
				  </div>
			</td>
			<tr>
				<th scope="row">8</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c8">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
				<th scope="row">9</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c9">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
				<th scope="row">10</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c10">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
				<th scope="row">11</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c11">
						</div>
					  </div>
				</td>
			  </tr>
			  <tr>
				<th scope="row">12</th>
				<td>
					<div class="form-group row">
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Course ID" name="c12">
						</div>
					  </div>
				</td>
			  </tr>
		  </tr>
		</tbody>
	  </table>
	  <button type="submit" class="btn btn-primary btn-md float-left f1" id="btnLogin" name="btnLogin">Submit Form 1</button>


			  <?php
			  require_once("connectvars.php");
			  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			  if(!$dbc){
				die("could not connect");
			}
			  		if(isset($_POST['btnLogin'])){
						$uid = $_SESSION['uid'];

						$query = "SELECT * FROM form WHERE uid='$uid';";
						$result = mysqli_query($dbc, $query);
						$num_rows = mysqli_num_rows ($result);
						
						if($num_rows != 0){
							
							echo '<script type="text/javascript">alert("You have already submitted form 1");</script>';
							
						}else{
							$query = "SELECT advisoruid FROM student WHERE uid='$uid';";
							$result = mysqli_query($dbc, $query);

							if(!$result){
								echo "query failed";
							}

							$row = mysqli_fetch_array($result);
							$fid = (int) $row['advisoruid'];
							

							$classes = array('c1','c2','c3','c4','c5','c6','c7','c8','c9','c10','c11','c12');

							foreach($classes as $i){
								$in = $_POST[$i];
								/*$dept = substr($in,0,4);
								$cid = (int) substr($in,5);*/

								$space = strpos($in," ");
								$dept = substr($in,0,$space);
								$cid = (int) substr($in,($space+1));

								//echo "$dept";
								//echo "$cid";
								$query = "INSERT INTO form VALUES ($uid,'$dept', $cid);";
								
								
								if (mysqli_query($dbc, $query)) {
									echo '<script type="text/javascript">alert("Successfully Added");</script>';
								} else {
									//echo "Error: " . $query . "<br>" . mysqli_error($dbc);
									if(strcmp($dept,"")!=0){
										//echo "ERROR: $dept $cid is not a class <br>";
										echo '<script type="text/javascript">alert("ERROR: '.$dept.' '.$cid.' is not a class");</script>';
									break;
										// echo $query;

									}
								}
							}							
						}
			   	}
			  ?>
		<br />
		<br />
		<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Form1 1 Status:</h1>			</div>
		</div>
    </div>
			<?php
				require_once("connectvars.php");
				$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

				if(!$dbc){
					die("could not connect");
				}
				
				}
				?>
		

</form>
</body>

</html>