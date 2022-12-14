<?php
	// $conn = new mysqli('localhost', 'root', '', 'databaseassistance');
	// $conn = new mysqli('us-cdbr-east-06.cleardb.net', 'babc0d92ce43ba', '460892db', 'heroku_fb747ca6b5578ec');
	$conn = new mysqli('us-cdbr-east-06.cleardb.net', 'b36b5a4bddf873', '1e177132', 'heroku_20d06c9d3ee2989');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>