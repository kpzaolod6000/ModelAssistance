<?php
	include 'includes/session.php';

	if(isset($_POST['delete_asignature_submit'])){
		$id = $_POST['delete_id'];
		$sql = "DELETE FROM asignatures WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Asignatura eliminada con éxito';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Seleccione la asignatura que desea eliminar primero';
	}

	header('location: asignatures.php');
	
?>