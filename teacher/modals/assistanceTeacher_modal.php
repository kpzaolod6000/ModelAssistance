<!-- Add -->
<div class="modal fade" id="marcar_save_modal">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Registrar la asistencia</b></h4>
				<div class = "modal-subtitle"></div>
          	</div>
          	<div class="modal-body">
			  	
            	<form class="form-horizontal" method="POST" action="../teacher/assStudents/assistanceTeacher_add.php">
				
				<input type="hidden" id="idAsignature" name="idAsignature">
				<input type="hidden" id="idTeacher" name="idTeacher">
                <div class="form-group">
                  	<label for="theme" class="col-sm-3 control-label">Tema</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="theme" name="theme" required>
                  	</div>
                </div>
                <div class="form-group">
					<label for="ini" class="col-sm-3 control-label">Ingreso</label>
                  	<div class="col-sm-4">
					  	
						<input type="text" class="form-control text-uppercase" id="ini" name="ini" required>
                  	</div>
                    
					<label for="end" class="col-sm-1 control-label">Salida</label>
                  	<div class="col-sm-4">
					  	
						<input type="text" class="form-control text-uppercase" id="end" name="end" required>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="advance" class="col-sm-3 control-label">% de Avance</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control text-uppercase" id="advance" name="advance" required>
                  	</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="assistanceTeacher_add"><i class="fa fa-save"></i> Guardar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>
