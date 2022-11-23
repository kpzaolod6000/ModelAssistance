<?php
	//$conn = new mysqli('localhost', 'root', '', 'apsystem');
	$conn = new mysqli('us-cdbr-east-06.cleardb.net', 'babc0d92ce43ba', '460892db', 'heroku_fb747ca6b5578ec');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>