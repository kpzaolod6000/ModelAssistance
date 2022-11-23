<?php
	include 'includes/session.php';
    //    $_POST['id']; se debe establecer la etiqueta como name='id'
	if(isset($_POST['edit_student_submit'])){
		// echo $_POST['edit_cui'];
        // exit;
        
        $id = $_POST['edit_id'];
        $names = strtoupper($_POST['edit_names']);
		$surnames = strtoupper($_POST['edit_surnames']);
        $email = $_POST['edit_email'];
        $gender = $_POST['edit_gender'];

		$sql = "UPDATE students SET names = '$names', surnames = '$surnames', email = '$email', gender = '$gender', modified_on = NOW()  WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Estudiante actualizado correctamente';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'LLena el formulario de edicion primero';
	}

	header('location:students.php');

?>