<?php
	session_start();
	include 'includes/conn.php';

	if(!isset($_SESSION['teacher']) || trim($_SESSION['teacher']) == ''){
		header('location: http://localhost:81/AssistanceControl/teacher/index.php');
	}

	//echo $_SESSION['admin'];
	//exit;

	$sql = "SELECT * FROM teachers WHERE id = '".$_SESSION['teacher']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
	
?>