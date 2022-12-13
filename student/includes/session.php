<?php
	session_start();
	include 'conn.php';

	if(!isset($_SESSION['student']) || trim($_SESSION['student']) == ''){
		header('location: index.php');
	}

	// echo $_SESSION['admin'];
	//exit;

	$sql = "SELECT * FROM students WHERE id = '".$_SESSION['student']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>