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
        
        // echo json_encode(array('name' =>mb_convert_encoding($nameClass[1],'UTF-8')));
        // exit;
        if (!in_array($nroClass, $classList)) {
            $queryInsert = "INSERT INTO classroom (nro_class,names,created_on,modified_on) VALUES ('$nroClass','$nameClass[1]',NOW(),NOW())";
                
            if($conn->query($queryInsert)){
                $exito = true;
                // $addCount++;    

            }else{
                echo json_encode(array('error' => "error se encontro un dato erroneo {$row[1]}, por favor revise el documento segun la estructura"));
                // print_r (".'$conn->error'.");
            }
        }
    }

    if($row[1] != '' || $row[2] != '' || $row[3] != '' || $row[4] != '' || $row[5] != '' || $row[6] != ''){
        // if($row[1] == "HORAS"){
            
        // }
        //Algoritmos y Estructuras de Datos - Grupo A - (Teoría) / CRISTIAN JOSE LOPEZ DEL ALAMO
        if ($h1 == $row[1]) {
            if ($row[2] != '') {
                // list($asignature, $group, $type, $nameTeacher) = splitData($row[2],$numClassGlobal,"LUNES",$h1);
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h1,$ListSchedule);
                // echo "$asignature $group $type $nameTeacher \n";
            }
            if ($row[3] != '') {
                // echo "$row[3] \n";   
                // print_r("$row[3]");
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h1,$ListSchedule);
            }
            if ($row[4] != '') {
                // echo "$row[4] \n";
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h1,$ListSchedule);
            }
            if ($row[5] != '') {
                // echo "$row[5] \n";
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h1,$ListSchedule);
            }
            if ($row[6] != '') {
                // echo "$row[6] \n";
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h1,$ListSchedule);
            }
        }
        else if ($h2 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h2,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h2,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h2,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h2,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h2,$ListSchedule);
            }
        }
        else if ($h3 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h3,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h3,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h3,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h3,$ListSchedule);
            }
            if ($row[6] != '') {
                //print_r($row[6] . "\n");
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h3,$ListSchedule);
            }
        }
        else if ($h4 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h4,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h4,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h4,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h4,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h4,$ListSchedule);
            }
        }
        else if ($h5 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h5,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h5,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h5,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h5,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h5,$ListSchedule);
            }
        }
        else if ($h5 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h5,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h5,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h5,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h5,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h5,$ListSchedule);
            }
        }
        else if ($h6 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h6,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h6,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h6,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h6,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h6,$ListSchedule);
            }
        }
        else if ($h7 == $row[1]) {
            if ($row[2] != '') {
                // print_r($row[2]."\n");
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h7,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h7,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h7,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h7,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h7,$ListSchedule);
            }
        }
        else if ($h8 == $row[1]) {
            if ($row[2] != '') {
                // print_r($row[2]."\n");
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h8,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h8,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h8,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h8,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h8,$ListSchedule);
            }
        }
        else if ($h9 == $row[1]) {
            if ($row[2] != '') {
                // print_r($row[2]."\n");
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h9,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h9,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h9,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h9,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h9,$ListSchedule);
            }
        }
        else if ($h10 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h10,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h10,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h10,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h10,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h10,$ListSchedule);
            }
        }
        else if ($h11 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h11,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h11,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h11,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h11,$ListSchedule);
            }
            if ($row[6] != '') {
                // print_r($row[6]."\n");
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h11,$ListSchedule);
            }
        }
        else if ($h12 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h12,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h12,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h12,$ListSchedule);
            }
            if ($row[5] != '') {
                // print_r($row[5]."\n");
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h12,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h12,$ListSchedule);
            }
        }
        else if ($h13 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h13,$ListSchedule);
            }
            if ($row[3] != '') {
                // print_r($row[3]."\n");
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h13,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h13,$ListSchedule);
            }
            if ($row[5] != '') {
                // print_r($row[5]."\n");
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h13,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h13,$ListSchedule);
            }
        }
        else if ($h14 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h14,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h14,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h14,$ListSchedule);
            }
            if ($row[5] != '') {
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h14,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h14,$ListSchedule);
            }
        }
        else if ($h15 == $row[1]) {
            if ($row[2] != '') {
                $ListSchedule = splitData($row[2],$numClassGlobal,"LUNES",$h15,$ListSchedule);
            }
            if ($row[3] != '') {
                $ListSchedule = splitData($row[3],$numClassGlobal,"MARTES",$h15,$ListSchedule);
            }
            if ($row[4] != '') {
                $ListSchedule = splitData($row[4],$numClassGlobal,"MIERCOLES",$h15,$ListSchedule);
            }
            if ($row[5] != '') {
                // print_r($row[5]."\n");
                $ListSchedule = splitData($row[5],$numClassGlobal,"JUEVES",$h15,$ListSchedule);
            }
            if ($row[6] != '') {
                $ListSchedule = splitData($row[6],$numClassGlobal,"VIERNES",$h15,$ListSchedule);
            }
        }
    }
}
// echo json_encode(array('asignature' => $row_test, 'teachers' => $row_test_t, 'classroom' => $row_test_c));
// echo json_encode(array('success' => $addCount));
// exit;


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
    

    // echo json_encode(array('value' => properText($asig_)));
    // exit;

    //**Area de obtener el id de las tablas asignature, teachers y classroom*/
    $sql_test = "SELECT * FROM asignatures WHERE asignatures.names='$asig_'";
    $query_test = $conn->query($sql_test);
    if($query_test->num_rows < 1){
        $sqlInsertClass= "INSERT INTO asignatures (names,created_on,modified_on) VALUES ('$asig_',NOW(),NOW())";
        $conn->query($sqlInsertClass);
    }

    // echo json_encode(array('success' => $row_test));

    // $name_tes = "CRISTIAN JOSE LOPEZ DEL ALAMO ";
    $listname = explode(" ", $teacher_);
    $name_t = "";
    $surname_t = "";
    if (count($listname) > 3) {
        $name_t = $listname[0]." ".$listname[1];
        $surname_t = $listname[count($listname)-2]." ".$listname[count($listname)-1];    
    }else{
        $name_t = $listname[0];
        $surname_t = $listname[1]." ".$listname[2];

    }

    $sql_test_t = "SELECT * FROM teachers WHERE teachers.names='$name_t' OR teachers.surnames = '$surname_t'";
    $query_test_t = $conn->query($sql_test_t);
    $row_teacher = $query_test_t->fetch_assoc();

    
    $sql_test_c = "SELECT * FROM classroom WHERE classroom.nro_class = '$class_'";
    $query_test_c = $conn->query($sql_test_c);
    $row_class = $query_test_c->fetch_assoc();

    $sql_test_a = "SELECT * FROM asignatures WHERE asignatures.names='$asig_'";
    $query_test_a = $conn->query($sql_test_a);
    $row_asig = $query_test_a->fetch_assoc();


    //** ---------------------------------------------------------------------------------------------------------------------*/

    // echo json_encode(array('success' => $row_asig, 'll' => gettype($row_teacher), 'jj' => $row_class['id']));
    // exit;
    $id_asig = $row_asig['id'];
    $id_teacher = $row_teacher['id'];
    $id_class = $row_class['id'];

    $sqlSelectSche = "SELECT * FROM schedule WHERE hour_ini = '$hour_in_' AND hour_end = '$hour_end_' AND types = '$type_' AND dates = '$day_' AND groups = '$group_' AND id_asignature = '$id_asig' AND id_classroom = '$id_class' AND id_teacher = '$id_teacher'";
    
    
    $querySelectSche = $conn->query($sqlSelectSche);
    if($querySelectSche->num_rows < 1){
        $sqlInsertSchedule = "INSERT INTO schedule (hour_ini,hour_end,types,dates,groups,id_asignature,id_classroom,id_teacher,created_on,modified_on) VALUES ('$hour_in_','$hour_end_','$type_','$day_','$group_','$id_asig','$id_class','$id_teacher',NOW(),NOW())";
        // $sqlInsertSchedule = "INSERT INTO schedule (hour_ini,hour_end,types,dates,group,id_asignature,id_classroom,id_teacher,created_on,modified_on) VALUES (hola,hola,hola,hola,hola,hola,455,hola,NOW(),NOW())"; 
        if($conn->query($sqlInsertSchedule)){
            $exito = true;
            $addCount++;

        }else{
            echo "error se encontro un dato erroneo {$dataSchedule}, por favor revise el documento segun la estructura";
            // print_r (".'$conn->error'.");
        }   
    }
}

echo json_encode(array('success' => $addCount));

?>