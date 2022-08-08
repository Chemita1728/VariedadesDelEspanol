<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $titulo; ?></h1>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
	<form method="POST" action="<?php echo base_url(); ?>/usuarios/insertar" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="row">
				<input type="hidden" id="id" name="id" type="text" value="<?php echo $datos['id'] ?>">
				<div class="col-12 col-sm-6">
					<label>Nombre</label>
					<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre'] ?>" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Apellidos</label>
					<input class="form-control" id="apellidos" name="apellidos" type="text" value="<?php echo $datos['apellidos'] ?>" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Nivel de Español</label>
					<select class="form-control" id="spanishlvl" name="spanishlvl">
						<option value="1">A1</option>
						<option value="2">A2</option>
						<option value="3">B1</option>
						<option value="4">B2</option>
						<option value="5">C1</option>
						<option value="6">C2</option>
					</select>
				</div>
				<div class="col-12 col-sm-6">
					<label>Universidad</label>
					<input class="form-control" id="university" name="university" type="text" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Lugar de Nacimiento</label>
					<input class="form-control" id="birthPlace" name="birthPlace" type="text" autofocus require />
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
					<input class="form-control" id="email" name="email" type="text" value="<?php echo $datos['email'] ?>" disabled />
				</div>
				<div class="col-12 col-sm-6"></div>
				<div class="col-12 col-sm-6">
					<label>Contraseña</label>
					<input class="form-control" id="password" name="password" type="password" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Repite Contraseña</label>
					<input class="form-control" id="password2" name="password2" type="password" autofocus require />
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary">Guardar</button>
        
	</div>

</div>
