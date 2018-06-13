<?php 
	require 'config.php';

	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sql = "DELETE from info where id = ?";			
		//create a prepared statement
		$stmt = mysqli_stmt_init($conn);
		if (mysqli_stmt_prepare($stmt, $sql)) {

		    /* bind parameters for markers */
		    mysqli_stmt_bind_param($stmt, "i", $id);

		    /* execute query */
		    if(mysqli_stmt_execute($stmt)){
		    	echo "<script>alert('Sucessfully delete');window.location.href = 'index.php';</script>";
		    }else{
		    	"<script>alert('Failed to delete');</script>";
		    }
		}
	}


?>