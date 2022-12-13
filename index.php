<?php session_start(); ?>
<?php include 'header.php'; ?>
<body class="hold-transition login-page">
<style>

.or-container {
    align-items: center;
    color: #ccc;
    display: flex;
    margin: 25px 0;
}

.line-separator {
    background-color: #ccc;
    flex-grow: 5;
    height: 1px;
}

.roles-std{
  margin-left: 31px;
  width: 250px;
  display: flex;
  justify-content: space-between;
}

.user-image-student{
  width: 120px;
  height: 120px;
  border-radius: 25px;
  margin-left: 20px;
  margin-right: 70px;
}

.user-image-student:hover{
  width: 130px;
  height: 130px;
}

.user-image-teacher{
  width: 120px; 
  height: 120px; 
  border-radius: 25px;
}
.user-image-teacher:hover{
  width: 130px;
  height: 130px;
}

</style>

<div class="login-box">
  	<div class="login-logo">
  		<p id="date"></p>
      <p id="time" class="bold"></p>
  	</div>
  
  	<div class="login-box-body">
    	<h4 class="login-box-msg">Selección de Usuarios</h4>
         
            <div class="roles-std">
              <div class="p-student">
                <h5>Estudiante</h5>
              </div>
              <div class="p-teacher">
                <h5>Docente</h5>
              </div>
            </div>
         
          <div class="row">
          <!-- <button class='btn btn-success btn-sm docente btn-flat'><i class='fa fa-edit'></i></button> -->
            
            <a href="./student/index.php"><img src='./images/student.jpg' class="user-image-student" alt="User Image Student"></a>
            <a href="./teacher/index.php"><img src='./images/teacher.jpg' class="user-image-teacher" alt="User Image Teacher"></a>
            
          </div>
          <div class="or-container"><div class="line-separator"></div> </div>
          <div class="row">
      			
              <a style = "margin-right: 215px; cursor:pointer; ">Director</a>
              <a href="./admin/index.php" style = "cursor:pointer; ">Administrador</a>
        		
      		</div>
    	
  	</div>
		<div class="alert alert-success alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-check"></i> <span class="message"></span></span>
    </div>
		<div class="alert alert-danger alert-dismissible mt20 text-center" style="display:none;">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      <span class="result"><i class="icon fa fa-warning"></i> <span class="message"></span></span>
    </div>
  		
</div>
	
<?php include 'scripts.php' ?>
<script type="text/javascript">
$(function() {
  var interval = setInterval(function() {
    var momentNow = moment();
    $('#date').html(momentNow.format('dddd').substring(0,3).toUpperCase() + ' - ' + momentNow.format('MMMM DD, YYYY'));
    // $('#time').html(momentNow.format('hh:mm:ss A'));
    $('#time').html(momentNow.format('hh:mm:ss a'));
  }, 100);

  $('#attendance').submit(function(e){
    e.preventDefault();
    var attendance = $(this).serialize();
    $.ajax({
      type: 'POST',
      url: 'attendance.php',
      data: attendance,
      dataType: 'json',
      success: function(response){
        if(response.error){
          $('.alert').hide();
          $('.alert-danger').show();
          $('.message').html(response.message);
        }
        else{
          $('.alert').hide();
          $('.alert-success').show();
          $('.message').html(response.message);
          $('#employee').val('');
        }
      }
    });
  });
    
});
</script>
</body>
</html>