<?php include '../includes/session.php';?>
<div class="box-body">
    <table id="example1" class="table table-bordered">
    <thead>
        <th>ID</th>
        <th>Código</th>
        <th>Nombres</th>
        <th class="hidden"></th>
        
    </thead>
    <tbody>
        <?php
        $id_docent = $_SESSION['teacher'];
        $sql = "SELECT a.id,a.code,a.names FROM asig_teacher at2
        INNER JOIN asignatures a ON at2.id_asignature = a.id 
        WHERE at2.id_teacher = '$id_docent' ORDER BY a.names ASC";
        $query = $conn->query($sql);
        $countT = 0;

        $sqlAsigStudent = "SELECT s.cui, concat(s.names,',',s.surnames) as NameStudent, ass.id_asignature FROM asignatures a INNER JOIN asig_student ass ON a.id = ass.id_asignature INNER JOIN students s ON ass.id_student = s.cui ORDER BY s.surnames ASC";
        $queryAsigStudent = $conn->query($sqlAsigStudent);
        $countAS = 0;
        $rowAsigStudent = $queryAsigStudent->fetch_all(MYSQLI_ASSOC);
        
        $studentList = array();

        while($row = $query->fetch_assoc()){
            // <td>".number_format($row['amount'], 2)."</td>
            $countT++;
            // echo (int)$row['id'];
        
            foreach ($rowAsigStudent as $itemStudent) {
                //printf("%s (%s)\n", $itemStudent["cui"],$itemStudent["NameStudent"]);
                if((int) $row['id'] == (int) $itemStudent['id_asignature']){
                array_push($studentList, $itemStudent);
                //   $cui = $itemStudent['cui'];
                // $nameStudent = $itemStudent['NameStudent'];
                // $groups = $itemStudent['groups'];
                // $nroMatri = $itemStudent['nro_matr'];
                }
            }
            
            
            echo '
            <tr data-toggle="collapse" data-target="#demo'.$countT.'" class="accordion-toggle">
                <td>' . $countT . '</td>
                <td>' . $row['code'] . '</td>
                <td>' . $row['names'] . '</td>
                <td><button class="btn btn-primary"><i class="fa fa-user-plus"></i></button></td>
            </tr>

            <tr>
                <td colspan="12" class="hiddenRow">
                <div class="accordian-body collapse" aria-expanded="false" id="demo'.$countT.'"> 
                <table class="table table-striped">
                        <thead>
                            <tr class="info">
                            <th>CUI</th>
                            <th>Nombre Completo</th>
                            </tr>
                        </thead>
                        
                  
            ';
            echo '<tbody id="tbody'.$countT.'">';
            $count_ = 0;
            foreach ($studentList as $itemStudent) {
                $cui = $itemStudent['cui'];
                $nameStudent = $itemStudent['NameStudent'];
                // echo $cui;
                // echo $nameStudent;
                $count_++;
                echo "<tr>
                  <td>$cui</td>
                  <td>$nameStudent</td>
                  </tr>
                    ";
                }
                echo '</tbody>';
                   
                echo '</table>
                        </div> 
                        </td>
                    </tr>';
        }
        ?>
    </tbody>
    </table>
</div>
