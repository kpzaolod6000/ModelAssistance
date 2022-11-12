<?php include '../conn.php'; ?>
<?php //include '../header.php'; ?>

<?php

require '../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

    public function readCell($columnAddress, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row > 9) {
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
//select students
$sql = "SELECT * FROM students";
$querySelect = $conn->query($sql);

$studentsList = array();

while($rowSelect = $querySelect->fetch_assoc()){
    array_push($studentsList, $rowSelect['cui']);
}


$addCount = 0;

foreach ($cantidad as $row) {

    if($row[0] != '' && $row[1] != '' && $row[2] != '' && $row[3] != ''){


        if (!in_array((string)$row[1], $studentsList)) {
            $names = explode(", ", $row[2]);
            $correct_names = explode("/",$names[0]);
            $join_names ="{$correct_names[0]} {$correct_names[1]}";
            
            $queryInsert = "INSERT INTO students (cui,names,surnames,created_on,modified_on) VALUES ('$row[1]','$join_names','$names[0]',NOW(),NOW())";
            
            if($conn->query($queryInsert)){
                $exito = true;
                $addCount++;    

            }else{
                echo "error se encontro un dato erroneo {$row[2]}, por favor revise el documento segun la estructura";
                // print_r (".'$conn->error'.");
            }
        }
    }
}
// header('location: ../estudiantes.php');
// header("hello");
echo json_encode(array('success' => $addCount));

?>