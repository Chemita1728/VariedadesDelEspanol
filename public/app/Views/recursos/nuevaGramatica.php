<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Nueva Gramática</h1>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
	<form method="POST" action="<?php echo base_url(); ?>/recursos/crearGramatica" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-sm-6">
					<label>Gra1</label>
					<input class="form-control" id="gra1" name="gra1" type="text" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Gra2</label>
					<input class="form-control" id="gra2" name="gra2" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-12">
                    <label>Gra3</label>
                    <input class="form-control" id="gra3" name="gra3" type="textarea" autofocus require />
                </div>
			</div>	
		</div>

		<button type="submit" class="btn btn-primary">Crear Gramática</button>
	</div>

</div>
