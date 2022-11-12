<?php
	include 'includes/session.php';

	if(isset($_POST['add_teacher'])){
		$names = strtoupper($_POST['names']);
		$surnames = strtoupper($_POST['surnames']);
		$email = $_POST['email'];
		$gender = $_POST['gender'];

		$sql = "SELECT * FROM teachers WHERE email = '$email'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();
		
		if($query->num_rows < 1){

			$sqlInsert = "INSERT INTO teachers (names,surnames,email,gender,created_on,modified_on) VALUES ('$names','$surnames','$email','$gender',NOW(),NOW())";
			if($conn->query($sqlInsert)){
				$_SESSION['success'] = 'Docente agregado con exito';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
		else{
			$_SESSION['error'] = "El usuario docente {$row['names']} {$row['surnames']} ya existe";
		}
	}	
	else{
		$_SESSION['error'] = 'Rellene el formulario de adición primero';
	}

	header('location: teachers.php');

?>