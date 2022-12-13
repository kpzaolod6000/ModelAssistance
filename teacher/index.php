<?php
  session_start();
  if(isset($_SESSION['teacher'])){
    // echo "administrator access";
	header('location:home.php');
	// $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/AssistanceControl/admin/home.php';
	// header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));

  }
?>
<?php include 'includes/header.php'; 
?>
<style>
.btn-google {
	color: #545454;
    background-color: #ffffff;
    box-shadow: 0 1px 2px 1px #ddd;
}


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

.or-label {
    flex-grow: 1;
    margin: 0 15px;
    text-align: center;
}
</style>
<body class="hold-transition login-page">
<div class="login-box">
  	<div class="login-logo">
  		<b>Login Docente</b>
  	</div>
  
  	<div class="login-box-body">
    	<p class="login-box-msg">Ingresa para iniciar tu sesión</p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="username" placeholder="input Username" required autofocus>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="input Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
			<div class="row">
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Ingresar</button>
				</div>
			</div>
			<div class="or-container"><div class="line-separator"></div> <div class="or-label">or</div><div class="line-separator"></div></div>
    	</form>

		<tbody>
				
				<?php
				
				require_once('loginGoogle.php');


				if (!isset($_GET['code'])) {

					echo "<div class='row'>";
					echo "<div class='col-md-12'>";
					echo "<a class='btn btn-lg btn-google btn-block text-uppercase btn-outline' href='".$client->createAuthUrl()."'><img src='https://img.icons8.com/color/16/000000/google-logo.png'> Signup Using Google</a>";
					echo "</div>";
					echo "</div>";
					// header('location:index.php');
					// now you can use this profile info to create account in your website and make user logged in.
				}
				?>				
			</tbody>
			<!-- <div class="row">
				<div class="col-md-12">
				<a class="btn btn-lg btn-google btn-block text-uppercase btn-outline" href=><img src="https://img.icons8.com/color/16/000000/google-logo.png"> Signup Using Google</a>

				</div>
			</div> -->
  	</div>
	  <a href="../index.php" class="btn btn-success active" role="button" aria-pressed="true"><i class="fa fa-arrow-left"></i><span>Atras</span></a>
  	<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
</div>
	
<?php include 'includes/scripts.php' ?>

</body>

<!-- <script type="text/javascript">

let _GET = <?php echo json_encode($_GET['code']); ?>;

if (_GET) {
	location.reload();
}else{
	console.log("Sin acceso");
}
</script> -->

</html>