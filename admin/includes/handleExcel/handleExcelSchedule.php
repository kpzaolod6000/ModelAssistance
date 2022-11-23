<?php include '../conn.php'; ?>
<?php include './splitSchedule.php' ?>

<?php

require '../../../vendor/autoload.php';
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


// $exito = false;
// //select students
$sql = "SELECT * FROM classroom";
$querySelect = $conn->query($sql);

$classList = array();
$ListSchedule = array();


while($rowSelect = $querySelect->fetch_assoc()){
    array_push($classList, $rowSelect['nro_class']);
}

$exito = false;
$addCount = 0;
$textTitle = "DISTRIBUCIÓN DE AULAS/LABORATORIO DE LA SECCIÓN DE LA EPCC - 2022B";


if ($cantidad[1][0] != $textTitle) {
    echo json_encode(array('success' => -1));// no es un archivo de horarios
}

$numClassGlobal=0;

foreach ($cantidad as $row) {

    
    // if($row[0] != '' && $row[1] != '' && $row[2] != '' && $row[3] != ''){
    if($row[1] != '' && $row[2] == '' && $row[3] == '' && $row[4] == '' && $row[5] == '' && $row[6] == ''){
        
        $nameClass = explode(" - ", $row[1]);
        $splitNameClass = explode(" ", $nameClass[0]);
        $nroClass = (int) $splitNameClass[1];
        $numClassGlobal = $nroClass;
        
        if (!in_array($nroClass, $classList)) {
            $queryInsert = "INSERT INTO classroom (nro_class,names,created_on,modified_on) VALUES ('$nroClass','$nameClass[1]',NOW(),NOW())";
                
            if($conn->query($queryInsert)){
                $exito = true;
                // $addCount++;    

            }else{
                json_encode(array('error' => "error se encontro un dato erroneo {$row[1]}, por favor revise el documento segun la estructura"));
                // print_r (".'$conn->error'.");
            }
        }


        // if (!in_array((string)$row[1], $studentsList)) {
        //     $names = explode(", ", $row[2]);
        //     $correct_surnames = explode("/",$names[0]);
        //     $join_surnames ="{$correct_surnames[0]} {$correct_surnames[1]}";
            
        //     $queryInsert = "INSERT INTO students (cui,names,surnames,created_on,modified_on) VALUES ('$row[1]','$names[1]','$join_surnames',NOW(),NOW())";
            
        //     if($conn->query($queryInsert)){
        //         $exito = true;
        //         $addCount++;    

        //     }else{
        //         echo "error se encontro un dato erroneo {$row[2]}, por favor revise el documento segun la estructura";
        //         // print_r (".'$conn->error'.");
        //     }
        // }
    }

    if($row[1] != '' || $row[2] != '' || $row[3] != '' || $row[4] != '' || $row[5] != '' || $row[6] != ''){
        // if($row[1] == "HORAS"){
            
        // }
        //Algoritmos y Estructuras de Datos - Grupo A - (Teoría) / CRISTIAN JOSE LOPEZ DEL ALAMO
        if ($h1 == $row[1]) {
            
            // echo "$numClassGlobal \n";

            if ($row[2] != '') {
                
                // list($asignature, $group, $type, $nameTeacher) = splitData($row[2],$numClassGlobal,"LUNES",$h1);
                
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h1,$ListSchedule);
                // echo "$asignature $group $type $nameTeacher \n";
            }
            if ($row[3] != '') {
                // echo "$row[3] \n";
            }
            if ($row[4] != '') {
                // echo "$row[4] \n";
            }
            if ($row[5] != '') {
                // echo "$row[5] \n";
            }
            if ($row[6] != '') {
                // echo "$row[6] \n";
            }
        }
        
    }
}
// header('location: ../estudiantes.php');
// header("hello");

foreach ($ListSchedule as $dataSchedule) {
    // echo "$dataSchedule->hour_ini $dataSchedule->hour_end $dataSchedule->type $dataSchedule->day $dataSchedule->group $dataSchedule->asignature $dataSchedule->classroom $dataSchedule->nameTeacher \n";
    // exit;

    $hour_in_ = $dataSchedule->hour_ini;
    $hour_end_ = $dataSchedule->hour_end;
    $type_ = strtoupper($dataSchedule->type);
    $day_ = strtoupper($dataSchedule->day);
    $group_ = strtoupper($dataSchedule->group);
    $asig_ = strtoupper($dataSchedule->asignature);
    $class_ = $dataSchedule->classroom;
    $teacher_ = strtoupper($dataSchedule->nameTeacher);

    // echo "$hour_in_ $hour_end_ $type_ $day_ $group $asig_ $class_ $teacher_ \n";
    // $sqlInsertSchedule = "INSERT INTO schedule (hour_ini,hour_end,types,dates,group,id_asignature,id_classroom,id_teacher,created_on,modified_on) VALUES ('$dataSchedule->hour_ini','$dataSchedule->hour_end','$dataSchedule->type','$dataSchedule->day','$dataSchedule->group','$dataSchedule->asignature','$dataSchedule->classroom','$dataSchedule->nameTeacher',NOW(),NOW())";
    $sqlInsertSchedule = "INSERT INTO schedule (hour_ini,hour_end,types,dates,group,id_asignature,id_classroom,id_teacher,created_on,modified_on) VALUES ('$hour_in_','$hour_end_','$type_','$day_','$group_','$asig_','$class_','$teacher_',NOW(),NOW())";
    // $sqlInsertSchedule = "INSERT INTO schedule (hour_ini,hour_end,types,dates,group,id_asignature,id_classroom,id_teacher,created_on,modified_on) VALUES (hola,hola,hola,hola,hola,hola,455,hola,NOW(),NOW())";
    
    if($conn->query($sqlInsertSchedule)){
        $exito = true;
        $addCount++;    

    }else{
        echo "error se encontro un dato erroneo {$dataSchedule}, por favor revise el documento segun la estructura";
        // print_r (".'$conn->error'.");
    }


}

echo json_encode(array('success' => $addCount));

?>