<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Nuevo Usuario</h1>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
	<form method="POST" action="<?php echo base_url(); ?>/usuarios/registroTemporal" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="row">
				<input type="hidden" id="respMail" name="respMail" type="text" value="<?php echo session('email'); ?>">
                <input type="hidden" id="respNombre" name="respNombre" type="text" value="<?php echo session('nombre'); ?>">
                <input type="hidden" id="respApellidos" name="respApellidos" type="text" value="<?php echo session('apellidos'); ?>">
				<div class="col-12 col-sm-6">
					<label>Nombre</label>
					<input class="form-control" id="nombre" name="nombre" type="text" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Apellidos</label>
					<input class="form-control" id="apellidos" name="apellidos" type="text" autofocus require />
				</div>
			</div>	
		</div>	

		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Informacón Logica </h1>
			</div>
			<div class="row">	
				<div class="col-12 col-sm-6">
					<label>Correo</label>
					<input class="form-control" id="email" name="email" type="text" autofocus require />
				</div>
			</div>
		</div>

		<a href="<?php echo base_url(); ?>/usuarios" class="btn btn-warning">Volver</a>
		<button type="submit" class="btn btn-success">Mandar correo para el Registro</button>
	</div>

</div>
