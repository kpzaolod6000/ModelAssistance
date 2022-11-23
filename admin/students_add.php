<?php
	include 'includes/session.php';

    // echo gettype($_POST['cui']);
    // exit;
	if(isset($_POST['add_student'])){
        $cui = $_POST['cui'];
		$names = strtoupper($_POST['names']);
		$surnames = strtoupper($_POST['surnames']);
		$email = $_POST['email'];
		$gender = $_POST['gender'];

		$sql = "SELECT * FROM students WHERE cui = '$cui'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		if($query->num_rows < 1){

			$sqlInsert = "INSERT INTO students (cui,names,surnames,email,gender,created_on,modified_on) VALUES ('$cui','$names','$surnames','$email','$gender',NOW(),NOW())";
			if($conn->query($sqlInsert)){
				$_SESSION['success'] = 'Estudiante agregado con exito';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
		else{
			$_SESSION['error'] = "El usuario Estudiante {$row['names']} {$row['surnames']} ya existe";
		}
	}	
	else{
		$_SESSION['error'] = 'Rellene el formulario de adición primero';
	}

	header('location: students.php');

?>