<?php
	include 'includes/session.php';

	if(isset($_POST['delete_teacher_submit'])){
		$id = $_POST['delete_id'];
		$sql = "DELETE FROM teachers WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Docente eliminado con éxito';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Seleccione al docente que desea eliminar primero';
	}

	header('location: teachers.php');
	
?>