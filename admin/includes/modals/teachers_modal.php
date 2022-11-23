<!-- Add -->
<div class="modal fade" id="addnew_teachers">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Agregar Datos del Docente</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="teachers_add.php">
          		<div class="form-group">
                  	<label for="names" class="col-sm-3 control-label">Nombres</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control text-uppercase" id="names" name="names" required>
                  	</div>
                </div>
                <div class="form-group">
                  	<label for="surnames" class="col-sm-3 control-label">Apellidos</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control text-uppercase" id="surnames" name="surnames" required>
                  	</div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Correo</label>

                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gender" class="col-sm-3 control-label">Genero</label>
                    
					<div class="form-check-inline">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="gender" id = "gender_m" value="M">M
						</label>
					</div>
					<div class="form-check-inline">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="gender" id = "gender_f" value="F">F
						</label>
					</div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add_teacher"><i class="fa fa-save"></i> Guardar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit id edit_teacher-->
<div class="modal fade" id="edit_teacher">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
					  <h4 class="modal-title"><b>Modificar los Datos del Teacher <span class="user_teacher_cui"></span> <span class="teachers_name"></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="teachers_edit.php">
            		<input type="hidden" id="edit_id" name="edit_id">
				
				<div class="form-group">
                    <label for="l_edit_names" class="col-sm-3 control-label">Nombres</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control text-uppercase" id="edit_names" name="edit_names" required>
                    </div>
                </div>

				<div class="form-group">
                    <label for="l_edit_surnames" class="col-sm-3 control-label">Apellidos</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control text-uppercase" id="edit_surnames" name="edit_surnames" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="l_edit_email" class="col-sm-3 control-label">Email</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_email" name="edit_email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="l_edit_gender" class="col-sm-3 control-label">Genero</label>
                    
					<div class="form-check-inline">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="edit_gender" id = "edit_gender_m" value="M" checked = "false">M
						</label>
					</div>
					<div class="form-check-inline">
						<label class="form-check-label">
							<input type="radio" class="form-check-input" name="edit_gender" id = "edit_gender_f" value="F" checked = "false">F
						</label>
					</div>
                </div>
				
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit_teacher_submit"><i class="fa fa-check-square-o"></i> Actualizar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_teacher">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><b>Desea eliminar los registros de este docente? <span class=""></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="teachers_delete.php">
            		<input type="hidden" id="delete_id" name="delete_id">
            		<div class="text-center">
	                	<!-- <p>Eliminar Estudiante</p> -->
	                	<h2 class="teacher-name bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete_teacher_submit"><i class="fa fa-trash"></i> Eliminar</button>
            	</form>
          	</div>
        </div>
    </div>

     