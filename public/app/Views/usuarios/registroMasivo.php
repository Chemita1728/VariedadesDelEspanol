<div class="container-fluid">


	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Registro Masivo</h1>
    </div>
	<!-- Page Heading -->
    
    <form method="POST" action="<?php echo base_url(); ?>/usuarios/cargarArchivo" enctype="multipart/form-data" target="_blank">

	<div class="contaired-fluid">
		<div class="form-group">
                <input type="hidden" id="respMail" name="respMail" type="text" value="<?php echo session('email'); ?>">
                <input type="hidden" id="respNombre" name="respNombre" type="text" value="<?php echo session('nombre'); ?>">
                <input type="hidden" id="respApellidos" name="respApellidos" type="text" value="<?php echo session('apellidos'); ?>">
				<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800 col-12">Archivo que contiene los usuarios a introducir: </h1>
			</div>
				<div class="col-12 col-sm-6">
					<input class="form-control" id="archivo" name="archivo" type="file"/>
				</div>
			</div> 
		</div>
        <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-warning">Volver</a>
		<button type="submit" class="btn btn-success">Registrar todos</button>
		
        </div>	
	</div>
	</div>

</div>

