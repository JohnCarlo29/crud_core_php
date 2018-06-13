<?php
	require 'config.php';

	$infos = get_infos($conn);

	if(isset($_POST['submit'])){
		$fname = mysqli_real_escape_string($conn, $_POST['fname']);
		$lname = mysqli_real_escape_string($conn, $_POST['lname']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);	

		if(trim($fname) == "" || trim($lname) == "" || trim($email) == "" || trim($address) == ""){
			echo '<script>alert("Please fill up all the fields");</script>';
		}else{
			$sql = "Insert into info (firstname, lastname, email, address) VALUES (?,?,?,?)";
						
			//create a prepared statement
			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $sql)) {

			    /* bind parameters for markers */
			    mysqli_stmt_bind_param($stmt, "ssss", $fname,$lname,$email,$address);

			    /* execute query */
			    echo (mysqli_stmt_execute($stmt))?"<script>alert('Sucessfully added');</script>":"<script>alert('Failed to add');</script>"; 
			}		
		}
	}

	function get_infos($conn){
		$results = [];
		$sql = "Select * from info";
		$query = mysqli_query($conn, $sql);
		if($query){
			while($row = mysqli_fetch_assoc($query)){
				array_push($results, $row);
			}

			return $results;
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
		<h1 class="text-center">Basic Crud in Core PHP</h1>
		<div class="card">
			<div class="card-header">
				People
				<div class="float-sm-right">
					<button class="btn btn-warning text-white" data-toggle="modal" data-target="#myModal">New Person</button>
				</div>
			</div>
			<div class="card-body">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Email</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($infos as $info) { ?>
						<tr>
							<td><?=$info['firstname'];?></td>
							<td><?=$info['lastname'];?></td>
							<td><?=$info['email'];?></td>
							<td><?=$info['address'];?></td>
							<td>
								<a href="edit.php?id=<?=$info['id'];?>">
									<button class="btn btn-sm btn-info">
										<i class="fas fa-edit"></i>
									</button>
								</a>
								<a href="delete.php?id=<?=$info['id'];?>">
									<button class="btn btn-sm btn-danger">
										<i class="fas fa-trash-alt"></i>
									</button>
								</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Person</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form method="post">
					<div class="modal-body">
						<div class="form-group">
							<label>Firstname</label>
    						<input type="text" class="form-control" name="fname" placeholder="Firstname">
						</div>
						<div class="form-group">
							<label>Lastname</label>
    						<input type="text" class="form-control" name="lname" placeholder="Lastname">
						</div>
						<div class="form-group">
							<label>Email</label>
    						<input type="email" class="form-control" name="email" placeholder="Email">
						</div>
						<div class="form-group">
							<label>Address</label>
    						<input type="text" class="form-control" name="address" placeholder="Address">
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" name="submit" class="btn btn-primary">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</body>
</html>