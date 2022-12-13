<?php
    include '../includes/session.php';
      /**
       * @var mixed HASH
       */
        $id_docent = $_SESSION['teacher'];
        $sqlTeacher = "SELECT * FROM teachers WHERE teachers.id = '$id_docent'";
        $queryTeachers = $conn->query($sqlTeacher);
        $row_class = $queryTeachers->fetch_assoc();
        $hour_ = "";

    ?>

    <?php 
      $hour_ = "<script> document.write(hour_) </script>";
      $day_ = "<script> document.write(day_) </script>";

      $sqlSelectAsig = "SELECT at2.id_asignature FROM asig_teacher at2 
      INNER JOIN schedule_group sg ON at2.id_asignature = sg.id_asignature 
      WHERE '$hour_' BETWEEN sg.hour_ini AND sg.hour_complete 
      AND sg.dates = '$day_'";
      $querySelectAsig = $conn->query($sqlSelectAsig);
      $rowSelectAsig = $querySelectAsig->fetch_assoc();
      $id_asignature_filter = $rowSelectAsig['id_asignature'];
    //   echo $id_asignature_filter;
      echo '<input type="text" id="id_Asig" value="'.$id_asignature_filter.'" hidden>'
    ?>

    <!-- tabla -->

    <div class="row">
      <div class="col-12">
        <table class="table table-bordered" id="table-assistances">
            <?php
            if ($id_asignature_filter) {
              echo '
              <thead>
                <tr>
                  <th scope="col">Numero</th>
                  <th scope="col">Apellidos</th>
                  <th scope="col">Nombres</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              ';
            }
            ?>
          <tbody>
            <?php
              // echo "asignature: " . $id_asignature_filter;

              $sqlSelectT = "SELECT s.cui, s.surnames , s.names, as2.id_asignature, at2.id_teacher  FROM asig_student as2 
              INNER JOIN students s ON as2.id_student = s.cui 
              INNER JOIN asig_teacher at2 ON at2.id_asignature = as2.id_asignature 
              WHERE as2.id_asignature = '$id_asignature_filter' AND at2.id_teacher = '$id_docent'
              ORDER BY s.surnames ";

              // s2.hour_ini, s2.hour_end, 
              // INNER JOIN schedule s2 ON s2.id_teacher = t.id
              // AND s2.dates = '$day_'
              // AND (s2.hour_ini >= '$hour_' AND s2.hour_end <= '$hour_')

              $count_ = 0;
              $querySelectT = $conn->query($sqlSelectT);
              while($rowSelectT = $querySelectT->fetch_assoc()){
                $count_++;
                echo '
                <tr>
                  <th scope="row">'.$count_.'</th>
                  <td>'.$rowSelectT["surnames"].'</td>
                  <td>'.$rowSelectT["names"].'</td>
                  <td>
                    <button id = "btnStudent'.$count_.'" onclick ="editoEstado('.$count_.')" type="button" class="btn btn-success"><i id="student'.$count_.'" class="fa fa-circle" aria-hidden="true"></i> </button>
                    <button type="button" data-toggle="collapse" href="#collapseExample'.$count_.'" aria-expanded="false" aria-controls="collapseExample" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                    <div class="collapse" id="collapseExample'.$count_.'">
                        <div class="card card-body">
                            <div class="input-group-'.$count_.'" id = "input-group-'.$count_.'">
        
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbPuntual'.$count_.'" name="estado'.$count_.'" value = "PUNTUAL">
                                    <label class="custom-control-label" for="rbPuntual'.$count_.'">Puntual</label>
                                </div> 
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbTarde'.$count_.'" name="estado'.$count_.'" value = "TARDE">
                                  <label class="custom-control-label" for="rbTarde'.$count_.'">Tarde</label>
                                </div> 
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbAusente'.$count_.'" name="estado'.$count_.'" value = "AUSENTE">
                                  <label class="custom-control-label" for="rbAusente'.$count_.'">Ausente</label>
                                </div> 
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input onclick ="editoEstado('.$count_.')" type="radio" class="custom-control-input rbAss'.$count_.'" id="rbJustificado'.$count_.'" name="estado'.$count_.'" value = "JUSTIFICADO">
                                  <label class="custom-control-label" for="rbJustificado'.$count_.'">Justificado</label>
                                </div>
                                <input type="text" id="id_Student'.$count_.'" value="'.$rowSelectT['cui'].'" hidden>
                            </div>
                        </div>
                    </div>
                  </td>
                </tr>
                ';
              }
              echo '<input type="text" id="id_Teacher" value="'.$id_docent.'" hidden>'
            ?>
          </tbody>
        </table>
        <?php 
          if ($id_asignature_filter) {
          echo '
              <div style="display: flex; justify-content: flex-end">
              <button class="btn btn-primary btn-sm save_assistance btn-flat" >Guardar <i class="fa fa-save"></i></button>
            </div>  
            ';
          }
        ?>
      </div>
    </div>

    <!-- /tabla -->  
    
    <script>
      const asig_id = $("#id_Asig").val();
      var elem = document.getElementById('container');
    
      if (asig_id) {
        elem.style.display = 'block';    
      }
    </script>

    <script>
        function editoEstado(numero) {
            var elemento = document.getElementById('student'+numero);
            var checkedpuntual=   document.getElementById("rbPuntual"+numero).checked;
            if(checkedpuntual)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-check";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-success";
                return;
            }
            var checkedtarde=   document.getElementById("rbTarde"+numero).checked;
            if(checkedtarde)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-warning";
                return;
            }
            var checkedAusente=   document.getElementById("rbAusente"+numero).checked;
            if(checkedAusente)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-danger";
                return;
            }
            var checkedJustificado=   document.getElementById("rbJustificado"+numero).checked;
            if(checkedJustificado)
            {
                var elemento = document.getElementById('student'+numero);
                elemento.className="fa fa-circle";
                
                var elemento2 = document.getElementById('btnStudent'+numero);
                elemento2.className="btn btn-primary";
                return;
            }
        }
    </script>   

    <script>
      const asig_id = $("#id_Asig").val();

    </script>