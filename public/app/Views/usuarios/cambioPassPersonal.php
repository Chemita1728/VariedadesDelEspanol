<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $titulo; ?></h1>
    </div>
	<!-- Page Heading -->
    
    <form method="POST" action="<?php echo base_url(); ?>/usuarios/cambiarPassPersonal" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Informacón Personal</h1>
			</div>
			<div class="row"> <input type="hidden" id="id"  name="id" value="<?php echo $id ?>"/>
				<div class="col-12 col-sm-6">
					<label>Antigua Contraseña</label>
					<input class="form-control" id="antPass" name="antPass" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-6"></div>
				<div class="col-12 col-sm-6">
					<label>Nueva Contraseña</label>
					<input class="form-control" id="nuevaPass" name="nuevaPass" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-6">
					<label>Repita la nueva contraseña</label>
					<input class="form-control" id="nuevaPass2" name="nuevaPass2" type="text" autofocus require />
				</div>
			</div>
		</div>

		</div>	
		<a href="<?php echo base_url(); ?>/usuarios/datosPersonales" class="btn btn-warning">Volver</a>
		<button type="submit" class="btn btn-success">Guardar</button>
	</div>
	</div>

</div>

