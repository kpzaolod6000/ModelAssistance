<?php
	$conn = new mysqli('localhost', 'root', '', 'databaseassistance');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>