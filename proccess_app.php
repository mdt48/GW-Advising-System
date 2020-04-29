<?php // start session, connect to database
				require_once('connectvars.php'); session_start(); $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); ?>
<!DOCTYPE html>

<html>  

<head>  
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel = "stylesheet" href="/css/heroic-features.css" >
<link rel="stylesheet" type="text/css" href="style.css">	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
</head>
<?php 
	$uid = $_SESSION['uid'];
	$title = $_SESSION['title'];
?>
<body> 
	<script> 
		window.onload = function() {
			var uType = localStorage.getItem("userType");
			switch (uType) {
				case '0':
					$('.grad').hide();
					$('.phd').hide();
					$('.gs').hide();
					$('.fa').hide();
					$('.alumn').hide();
					break;
				case '1':
					$('.adm').hide();
					$('.phd').hide();
					$('.gs').hide();
					$('.fa').hide();
					$('.alumn').hide();
					break;
				case '2':
					$('.grad').hide();
					$('.adm').hide();
					$('.gs').hide();
					$('.fa').hide();
					$('.alumn').hide();
					break;
				case '3':
					$('.grad').hide();
					$('.adm').hide();
					$('.phd').hide();
					$('.fa').hide();
					$('.alumn').hide();
					break;
				case '4':
					$('.grad').hide();
					$('.adm').hide();
					$('.phd').hide();
					$('.gs').hide();
					$('.alumn').hide();
					break;
				case '5':
					$('.grad').hide();
					$('.adm').hide();
					$('.phd').hide();
					$('.gs').hide();
					$('.fa').hide();
					break;
			}

		}; 
	</script> 
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" index="test" href="./st_home.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<!-- Admin tabs -->
			  <li class="nav-item">
				<a class="nav-link adm" id= "test" href="./create_account.html">Create New Account</a>
			  </li>
			  <li class="nav-item">
				  <a class="nav-link adm" id= "test" href="./all_accounts.html">View All Accounts</a>
				</li>
				<!-- Grad Tabs -->
				<li class="nav-item">
				  <a class="nav-link grad" id= "test" href="./apply_for_grad.html">Apply For Graduation</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link grad" id= "test" href="./view_transcript.html">View Transcript</a>
				</li>
				<!-- PHD -->
				<li class="nav-item">
				  <a class="nav-link phd" id= "test" href="./apply_for_grad.html">Apply For Graduation</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link phd" id= "test" href="./view_transcript.html">View Transcript</a>
				</li>
				<!-- GS -->
				<li class="nav-item">
				  <a class="nav-link gs" id= "test" href="./proccess_app.php">Process Graduation Applications</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link gs" id= "test" href="./view_all_students.php">View All Students</a>
				</li>
				<!-- FA -->
				<li class="nav-item">
				  <a class="nav-link fa" id= "test" href="./approve_thesis.html">Approve Pending Thesis</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link fa" id= "test" href="./view_all_students.php">View All Students</a>
				</li>
				<!--Alumn  -->
				<li class="nav-item">
				  <a class="nav-link alumn grad phd" id= "test" href="./personal_info.html">Edit Personal Info</a>
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
	  <!-- end of nav -->
	  <h1> <span class="badge badge-primary">Applications for Approval</span></h1>
	  <h3> <span class = "badge">All students shown have had their Form 1 approved, thesis(if necessary) and have passed the system audit</span></h3>
	</script>


		<table class="table" id="tab1">
			<thead>
			<tr>
				<th scope="col">App #</th>
				<th scope="col">User ID</th>
				<th scope="col">Name</th>
				<th scope="col">Program</th>
				<th scope="col">Department</th>
				<th scope="col">Approve</th>	
			</tr>
			</thead>

			<tbody>
				<?php
					//UID will be from session, change once login completed
					// $UID = $_SESSION['uid'];
					$UID = 0;
					$query = "select * from staff where advisoruid = '$UID'";
					$title;
					if ($result = $dbc->query($query)) {
						while ($row = $result->fetch_object()){
							$title = $row->title;
						}
					}
					
					$query = "select * from student where audited = true and grad_status = 'f1'";
					
					

					if ($result = $dbc->query($query)){
						if ($nr = $result->num_rows){
							$i = 1;
							while ($row = $result->fetch_object()){
								echo "<tr>";
									echo "<th scope='row'>{$i}</th>";
										echo "<td>{$row->uid}</td>";
										echo "<td>{$row->fname} {$row->lname}</td>";
										echo "<td>{$row->program}</td>";
										echo "<td>{$row->department}</td>";
										echo
											"<td> 
												<button type='submit' onclick='approve({$row->uid});'class='btn btn-primary btn-md float-left f1' id='btnLogin'>Approve For Graduation</button>
											</td>";
								echo "</tr>";
								$i++;
							}
						}
					}
				?>
				
			</tbody>
		</table>
		
		<script type='text/javascript'>
			function approve(id){
				$.ajax({
					url: "./query_runner.php",
					type: "POST",
					data: {uid: id, type: "approve"},
					success: function(data){
						alert("Student Graduated!")
						}
					});
			}
			function addElement({pID, tag, id, scope, inner, cls}={}) {
				var parent = document.getElementById(pID);
				var child = document.createElement(tag);
				if (cls != null){
					child.setAttribute('class', cls);
				}
				if (id != null){
					child.setAttribute('id', id);
				}
				if (scope != null){
					child.setAttribute('scope', scope);
				}
				if (inner != null){
					child.innerHTML = inner;
				}
				parent.appendChild(child);
				return;
			}
		</script>
</body>

</html>