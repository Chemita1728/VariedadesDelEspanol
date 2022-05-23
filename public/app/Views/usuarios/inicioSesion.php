<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $titulo; ?></h1>
    </div>
	<!-- Page Heading -->
    
	<div class="contaired-fluid">
		<form method="POST" action="<?php echo base_url(); ?>/usuarios/login" autocomplere="off">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-sm-6">
					<label>Correo</label>
					<input class="form-control" id="email" name="email" type="text" autofocus require />
				</div>
			</div>
            <div class="row">
				<div class="col-12 col-sm-6">
					<label>Contraseña</label>
					<input class="form-control" id="password" name="password" type="password" autofocus require />
				</div>
			</div>
		</div>		
		<a href="<?php echo base_url(); ?>/" class="btn btn-warning">Registrarse</a>
		<button type="submit" class="btn btn-success">Iniciar Sesión</button>
	</div>

</div>
