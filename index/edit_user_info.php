<!DOCTYPE html>

<html>  

<head>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
	<script src="./functions.js" ></script>
</head>
<?php 
session_start();
	$uid = $_SESSION['uid'];
	//$title = $_SESSION['title'];
    $style = "";
	$title;
	$home_link;
	if(isset($_SESSION['alumn'])){
		$style = "style='display:none;'";
		
    } 
    if(isset($_SESSION['program'])){
		$title = $_SESSION['program'];
		$home_link = "./student_home.php";
	} else {
		$title = $_SESSION['type'];
		$home_link = "./staff_home.php";
    }
?>
<body id= "body"> 
	</script> 
	<nav class="navbar navbar-ex pand-lg navbar-light bg-light">
		<a class="navbar-brand" index="test" href=<?php echo $home_link ?>>Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
	  
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<!-- Grad Tabs -->
				<li class="nav-item">
				  <a class="nav-link grad" id= "test" href="./apply_for_grad.php" <?php echo $style;?>>Apply For Graduation</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link grad" id= "test" href="./view_transcript.php">View Transcript</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link button" id= "Edit Info" href="#" onclick=''>Edit Info</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" id= "Logout" href="#" onclick="return logout()">Logout</a>
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
	  
</body>

</html>

<script type="text/javascript"> 
			$(document).ready(function(){
				var type = <?php echo json_encode($title);?>;

				$.ajax({
						url: "./view_user_account.php",
						type: "POST",
						data: {uid: <?php echo $uid?>, type: type},
						success: function(data){
							
							// Parse input from ajax request into something iterable
							data = JSON.parse(data);
                            console.log(data);
							const keys = Object.keys(data[0]);

							// Create form 
							var body = document.getElementsByTagName("BODY")[0];
							var body_id = body.id;
							addElement({pID: body_id, tag: "form",id: "form"});
							
							// add necessary elements
							for (var i = 0; i < keys.length; i++) {
								var k = keys[i];
								var f_id = "f_" + i.toString();
								var l_id = "l_" + i.toString();
								var l_text = getLabelText(k);
								console.log(k);
								addElement({pID: "form", tag: "div", cls: "for-group", id: f_id});
								addElement({pID: f_id, tag: "label", inner: l_text, for: i, id: l_id});
								addElement({pID: f_id, tag: "input", cls: "form-control", id: i});
								
								
								var pholder = data[0][k];
								console.log("key" + k);
								if (!pholder) {
									pholder = "No";
								}
								if (k === "pass"){
									console.log("hi");
									document.getElementById(i).setAttribute("type", "password");
								}
								document.getElementById(i).setAttribute('placeholder', pholder);
								document.getElementById(i).setAttribute('onkeypress', "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
							}
							document.getElementById(0).setAttribute('readonly', true);
							
                            
                                                
							addElement({pID: "form", tag: "button", cls: "btn btn-primary btn-md float-left f1", id: "submit_user_info", type: "submit", inner: "Save and Exit"});
                            $("#submit_user_info").click( function(){
                                var dict = [{}];
								var obj = {};
								var inputValues = $( ".form-control" );
								for (var i = 0; i < keys.length; i++) {
									var key2 = keys[i];
									var inp = inputValues[i].value;
									if (inp === "") {
										inp = inputValues[i].placeholder;
									}
									obj[key2] = inp;
									
								}
								dict.push(obj);
								var y = dict[1]['title'];
                                
								$.ajax ({
									url: "./update_user_info.php",
									type: "POST",
									data: {data: dict, type: type},
									success: function(data){
										alert("Successfully updated");
                                        event.preventDefault();
                                        if (type === 4 || type === 1){
                                            location.href = "./staff_home.php";
                                        }
                                        else {
                                            location.href = "./student_home.php";
                                        }
							            
									}
								});
                            });
							

						}
					});
			});

			// function addElement({parent, pID, tag, id, scope, inner, cls, type, fr}={}) {
			// 	if (parent == null){
			// 		var parent = document.getElementById(pID);
			// 	}
				
			// 	var child = document.createElement(tag);
			// 	if (cls != null){
			// 		child.setAttribute('class', cls);
			// 	}
			// 	if (id != null){
			// 		child.setAttribute('id', id);
			// 	}
			// 	if (scope != null){
			// 		child.setAttribute('scope', scope);
			// 	}
			// 	if (inner != null){
			// 		child.innerHTML = inner;
			// 	}
			// 	if (fr != null){
			// 		child.setAttribute('for', fr);
			// 	}
			// 	parent.appendChild(child);
			// 	return;
			// }

			// function getLabelText(label) {
			// 	switch (label) {
			// 		case "uid":
			// 			return "UID: ";
			// 			break;
			// 		case "uname":
			// 			return "Username: ";
			// 			break;
			// 		case "fname":
			// 			return "First Name: ";
			// 			break;
			// 		case "lname":
			// 			return "Last Name: ";
			// 			break;
			// 		case "email":
			// 			return "Email: ";
			// 			break;
			// 		case "grad_status":
			// 			return "Grad Status: ";
			// 			break;
			// 		case "thesis":
			// 			return "Thesis: ";
			// 			break;
			// 		case "audited":
			// 			return "Audited: ";
			// 			break;
			// 		case "program":
			// 			return "Program: ";
			// 			break;
			// 		case "dep":
			// 			return "Department: ";
			// 			break;
			// 		case "add":
			// 			return "Address: ";
			// 			break;
			// 		case "Title":
			// 			return "Titel: ";
			// 			break;
			// 	}
			// }
</script>