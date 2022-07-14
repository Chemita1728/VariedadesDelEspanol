<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Nueva Pronunciación</h1>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
	<form method="POST" action="<?php echo base_url(); ?>/recursos/crearPronunciacion" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-sm-6">
					<label>Pro1</label>
					<input class="form-control" id="pro1" name="pro1" type="text" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Pro2</label>
					<input class="form-control" id="pro2" name="pro2" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-12">
                    <label>Pro3</label>
                    <input class="form-control" id="pro3" name="pro3" type="textarea" autofocus require />
                </div>
			</div>	
		</div>

		<button type="submit" class="btn btn-success">Crear Pronunciación</button>
	</div>

</div>
