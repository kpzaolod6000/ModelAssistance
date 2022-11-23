<?php
	include 'includes/session.php';
    
	if(isset($_POST['edit_asignature_submit'])){
		// echo $_POST['edit_names'];
        // exit;
        
        $id = $_POST['edit_id'];
        $code =$_POST['edit_codes'];
        $names = strtoupper($_POST['edit_names']);
		$credit = $_POST['edit_credit'];
        $preReq = $_POST['edit_Pre_requeriments'];

		$sql = "UPDATE asignatures SET code = '$code', names = '$names', credit = $credit, pre_requeriments = '$preReq', modified_on = NOW() WHERE id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Asignatura actualizado correctamente';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'LLena el formulario de edicion primero';
	}

	header('location:asignatures.php');

?>