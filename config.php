<?php
	define('host','localhost');
	define('uname','root');
	define('pass','');
	define('db','core_crud');

	$conn = mysqli_connect(host,uname,pass,db);

	if(!$conn){
		echo '<script>alert("Connection Failed");</script>';
	}

?>