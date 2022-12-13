<style>
.bg-light-gray {
    background-color: #dee4e0;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}


.bg-sky.box-shadow {
    box-shadow: 0px 5px 0px 0px #00a2a7
}

.bg-orange.box-shadow {
    box-shadow: 0px 5px 0px 0px #af4305
}

.bg-green.box-shadow {
    box-shadow: 0px 5px 0px 0px #4ca520
}

.bg-yellow.box-shadow {
    box-shadow: 0px 5px 0px 0px #dcbf02
}

.bg-pink.box-shadow {
    box-shadow: 0px 5px 0px 0px #e82d8b
}

.bg-purple.box-shadow {
    box-shadow: 0px 5px 0px 0px #8343e8
}

.bg-lightred.box-shadow {
    box-shadow: 0px 5px 0px 0px #d84213
}


.bg-sky {
    background-color: #02c2c7
}

.bg-orange {
    background-color: #e95601
}

.bg-green {
    background-color: #5bbd2a
}

.bg-yellow {
    background-color: #f0d001
}

.bg-pink {
    background-color: #ff48a4
}

.bg-purple {
    background-color: #9d60ff
}

.bg-lightred {
    background-color: #ff5722
}

.padding-15px-lr {
    padding-left: 15px;
    padding-right: 15px;
}
.padding-5px-tb {
    padding-top: 5px;
    padding-bottom: 5px;
}
.margin-10px-bottom {
    margin-bottom: 10px;
}
.border-radius-5 {
    border-radius: 5px;
}

.margin-10px-top {
    margin-top: 10px;
}
.font-size16 {
    font-size: 16px;
}

.font-size15 {
    font-size: 15px;
}

.text-light-black{
    color: #070707;
}
.text-light-gray {
    color: #4c4c4c;
}
.font-size14 {
    font-size: 14px;
}

.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

.bg-header{
    background-color: #5582ff
}

.bg-timer{
    background-color: #bccdff
}
</style>
<?php
    $hTotal = array("07:00-07:50", "07:50-08:40", "08:50-09:40", "09:40-10:30", "10:40-11:30", "11:30-12:20", "12:20-13:10", "13:10-14:00", "14:00-14:50", "14:50-15:40", "15:50-16:40", "16:40-17:30", "17:40-18:30", "18:30-19:20", "19:20-20:10");
    $color = array("bg-sky", "bg-orange", "bg-green", "bg-yellow", "bg-pink", "bg-purple", "bg-lightred");
?>

<?php 
include '../includes/session.php';

$id_docent = $_SESSION['teacher'];
$sql = "SELECT * FROM asig_teacher at1 
inner join schedule s on at1.id_asignature = s.id_asignature
inner join asignatures a on a.id = s.id_asignature
WHERE s.id_teacher = '$id_docent'";

$query = $conn->query($sql);
$rowSQL = $query->fetch_all(MYSQLI_ASSOC);

$asig_color = array();

$sqlNames = "SELECT distinct a.names FROM asig_teacher at1 
inner join schedule s on at1.id_asignature = s.id_asignature
inner join asignatures a on a.id = s.id_asignature 
WHERE s.id_teacher = '$id_docent'";

$queryNames = $conn->query($sqlNames);

$idx = 0;
while($rowNames = $queryNames->fetch_assoc()){
    $asig_color[$rowNames['names']] = $color[$idx % count($color)];
    $idx++;
}

// foreach ($rowSQL as $item) {
//     $hourSche = $item['hour_ini'] . '-'.$item['hour_end'];
//     echo $hourSche;

// }

?>

<div class="calendars">
    <div class="timetable-img text-center">
        <img src="img/content/timetable.png" alt="">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr class="bg-light-gray bg-header">
                    <th class="text-uppercase">Hora</th>
                    <th class="text-uppercase">Lunes</th>
                    <th class="text-uppercase">Martes</th>
                    <th class="text-uppercase">Miercoles</th>
                    <th class="text-uppercase">Jueves</th>
                    <th class="text-uppercase">Viernes</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //**17:40-18:30*/ 
            //**18:30-19:20*/
            //**18:30-19:20*/
            //**18:30-19:20 */
            //**18:30-19:20 */
            //**19:20-20:10 */
            //**19:20-20:10 */ 
            //**19:20-20:10 */
            for ($i=0; $i < count($hTotal); $i++) {

                $isHour = false;
                $scheduleTeacher = array("LUNES"=>"",
                                         "MARTES"=>"",
                                         "MIERCOLES"=>"",
                                         "JUEVES"=>"",
                                         "VIERNES"=>"");
                
                foreach ($rowSQL as $item) {
                    $hourSche = $item['hour_ini'] . '-'.$item['hour_end'];
                    if ($hTotal[$i] == $hourSche) {
                        $setDay = $item['dates'];
                        $scheduleTeacher["$setDay"] = array($item['names'],$item['types'],$item['groups']);
                    }
                }
                // echo json_encode($scheduleTeacher)."\n";
                echo '<tr>';
                echo '<td class="align-middle bg-timer">' . $hTotal[$i] . '</td>';

                foreach ($scheduleTeacher as $key => $value) {
                    if ($value) {
                        echo '
                            <td>
                                <span class="'.$asig_color[$value[0]].' padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size15">'.$value[0].'</span>
                                <div class="margin-10px-top font-size14 text-light-black">'.$value[1].' - '.$value[2].'</div>
                            </td>';

                    }else{
                        echo '
                            <td class="bg-light-gray">

                            </td>';
                    }
                }
                echo '</tr> ';
            }

            ?>
            
            </tbody>
            <!-- <tbody>
                <tr>
                    <td class="align-middle bg-timer">07:00-07:50</td>
                    <td>
                        <span class="bg-sky padding-5px-tb padding-15px-lr border-radius-5 margin-10px-bottom text-white font-size16 xs-font-size13">Dance</span>
                        <div class="margin-10px-top font-size14">9:00-10:00</div>
                        <div class="font-size13 text-light-gray">Ivana Wong</div>
                    </td>
                    
                    <td class="bg-light-gray">

                    </td>

                    <td class="bg-light-gray">

                    </td>
                    
                    <td class="bg-light-gray">

                    </td>
                    
                    <td class="bg-light-gray">

                    </td>

                </tr>
            </tbody> -->
        </table>
    </div>
</div>