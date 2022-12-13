<?php include '../includes/session.php'; ?>
<?php include '..//includes/header.php'; ?>

  

<div class="box-body">
    <table id="example1" class="table table-bordered">
    <thead>
        <th class="hidden"></th>
        <th>ID</th>
        <th>Nombre</th>
        <th>Marcar Asistencia</th>
    </thead>
    <tbody>
        <?php
        $id_docent = $_SESSION['teacher'];

        $id_asignature = $_SESSION['asig'];

        $sql = "SELECT a.id,a.names  FROM asig_teacher at2 
        INNER JOIN asignatures a ON at2.id_asignature = a.id 
        WHERE at2.id_teacher = '$id_docent'";
        $query = $conn->query($sql);
        $countS = 0;

        while($row = $query->fetch_assoc()){
            // <td>".number_format($row['amount'], 2)."</td>
            $countS++;
            echo "
            <tr>
                <td class='hidden'></td>
                <td>" . $countS . "</td>
                <td>" . $row['names'] . "</td>                          
                <td>";
            if ($id_asignature == $row['id']) {
                echo "<button onclick='showModal(event)' class='btn btn-primary btn-sm marcar_save btn-flat' data-name='".$row['names']."' data-id='".$row['id']."' id = 'marcar_save_button'><i class='fa fa-edit'></i> Marcar</button>";
            }else{
                echo "<button onclick='showModal(event)' class='btn btn-primary btn-sm marcar_save btn-flat' data-name='".$row['names']."' data-id='".$row['id']."' id = 'marcar_save_button' disabled><i class='fa fa-edit'></i> Marcar</button>";
            }
            
            echo "</td>
            </tr>
            ";
        }
        ?>
    </tbody>
    </table>
</div>