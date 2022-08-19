<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $titulo; ?></h1>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
    <form method="POST" action="<?php echo base_url(); ?>/usuarios/actualizar" autocomplere="off">

        <?php
			function cambioNivelEsp($numero){
				$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
				return $valor[$numero -1];
			}
		?>

	<div class="contaired-fluid">
		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800 col-12">Información Personal </h1>
			</div>
			<div class="row"> <input type="hidden" id="id"  name="id" value="<?php echo $datos['id']; ?>"/>
				<div class="col-12 ">
					<label>Nombre: <?php echo $datos['nombre']; ?></label>
				</div>
				<div class="col-12 ">
					<label>Apellidos: <?php echo $datos['apellidos']; ?></label>
				</div>
				<div class="col-12 ">
					<label>Nivel de Español: <?php echo cambioNivelEsp($datos['spanishlvl']) ?></label>
				</div>
				<div class="col-12 ">
					<label>Universidad: <?php echo $datos['university']; ?></label>
				</div>
				<div class="col-12 ">
					<label>Lugar de Nacimiento: <?php echo $datos['birthPlace']; ?></label>
				</div>
			</div>
            
		</div>
        <a href="<?php echo base_url(); ?>/usuarios/cambioDatosPersonales" class="btn btn-secondary">Cambiar Datos</a>
        <a href="<?php echo base_url(); ?>/usuarios/cambioPassPersonal" class="btn btn-secondary">Cambiar Contraseña</a>

		</div>	
	</div>
	</div>

</div>

