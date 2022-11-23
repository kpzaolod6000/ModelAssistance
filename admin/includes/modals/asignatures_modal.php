<!-- Add -->
<div class="modal fade" id="addnew_asignatures">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
            	<h4 class="modal-title"><b>Agregar Asignatura</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="asignatures_add.php">
                <div class="form-group">
                  	<label for="codes" class="col-sm-3 control-label">Código</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="codes" name="codes">
                  	</div>
                </div>

                <div class="form-group">
                  	<label for="names" class="col-sm-3 control-label">Nombre</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control text-uppercase" id="names" name="names" required>
                  	</div>
                </div>

                <div class="form-group">
                  	<label for="number" class="col-sm-3 control-label">Credito</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="credit" name="credit">
                  	</div>
                </div>

                <div class="form-group">
                    <label for="Pre_requeriments" class="col-sm-3 control-label">Pre-requisitos</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="Pre_requeriments" name="Pre_requeriments">
                    </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-primary btn-flat" name="add_asignature"><i class="fa fa-save"></i> Guardar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Edit id edit_teacher-->
<div class="modal fade" id="edit_asignature">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
					  <h4 class="modal-title"><b>Modificar Datos de la Asignatura </b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="asignatures_edit.php">
            		<input type="hidden" id="edit_id" name="edit_id">
				
                    <div class="form-group">
                  	<label for="edit_codes" class="col-sm-3 control-label">Código</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="edit_codes" name="edit_codes">
                  	</div>
                </div>

                <div class="form-group">
                  	<label for="edit_names" class="col-sm-3 control-label">Nombre</label>

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control text-uppercase" id="edit_names" name="edit_names" required>
                  	</div>
                </div>

                <div class="form-group">
                  	<label for="edit_credit" class="col-sm-3 control-label">Credito</label>

                  	<div class="col-sm-9">
                    	<input type="number" class="form-control" id="edit_credit" name="edit_credit">
                  	</div>
                </div>

                <div class="form-group">
                    <label for="edit_Pre_requeriments" class="col-sm-3 control-label">Pre-requisitos</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="edit_Pre_requeriments" name="edit_Pre_requeriments">
                    </div>
                </div>
				
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-success btn-flat" name="edit_asignature_submit"><i class="fa fa-check-square-o"></i> Actualizar</button>
            	</form>
          	</div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete_asignature">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
              		<span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><b>Desea eliminar esta asignatura? <span class=""></span></b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="asignatures_delete.php">
            		<input type="hidden" id="delete_id" name="delete_id">
            		<div class="text-center">
	                	<!-- <p>Eliminar Estudiante</p> -->
	                	<h2 class="asignature-name bold"></h2>
	            	</div>
          	</div>
          	<div class="modal-footer">
            	<button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Cerrar</button>
            	<button type="submit" class="btn btn-danger btn-flat" name="delete_asignature_submit"><i class="fa fa-trash"></i> Eliminar</button>
            	</form>
          	</div>
        </div>
    </div>

     