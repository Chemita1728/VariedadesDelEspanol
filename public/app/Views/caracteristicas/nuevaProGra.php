<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Nueva <?php echo $proGra['charName'] ?></h1>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
	<form method="POST" action="<?php echo base_url(); ?>/recursos/crearProGra/<?php echo $tipo; ?>" autocomplere="off">     
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-sm-6">
					<label><?php echo $proGra['title1'] ?></label>
					<input class="form-control" id="proGra1" name="proGra1" type="text" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label><?php echo $proGra['title2'] ?></label>
					<input class="form-control" id="proGra2" name="proGra2" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-12">
                    <label><?php echo $proGra['title3'] ?></label>
                    <input class="form-control" id="proGra3" name="proGra3" type="textarea" autofocus require />
                </div>
			</div>	
		</div>

		<button type="submit" class="btn btn-primary">Crear Pronunciación</button>
	</div>

</div>
