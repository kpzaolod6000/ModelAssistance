<?php
	include 'includes/session.php';

	if(isset($_POST['add_asignature'])){

        $code =$_POST['codes'];
        $names = strtoupper($_POST['names']);
		$credit = $_POST['credit'];
        $preReq = $_POST['Pre_requeriments'];

		$sql = "SELECT * FROM asignatures WHERE names = '$names'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();
		
		if($query->num_rows < 1){

			$sqlInsert = "INSERT INTO asignatures (code,names,credit,pre_requeriments,created_on,modified_on) VALUES ('$code','$names','$credit','$preReq',NOW(),NOW())";
			if($conn->query($sqlInsert)){
				$_SESSION['success'] = 'Asignatura agregado con exito';
			}
			else{
				$_SESSION['error'] = $conn->error;
			}
		}
		else{
			$_SESSION['error'] = "La asignatura {$row['names']} ya existe";
		}
	}	
	else{
		$_SESSION['error'] = 'Rellene el formulario de adición primero';
	}

	header('location: asignatures.php');

?>