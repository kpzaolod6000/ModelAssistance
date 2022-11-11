<?php include '../conn.php'; ?>
<?php include '../header.php'; ?>

<?php

require '../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter {

    public function readCell($columnAddress, $row, $worksheetName = '') {
        // Read title row and rows 20 - 30
        if ($row > 4) {
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
// $sql = "SELECT * FROM teachers";
// $query = $conn->query($sql);

foreach ($cantidad as $row) {

    if($row[1] != '' && $row[2] != '' && $row[3] != ''){

        $names = explode(", ", $row[2]);
    
        $queryInsert = "INSERT INTO teachers (names,surnames,email,created_on,modified_on) VALUES ('$names[0]','$names[1]','$row[3]',NOW(),NOW())";
        if($conn->query($queryInsert)){
            $exito = true;
            // print_r('Estudiantes añadidos satisfactoriamente');
        }else{
            $exito = false;
            // print_r (".'$conn->error'.");
        }
        
        // while($rowSelect = $query->fetch_assoc()){
        //   // <td>".number_format($row['amount'], 2)."</td>
          
        //   $cui_ = (string)$rowSelect['cui'];
        // //   echo ".'$cui_'.";
        //   $cui_excel = (string)$row[1];
        // //   echo $cui_
        //   if ($cui_ != $cui_excel) {

        //     $names = explode(", ", $row[2]);
    
        //     $queryInsert = "INSERT INTO students (cui,names,surnames,created_on,modified_on) VALUES ('$row[1]','$names[1]','$names[0]',NOW(),NOW())";
        //     if($conn->query($queryInsert)){
        //         $exito = true;
        //     	// print_r('Estudiantes añadidos satisfactoriamente');
        //     }else{
        //         $exito = false;
        //     	// print_r (".'$conn->error'.");
        //     }
            
        //   } 
        // }
        
        // $sql = "INSERT INTO students (cui,names,surnames,created_on,modified_on) VALUES ($row[1],$row[2],'$row[3]','$row[4]','$row[5]','$row[6]',NOW())";
        // $sql = "INSERT INTO test_edu (dni,cui,firstname,lastname,courses,horarios,created_on) VALUES (75269815,745896,'Ronal','Perez','Paralela','2021-4','2020-01-07')";
		// $result = $conn->query($sql);
        // if($conn->query($sql)){
        //     $exito = true;
		// 	// print_r('Estudiantes añadidos satisfactoriamente');
        // }else{
        //     $exito = false;
		// 	// print_r (".'$conn->error'.");
		// }

        // echo ".'$row[2]'.";
        // $idxDot = $row[2].lastIndexOf(", ") + 1;
        // $names = $row[2].substr(idxDot, $row[2].length).toLowerCase();
        // list($surnames, $names) = split(',', $row[2]);
        // $names = explode(", ", $row[2]);
        // // echo gettype($row[2]);
        // echo ".'$names[0]'.";
    }
}
// header('location: ../estudiantes.php');
// header("hello");
echo 'Docentes añadidos satisfactoriamente'
?>