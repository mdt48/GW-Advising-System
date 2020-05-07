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
	<script src="./functions.js" ></script>
</head>
<?php 
	require_once('connectvars.php');
	session_start();
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$uid = $_SESSION['uid'];
	$title = $_SESSION['type'];
?>
<body id="body"> 
	<script> 
		window.onload = function() {
            var uType = '<?php echo $title;?>';
         
			if (uType === 'admin'){	
			    $('.adm').hide();
			} else {
                $('.gs').hide();
            }

		}; 
	</script>   
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" index="test" href="./index.php">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			  <!-- Admin tabs -->
			
			<li class="nav-item">
				<a class="nav-link adm" id= "test" href="./all_accounts.php">View All Accounts</a>
			  </li>
            <!-- GS -->
            <li class="nav-item">
            <a class="nav-link gs" id= "test" href="./view_all_students.php">View All Students</a>
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
		  <form class="form-inline">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" onkeyup="search_all()" id= "search_bar" aria-label="Search">
		</form> 
		  </div>
		  
	  </nav>
	  <!-- end of nav -->
	  <div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Students:</h1>			</div>
		</div>
    </div>
	  
	</script>
	  <!-- F1 -->
	  <table class="table tab1" id="tab1">
		<thead>
		  <tr>
			<th scope="col">User id</th>
			<th scope="col">Name</th>
			<th scope="col">Program</th>
			<th scope="col">Departmnet</th>
			<th scope="col">Address</th>
			<th scope="col">Email</th>
			<th scope="col">Form 1</th>	
			<th scope='col'>Thesis</th>
			<th scope='col'>Approve Graduation</th>
			<th scope='col'>Assign Advisor</th>
			<th scope="col">Edit User Details</th>	
		  </tr>
		</thead>

		<tbody id="tab1-body">
			<?php
				//UID will be from session, change once login completed
				// $UID = $_SESSION['uid'];
				
				$query = "select * from people join student on student.uid = people.uid";
				// print($query);
				if ($result = $dbc->query($query)){
					if ($nr = $result->num_rows){
						$i = 1;
						while ($row = $result->fetch_object()){
							// only show if current student					
								echo "<tr class='tab_row'>";
									echo "<th scope='row'>{$row->uid}</th>";
										echo "<td>{$row->fname} {$row->lname}</td>";
										echo "<td>{$row->program}</td>";
										echo "<td>{$row->department}</td>";
										echo "<td>{$row->address}</td>";
										echo "<td>{$row->email}</td>";

										$form_query = "select * from form where uid='$row->uid'";
										if ($form_result = $dbc ->query($form_query)) {
											if (($nr = mysqli_num_rows($form_result)) != 0) {
												echo
													"<td> 
														<button type='submit' onclick='viewF1({$row->uid}, true);'class='btn btn-primary btn-md float-left f1' id='btnLogin'>View F1</button>
													</td>";
											} else {
												echo "<td> No F1 Submitted</td>";
											}
										}

									
										if (strcmp($row->program, "phd")== 0) {
											if (!$row->thesis){
												
												echo "<td><div class='dropdown'>";
												
													echo "<button class='btn btn-primary dropdown-toggle' id='menu1' type='button' data-toggle='dropdown'>Approve/Disapprove";
													echo "<span class='caret'></span></button>";
													echo "<ul class='dropdown-menu' role='menu' aria-labelledby='menu1'>";
													echo "<button type='submit class='btn btn-primary btn-md float-left f1' value= '$row->uid' id='approve'><li role='presentation'></li>Approve</button>";
													echo "<button type='submit id='disapprove' value= '$row->uid'><li role='presentation'>Disapprove</li></button>";
													echo "</ul>";
													echo "</div> </td>";
											} 
											else {
												echo "<td>Thesis Already Approved</td>";
											}
										} else {
											echo "<td>N/A for Masters Students</td>";
										}

										if (strcmp($row->grad_status, "f1") == 0 && $row->audited){
											echo
											"<td> 
												<button type='submit' onclick='approveGrad({$row->uid});'class='btn btn-primary btn-md float-left f1' id='grad'>Approve Grad</button>
											</td>";
										} 
										else if  (!$row->audited){
											echo
												"<td> 
													Must Have F1 Submitted/Audited
												</td>";
										} else if ($row->grad_year != null) {
											echo
											"<td> N/A for Alumni</td>";
										}


										$q = "select staff.uid, type,  fname, lname from people join staff on people.uid = staff.uid where staff.type = 4 or staff.type = 6";

										
										if ($result2 = $dbc->query($q)){	
											 if ($row->grad_year == null) {
												echo "<td>";
												
													echo "<div class='dropdown'>";
														
															echo "<button class='btn btn-primary dropdown-toggle' id='menu1' type='button' data-toggle='dropdown'>Set Advisor";
															echo "<span class='caret'></span></button>";
															echo "<ul class='dropdown-menu' role='menu' aria-labelledby='menu1'>";
															while ($row2 = $result2->fetch_object()) {
																if ($row2->type == 1 || $row2->type == 0) {
																	continue;
																}
																$id = $row2->uid;
																$name = $row2->fname . " " . $row2->lname;
																
																echo "<a onclick='assignAdvisor({$row->uid}, {$id})' data-value='$id' href='#'>$name</a>";
																
															}
															echo "</ul>";
															echo "</div>";
														echo "</td>";
											} else {
												echo "<td> N/A for Alumni</td>";
											}
											
										}

										echo "<td><button type='submit id='udetails' onclick='redirect({$row->uid}, \"{$row->program}\");' class='btn btn-primary btn-md float-left f1' >Edit User Details</li></button></td>";

										
							$i++;
						}
					}
				}
			?>
			</tbody>
	</table>
	
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">Staff:</h1>			</div>
		</div>
    </div>
	<table class="table tab2" id="tab2">
		<thead>
		  <tr >
			<th scope="col">User id</th>
			<th scope="col">Name</th>
			<th scope="col">Title</th>
			<th scope="col">Department</th>
			<th scope="col">Address</th>
			<th scope="col">Email</th>	
			<th scope="col">Edit User Details</th>	
		  </tr>
		</thead>

		<tbody id="tab2_body">
			<?php
				//UID will be from session, change once login completed
				// $UID = $_SESSION['uid'];
				
				$query = "select * from staff join people on staff.uid = people.uid";
				// print($query);
				if ($result = $dbc->query($query)){
					if ($nr = $result->num_rows){
						$i = 1;
						while ($row = $result->fetch_object()){
							// only show if current student							
								echo "<tr class='tab_row'>";
									echo "<th scope='row'>{$row->uid}</th>";
										echo "<td>{$row->fname} {$row->lname}</td>";
										echo "<td>{$row->type}</td>";
										echo "<td>{$row->department}</td>";
										echo "<td>{$row->address}</td>";
										echo "<td>{$row->email}</td>";
										echo "<td><button type='submit id='udetails' class='btn btn-primary btn-md float-left f1' onclick='redirect({$row->uid}, \"{$row->type}\");'>Edit User Details</li></button></td>";
						}
					}
				}
			?>
			</tbody>
	</table>
</body>

</html>
