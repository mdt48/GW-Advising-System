<head>  
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
</head>
<!------ Include the above in your HEAD tag ---------->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" index="test" href="./staff_home.php">Home</a>
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
 <div class="container py-5">
    <div class="row">
        <div class="col-md-12">
		<div class="col-md-12 text-center mb-5">
			</div>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <!-- form card login -->
                    <div class="card rounded-0" id="login-form">
                        <div class="card-header">
                            <h3 class="mb-0">User Creation</h3>
                        </div>
                        <div class="card-body">
                            <form class="form" role="form" name="form" autocomplete="off" id="form" onsubmit="return validate()" method="POST">
                            <div class="form-group">
                                    <label for="uname1">UID</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="uid" id="uid" required="">
     
                                </div>
                                <div class="form-group">
                                    <label for="uname1">Username</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username" required="">
     
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password" required="">
                        
                                </div>
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="fname" required="">
                        
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="lname" required="">
                        
                                </div>
                                <div class="form-group">
                                    <label>Account Type</label>
                                    <select id="type" required>
                                        <option selected disabled>Please choose...</option>
                                        <option value="gs">Grad Secretary</option>
                                        <option value="fa">Faculty Advisor</option>
                                        <option value="admin">Admin</option>
                                        <option value="masters">Masters Student</option>
                                        <option value="phd">Doctoral Student</option>
                                    </select>  
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <select id="dep" required>
                                        <option selected disabled>Please choose...</option>
                                        <option value="CS">CS</option>
                                        <option value="!CS">!CS</option>
                                    </select>  
                                </div>
                                <!-- <div class="form-group">
                                    <label>Department</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="department" required="">                                 
                                </div> -->
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="address" required="">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="email" required="">
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right" name="btnLogin">Create User</button>
                            </form>
                                <script type="text/javascript"> 
                                    $( "#uid" ).attr("onkeypress", "return (event.charCode >= 48 && event.charCode <= 57)");
                                    $( "#username" ).attr("onkeypress", "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                                    $( "#password" ).attr("onkeypress", "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                                    $( "#fname" ).attr("onkeypress", "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                                    $( "#lname" ).attr("onkeypress", "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                                    $( "#address" ).attr("onkeypress", "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                                    $( "#email" ).attr("onkeypress", "return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123)");
                                    function validate() {
                                        var uid = document.forms["form"]["uid"].value;
                                        
                                        if (uid.length < 8 || uid.length > 8){
                                            $('#uid').val('');
                                            alert("Enter a valid ID of length 8")
                                            //event.preventDefault();
                                            return;
                                        }
                                        var uname = document.forms["form"]["username"].value;
                                        var pass = document.forms["form"]["password"].value;
                                        var fname = document.forms["form"]["fname"].value;
                                        var lname = document.forms["form"]["lname"].value;
                                        var acc = $("#type option:selected").val();
                                        var address = document.forms["form"]["address"].value;
                                        var email = document.forms["form"]["email"].value;
                                        var dep = $("#dep option:selected").val();

                                        var re = new RegExp("[a-zA-Z0-9_\\.\\+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-\\.]+");
                                        var bool = re.test(email.toLowerCase());
                                        if (!bool){
                                            alert("Invalid Email");
                                            return false;
                                        }

                                        

                                        $.ajax({
                                            url: "./add_user.php",
                                            type: "POST",
                                            data: {uid: uid, uname: uname, password: pass, fname: fname, lname: lname, accT: acc, add: address, em: email, dep: dep},
                                            success: function(data){
                                                alert("Account created succesfully");
                                                
                                                location.href = "./staff_home.php";
                                            }
                                        });
                                        event.preventDefault();
                                        location.href = "./staff_home.php";
                                    }
                                </script>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
