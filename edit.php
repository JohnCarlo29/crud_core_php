<?php
	require 'config.php';

	$data = [];

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql = "SELECT * from info where id = ?";			
		//create a prepared statement
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {

		    /* bind parameters for markers */
		    mysqli_stmt_bind_param($stmt, "i", $id);

		    /* execute query */
		    mysqli_stmt_execute($stmt);

		    mysqli_stmt_bind_result($stmt, $rid, $rfname, $rlname, $remail, $radd);

		    mysqli_stmt_fetch($stmt); 

		    array_push($data, $rid);
		    array_push($data, $rfname);
		    array_push($data, $rlname);
		    array_push($data, $remail);
		    array_push($data, $radd);
		}
	}

	if(isset($_POST['edit'])){
		$id = $data[0];
		$fname = mysqli_real_escape_string($conn, $_POST['fname']);
		$lname = mysqli_real_escape_string($conn, $_POST['lname']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);	

		if(trim($fname) == "" || trim($lname) == "" || trim($email) == "" || trim($address) == ""){
			echo '<script>alert("Please fill up all the fields");</script>';
		}else{
			$sql = "Update info  SET firstname=? , lastname=?, email=?, address=? WHERE id=?";
		
			//create a prepared statement
			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)) {

			    /* bind parameters for markers */
			    mysqli_stmt_bind_param($stmt, "ssssi", $fname,$lname,$email,$address,$id);

			    /* execute query */
			    echo (mysqli_stmt_execute($stmt))?"<script>alert('Sucessfully updated');window.location.href = 'index.php';</script>":"<script>alert('Failed to update');</script>"; 
			}		
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<title>CRUD Core PHP</title>
</head>
<body>
	<div class="container">
		<div class="col-md-5 offset-md-3">
			<div class="card">
				<div class="card-header">
					Edit
				</div>
				<div class="card-body">
					<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<label>Firstname</label>
    						<input type="text" class="form-control" name="fname" placeholder="Firstname" value= "<?=(!empty($data))?$data[1]:"";?>">
						</div>
						<div class="form-group">
							<label>Lastname</label>
    						<input type="text" class="form-control" name="lname" placeholder="Lastname" value= "<?=(!empty($data))?$data[2]:"";?>">
						</div>
						<div class="form-group">
							<label>Email</label>
    						<input type="email" class="form-control" name="email" placeholder="Email" value= "<?=(!empty($data))?$data[3]:"";?>">
						</div>
						<div class="form-group">
							<label>Address</label>
    						<input type="text" class="form-control" name="address" placeholder="Address" value= "<?=(!empty($data))?$data[4]:"";?>">
						</div>
						<button type="submit" name="edit" class="btn btn-primary">Edit</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>