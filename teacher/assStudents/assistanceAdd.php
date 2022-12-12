<?php 
	include '../includes/session.php';
	$addCount = 0;
	if(isset($_POST['_data_'])){
		$data = $_POST['_data_'];

		// echo json_encode($data);
		// exit;
		
		foreach ($data as $item) {
			$idAsig = (int)$item['idAsig'];
			$idDocent = (int)$item['idDocent'];
			$cuiStudent = $item['cuiStudent'];
			$action = $item['action'];
			$hour_ = $item['hour_'];
			
			$sql = "INSERT INTO assistances_student (hour_assistance,states,id_student,id_teacher,id_asignature,created_on,modified_on) VALUES ('$hour_','$action','$cuiStudent','$idDocent','$idAsig',NOW(),NOW())";
			if($conn->query($sql)){
                $addCount++;
            }
		}
	}
	if ($addCount > 0) {
		// $_SESSION['success'] = 'Asistencia concluida';
		echo true;
	}else{
		// $_SESSION['error'] = 'Marque la asistencia correctamente';
		echo false;
	}
?>