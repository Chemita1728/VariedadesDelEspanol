<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Nuevo Recurso</h1>
    </div>
	<!-- Page Heading -->

    <?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>
    
	<form method="POST" action="<?php echo base_url(); ?>/recursos/crearRecurso" autocomplere="off">
	
	<div class="contaired-fluid">
		<div class="form-group">
			<div class="row">
				<div class="col-12 col-sm-6">
					<label>Titulo</label>
					<input class="form-control" id="title" name="title" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-6"></div>
				<div class="col-12 col-sm-8">
					<label>Descripción</label>
					<input class="form-control" id="description" name="description" type="text" autofocus require />
				</div>
                <div class="col-12 col-sm-6">
					<label>Fuente</label>
					<input class="form-control" id="font" name="font" type="text" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Variedad</label>
					<select class="form-control" id="variety" name="variety">
						<option value="1">var1</option>
						<option value="2">var2</option>
						<option value="3">var3</option>
						<option value="4">var4</option>
						<option value="5">var5</option>
						<option value="6">var6</option>
						<option value="7">var7</option>
						<option value="8">var8</option>
						<option value="9">var9</option>
						<option value="10">var10</option>
						<option value="11">var11</option>
						<option value="12">var12</option>
					</select>
				</div>
			</div>	
		</div>	

		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Información Extra </h1>
			</div>
			<div class="row">	
				<div class="col-12 col-sm-6">
					<label>Fichero</label>
					<input class="form-control" id="file" name="file" type="file" autofocus require />
				</div>
				<div class="col-12 col-sm-6">
					<label>Enlace Interesante</label>
					<input class="form-control" id="link" name="link" type="text" autofocus require />
				</div>
			</div>
		</div>
        <?php if (session('role') == 1) { ?>
            <button type="submit" class="btn btn-success">Mandar para Verificación</button>
        <?php } ?> 
        <?php if (session('role') > 1) { ?>
            <button type="submit" class="btn btn-success">Crear Recurso</button>
        <?php } ?> 
        
	</div>

</div>
