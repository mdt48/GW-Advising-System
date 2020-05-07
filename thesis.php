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
      
      <div class = "container h-100">
		<div class = "row h-100 align-items-center">
			<div class = "col-lg-12">
				<h1 class = "display-4 text-center text-black mt-5 mb-2">View/Edit Thesis</h1>			</div>
		</div>
    </div>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">Thesis</span>
            <button type="submit" class="btn btn-primary btn-md float-left f1" id="save" name="btnLogin">Save/Exit</button>
        </div>
        <textarea class="form-control" id="thesis" maxlength="250" placeholder = "MAX 250 Chars" aria-label="With textarea"></textarea>
    </div>
</div>

<script>
    $( "#save" ).click(function() {
        alert("hellp");
        var thesis = $('#thesis').val();
        $.ajax({
        url: "./insertThesis.php",
        type: "POST",
        data: {uid: <?php echo $uid; ?>, thesis: thesis},
        success: function(data){
            
        }
        });
    });
</script>
	
	
</body>

</html>