<?php
	include 'includes/session.php';

	if(isset($_POST['delete_student_submit'])){
		$id = $_POST['delete_id'];
		$sql = "DELETE FROM students WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Estudiante eliminado con éxito';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Seleccione al estudiante que desea eliminar primero';
	}

	header('location: students.php');
	
?>