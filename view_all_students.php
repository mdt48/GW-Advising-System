<?php // start session, connect to database
				require_once('connectvars.php'); session_start(); $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);?>
<!DOCTYPE html>

<html>  

<head>  
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<script src="./functions.js" ></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel = "stylesheet" href="/css/heroic-features.css" >
	<script src = "jquery.sortElements.js" type = "text/javascript"></script>
</head>
<?php 
	$uid = $_SESSION['uid'];
	$title = $_SESSION['type'];
?>
<body id="b"> 
	<script> 
		window.onload = function() {
            var uType = '<?php echo $title;?>';
         
			if (uType === 0){	
			    $('.gs').hide();
			} else {
                $('.adm').hide();
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
			  <a class="nav-link adm" id= "test" href="./create_account.php">Create New Account</a>
			</li>
			<li class="nav-item">
				<a class="nav-link adm" id= "test" href="./all_accounts.php">View All Accounts</a>
			  </li>
            <!-- GS -->
            <li class="nav-item">
            <a class="nav-link gs" id= "test" href="./view_all_students.php">View All Students</a>
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
		  <form class="form-inline">
			<input class="form-control mr-sm-2" type="search" placeholder="Search" onkeyup="search_students()" id= "search_bar" aria-label="Search">
		</form> 
		</div>
	  </nav>
	  <!-- end of nav -->
	  <header class = "bg py-5 mb-5" style = "background-color: #033b59;">
	<div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-white mt-5 mb-2">All Students</h1>			</div>
		</div>
    </div>
</header>

	</script>
	  <!-- F1 -->
	  <table class="table" id="tab1">
		<thead>
		  <tr>
			<th scope="col">User id</th>
			<th scope="col">Name</th>
			<th scope="col">Program</th>
			<th scope="col" id="major">Major</th>
			<th scope="col" id="ayear">Admit Year</th>
			<th scope="col">Transcript</th>
			<th scope="col">Form 1</th>	
			<th scope='col'>Thesis</th>
			<th scope='col'>Approve Graduation</th>
			<th scope='col'>Assign Advisor</th>
		  </tr>
		</thead>

		<tbody id="tbody">
			<?php
				//UID will be from session, change once login completed
				// $UID = $_SESSION['uid'];
				
					if ($title == 1) {
						$query = "select * from student join people on student.uid = people.uid order by student.uid";
					} else {
						$query = "select * from student join people on student.uid = people.uid where advisoruid = '$uid' order by student.uid";
					}
				
				

				

				if ($result = $dbc->query($query)){
					if ($nr = $result->num_rows){
						$i = 1;
						
						while ($row = $result->fetch_object()){
							// only show if current student						
								echo "<tr class= 'tab_row'>";
									echo "<th  scope='row'>{$row->uid}</th>";
										echo "<td>{$row->fname} {$row->lname}</td>";
										echo "<td>{$row->program}</td>";
										echo "<td>{$row->department}</td>";
										echo "<td>{$row->ayear}</td>";
										echo
											"<td> 
												<button type='submit' onclick='viewTrans({$row->uid});' class='btn btn-primary btn-md float-left f1' id='btnLogin'>View Transcript</button>
											</td>";
										// display f1 buttons
										
										// query form table
										$form_query = "select * from form where uid='$row->uid'";
										
										if ($form_result = $dbc ->query($form_query)) {
											if (($nr = mysqli_num_rows($form_result)) != 0 && $row->grad_year == null) { 
												echo
													"<td> 
														<button type='submit' onclick='viewF1({$row->uid}, true);' class='btn btn-primary btn-md float-left f1' id='btnLogin'>View F1</button>
													</td>";
											}else if ($row->grad_year != null) {
												echo "<td>N/A for Alumni</td>";
											} 
											else {
												echo "<td> No F1 Submitted</td>";
											}
										}
										
										// display thesis buttons
										if (strcmp($row->program, "phd") == 0) {
											
											if (!$row->thesis && $row->thesis != null){
												echo
												"<td> 
													<button type='submit'class='btn btn-primary btn-md float-left thesis' value= '$row->uid' id='thesis'>Approve Thesis</button>
												</td>";
											} 
											else if ($row->thesis == null){
												echo "<td>No Thesis submitted</td>";
											}
											else {
												echo "<td>Thesis Already Approved</td>";
											}
										} else if (strcmp($row->grad_status, "alumn") == 0) {
											echo "<td>N/A for Alumni</td>";
										}
										else {
											echo "<td>N/A for Masters Students</td>";
										}
										
										if ($title == 1) {
											if (strcmp($row->grad_status, "f1") == 0 && $row->audited){
												if (strcmp($row->program, "phd") == 0 && $row->thesis) {
													echo
												"<td> 
													<button type='submit' onclick='approveGrad({$row->uid});'class='btn btn-primary btn-md float-left f1' id='grad'>Approve Grad</button>
												</td>";
												}
												 
												if (strcmp($row->program, "masters") == 0){
													echo
												"<td> 
													<button type='submit' onclick='approveGrad({$row->uid});'class='btn btn-primary btn-md float-left f1' id='grad'>Approve Grad</button>
												</td>";
												}
												
											} 
											else if  (!$row->audited){
												echo
													"<td> 
														Must Have F1 Submitted/Audited
													</td>";
											} 
											else if (strcmp($row->grad_status, "alumn") != 0) {
												echo "<td>N/A for Alumni</td>";
											}
										} else {
											
											echo
													"<td> 
														Must be GS for Graduation Approval
													</td>";
										}
										$q = "select staff.uid, fname, lname from people join staff on people.uid = staff.uid where type = 4 or type = 6";
												
										//$result2 = $dbc->query($q);
								if ($result2 = $dbc->query($q)){	
									if ($title == 1) {	
									 if ($row->grad_year == null) {
										echo "<td>";
										
											echo "<div class='dropdown'>";
												
													echo "<button class='btn btn-primary dropdown-toggle' id='menu1' type='button' data-toggle='dropdown'>Set Advisor";
													echo "<span class='caret'></span></button>";
													echo "<ul class='dropdown-menu' role='menu' aria-labelledby='menu1'>";
													while ($row2 = $result2->fetch_object()) {
														$id = $row2->uid;
														$name = $row2->fname . " " . $row2->lname;
														
														echo "<a onclick='assignAdvisor({$row->uid}, {$id})' data-value='$id' href='#'>$name</a>";
														
													}
													echo "</ul>";
													echo "</div>";
												echo "</td>";
									} else {
										"<td> N/A for Alumni</td>";
									}
									} else {
										"<td> Cant assign advisor if FA</td>";
									}
								}

								echo "</tr>";
							$i++;
						}
					}
				}
			?>

		  	
		</tbody>
	  </table>  
</body>
<script> 


$(document).ready(function(){

     $('#thesis').bind("click",function(){
		var id = $('#thesis').val();
		$.ajax ({
			url: "./approve_thesis.php",
			type: "POST",
			data: {uid: id},
			success: function(data){
				window.location.reload(true); 
			}
		});
     });
});
</script>

<script language="javascript">
  var table = $('table');
    
    $('#major, #ayear')
        .wrapInner('<span title="sort this column"/>')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = false;
            
            th.click(function(){
                
                table.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            });
                
        });
</script>
</html>
