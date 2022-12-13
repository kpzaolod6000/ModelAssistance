<?php
	include '../includes/session.php';
    
    // echo gettype($_POST['cui']);
    // exit;
	if(isset($_POST['assistanceTeacher_add'])){
        $idA = $_POST['idAsignature'];
        $idT = $_POST['idTeacher'];
		$theme = $_POST['theme'];
        $ini = $_POST['ini'];
        $end = $_POST['end'];
        $advance = $_POST['advance'];
        
		$sql = "SELECT * FROM assistances_teacher WHERE created_on = DATE(NOW())";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		if($query->num_rows < 1){

			$sqlInsert = "INSERT INTO assistances_teacher (hour_ini,hour_end,theme_advanced,advanced,id_teacher,id_asignature,created_on,modified_on) 
            VALUES ('$ini','$end','$theme','$advance','$idT','$idA',NOW(),NOW())";
			if($conn->query($sqlInsert)){
				$_SESSION['success'] = 'Asistencia agregada con exito';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
		else{
			$_SESSION['error'] = "La asistencia ya existe";
		}
	}	
	else{
		$_SESSION['error'] = 'Rellene el formulario de asistencia primero';
	}

	header('location: ../home.php');

?>