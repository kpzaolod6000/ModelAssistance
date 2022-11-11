<?php include 'conn.php'; ?>
<?php include 'header.php'; ?>

<?php

require '../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

    public function readCell($columnAddress, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row > 1) {
            return true;
        }
        return false;
    }
}

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$inputFileName = $_FILES['excel']['tmp_name'];

// $reader->setReadFilter( new MyReadFilter() );
// $spreadsheet = $reader->load("06largescale.xlsx");

$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
$reader =  \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);


$reader->setReadFilter(new MyReadFilter());

$spreadsheet = $reader->load($inputFileName);
$cantidad = $spreadsheet->getActiveSheet()->toArray();

$exito = false;

foreach ($cantidad as $row) {

    if($row[0] != ''){
        // echo "hello world";
        $sql = "INSERT INTO test_edu (dni,cui,firstname,lastname,courses,horarios,created_on) VALUES ($row[1],$row[2],'$row[3]','$row[4]','$row[5]','$row[6]',NOW())";
        // $sql = "INSERT INTO test_edu (dni,cui,firstname,lastname,courses,horarios,created_on) VALUES (75269815,745896,'Ronal','Perez','Paralela','2021-4','2020-01-07')";
		// $result = $conn->query($sql);
        if($conn->query($sql)){
            $exito = true;
			// print_r('Estudiantes añadidos satisfactoriamente');
        }else{
            $exito = false;
			// print_r (".'$conn->error'.");
		}
        // echo "operacion".$sql;
    }
}
// header('location: ../estudiantes.php');
// header("hello");
echo 'Estudiantes añadidos satisfactoriamente'
?>