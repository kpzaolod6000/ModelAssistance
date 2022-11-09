<?php
require_once './PHPExcel/Classes/PHPExcel.php';
//require_once 'PHPExcel/Classes/PHPExcel.php';
//$excelPath  = (!isset($_POST['excel']) ? '' : $_POST['excel']);
$archivo = "2022b.xlsx";
require_once('PHPExcel/Classes/PHPExcel/Reader/Excel2007.php');
/*$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);*/
$objReader = new PHPExcel_Reader_Excel2007();
$objPHPExcel = $objReader->load($archivo);

$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 

$highestColumn = $sheet->getHighestColumn();
echo "mas grande columna";
echo $highestColumn;

for ($row = 2; $row <= $highestRow; $row++){ 
		echo $sheet->getCell("A".$row)->getValue()." – ";
		echo $sheet->getCell("B".$row)->getValue()." – ";
		echo $sheet->getCell("C".$row)->getValue();
		echo "<br>";
}
?>
