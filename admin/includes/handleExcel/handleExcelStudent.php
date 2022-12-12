<?php include '../conn.php'; ?>
<?php //include '../header.php'; ?>

<?php

require '../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

    public function readCell($columnAddress, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row > 3 ) {
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

//select asig_student
$sqlAS = "SELECT * FROM asig_student";
$queryAS = $conn->query($sqlAS);

$asList = array();

while($rowAS = $queryAS->fetch_assoc()){
    array_push($asList, $rowAS['id_asignature']);
}
$addCount = 0;
$nameAsignature = "";
$nameGroup = "";
$rowSelectAsig = "";

foreach ($cantidad as $row) {

    if ($row[0] != '' && $row[1] == '' && $row[2] == '' && $row[3] == '') {

        // echo "row"; 
        if ($row[0] != "ALUMNOS MATRICULADOS POR CURSO") {
            $asiG_ = "ASIGNATURA";
            $group = "GRUPO";
            $namesA = explode(": ", $row[0]);
            if($namesA[0] == $asiG_){
                $nameAsignature = $namesA[1];
                $sqlSelectAsig = "SELECT * FROM asignatures WHERE names = '$nameAsignature'";
                $querySelectAsig = $conn->query($sqlSelectAsig);
                $rowSelectAsig = $querySelectAsig->fetch_assoc();
            }
            if ($namesA[0] == $group) {
                $nameGroup = $namesA[0] . " " . $namesA[1];
            }
        }
        
    }
    // exit;
    if($row[0] != '' && $row[1] != '' && $row[2] != '' && $row[3] != ''){

        if ($row[0] != 'NRO. ' || $row[1] != ' CUI ' || $row[2] != ' APELLIDOS Y NOMBRES ' || $row[3] != ' NRO.MATR. ') {
            if (!in_array((string) $row[1], $studentsList)) {
                $names = explode(", ", $row[2]);
                $correct_surnames = explode("/", $names[0]);
                $join_surnames = "{$correct_surnames[0]} {$correct_surnames[1]}";

                $queryInsert = "INSERT INTO students (cui,names,surnames,created_on,modified_on) VALUES ('$row[1]','$names[1]','$join_surnames',NOW(),NOW())";
                if ($conn->query($queryInsert)) {
                    $exito = true;
                    $addCount++;

                } else {
                    echo "error se encontro un dato erroneo {$row[2]}, por favor revise el documento segun la estructura";
                    // print_r (".'$conn->error'.");
                }
                
                // $sqlInsert = "INSERT INTO asig_student (id_student,id_asignature,groups,nro_matr,created_on,modified_on) VALUES ('$row[1]',NOW(),NOW())"
            }
            if (count($asList) == 0){
                $id_asig_ = $rowSelectAsig['id'];
                $sqlInsertAS = "INSERT INTO asig_student (id_student,id_asignature,groups,nro_matr,created_on,modified_on) VALUES ('$row[1]','$id_asig_','$nameGroup','$row[3]',NOW(),NOW())";
                $conn->query($sqlInsertAS);
            }else{
                $id_asig_ = $rowSelectAsig['id'];
                if(!in_array((string) $id_asig_, $asList)){
                    $sqlInsertAS = "INSERT INTO asig_student (id_student,id_asignature,groups,nro_matr,created_on,modified_on) VALUES ('$row[1]','$id_asig_','$nameGroup','$row[3]',NOW(),NOW())";
                    $conn->query($sqlInsertAS);
                }
            }
            
        }
    }
}
// header('location: ../estudiantes.php');
// header("hello");
echo json_encode(array('success' => $addCount));

?>