<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $titulo; ?></h1>
    </div>
	<!-- Page Heading -->
    
    <form method="POST" action="<?php echo base_url(); ?>/usuarios/cambiarDatosPersonales" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Informacón Personal</h1>
			</div>
			<div class="row"> <input type="hidden" id="id"  name="id" value="<?php echo $datos['id']; ?>"/>
				<div class="col-12 col-sm-6">
					<label>Nombre</label>
					<input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre']; ?>" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Apellidos</label>
					<input class="form-control" id="apellidos" name="apellidos" type="text" value="<?php echo $datos['apellidos']; ?>" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Nivel de Español</label>
					<?php
						$selected = $datos['spanishlvl'];
					?>  
					<select class="form-control" id="spanishlvl" name="spanishlvl" value="3">
						<option <?php if($selected == '1'){echo("selected");}?> value="1">A1</option>
						<option <?php if($selected == '2'){echo("selected");}?> value="2">A2</option>
						<option <?php if($selected == '3'){echo("selected");}?> value="3">B1</option>
						<option <?php if($selected == '4'){echo("selected");}?> value="4">B2</option>
						<option <?php if($selected == '5'){echo("selected");}?> value="5">C1</option>
						<option <?php if($selected == '6'){echo("selected");}?> value="6">C2</option>
					</select>
				</div>
				<div class="col-12 col-sm-6">
					<label>Universidad</label>
					<input class="form-control" id="university" name="university" type="text" value="<?php echo $datos['university']; ?>" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Lugar de Nacimiento</label>
					<input class="form-control" id="birthPlace" name="birthPlace" type="text" value="<?php echo $datos['birthPlace']; ?>" autofocus require />
				</div>
			</div>
		</div>

		</div>	
		<a href="<?php echo base_url(); ?>/usuarios/datosPersonales" class="btn btn-secondary">Volver</a>
		<button type="submit" class="btn btn-primary">Guardar</button>
	</div>
	</div>

</div>

