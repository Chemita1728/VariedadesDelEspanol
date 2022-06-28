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
						<option value="1">Castellano</option>
						<option value="2">Andaluz</option>
						<option value="3">Canario</option>
						<option value="4">Caribeño</option>
						<option value="5">Mexicano-Centroamericano</option>
						<option value="6">Andino</option>
						<option value="7">Austral</option>
						<option value="8">Chileno</option>
						<option value="9">Español de Guinea Ecuatorial</option>
						<option value="10">Judeoespañol</option>
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

		<div class="row">

			<?php for ($i = 1; $i <= 3; $i++) { ?>
				<div class="col-lg-4">
					<div class="card shadow mb-4">
						<!-- Card Header - Accordion -->
						<a href="#gramatica" class="d-block card-header py-3" data-toggle="collapse"
							role="button" aria-expanded="true" aria-controls="gramatica">
							<?php if($i == 1) { ?>
								<h6 class="m-0 font-weight-bold">Pronunciación</h6>
							<?php } ?>
							<?php if($i == 2) { ?>
								<h6 class="m-0 font-weight-bold">Gramatica</h6>
							<?php } ?>
							<?php if($i == 3) { ?>
								<h6 class="m-0 font-weight-bold">Vocabulario</h6>
							<?php } ?>
						</a>
						<!-- Card Content - Collapse -->
						<div class="collapse" id="gramatica">
							<div class="card-body">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<tbody>
										<?php if($i == 1) { ?>
											<?php foreach($valores as $valor) { ?>
												<tr>
													<?php if($valor['charID'] == 1) { ?>
														<td><?php echo $valor['at1'] ?></td>
														<td><input type="checkbox" name="pro[]" value="<?php echo $valor['valID'] ?>"/></td>
													<?php }?>
												</tr>
											<?php } ?>
										<?php } ?>
										<?php if($i == 2) { ?>
											<?php foreach($valores as $valor) { ?>
												<tr>
													<?php if($valor['charID'] == 2) { ?>
														<td><?php echo $valor['at1'] ?></td>
														<td><input type="checkbox" name="gra[]" value="<?php echo $valor['valID'] ?>"/></td>
													<?php }?>
												</tr>
											<?php } ?>
										<?php } ?>
										<?php if($i == 3) { ?>
											<?php foreach($valores as $valor) { ?>
												<tr>
													<?php if($valor['charID'] == 3) { ?>
														<td><?php echo $valor['at1'] ?></td>
														<td><input type="checkbox" name="voc[]" value="<?php echo $valor['valID'] ?>"/></td>
													<?php }?>
												</tr>
											<?php } ?>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</div>

        <?php if (session('role') == 1) { ?>
            <button type="submit" class="btn btn-success">Mandar para Verificación</button>
        <?php } ?> 
        <?php if (session('role') > 1) { ?>
            <button type="submit" class="btn btn-success">Crear Recurso</button>
        <?php } ?> 
        
	</div>

</div>
