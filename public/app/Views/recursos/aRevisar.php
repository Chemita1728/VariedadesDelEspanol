<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		
		<h1 class="h3 mb-0 text-gray-800">Recursos a Revisar</h1>

		<form method="POST" action="<?php echo base_url(); ?>/usuarios/buscarColaboradores" class="mr-4 navbar-search">
			<div class="input-group">
				<select class="form-control bg-light" id="donde" name="donde">
					<option value="apellidos">Apellido</option>
					<option value="nombre">Nombre</option>
					<option value="email">Correo</option>
				</select>
				<input type="text" name="info" id="info" class="form-control bg-light small" placeholder="Buscar...">  
				<div class="input-group-append">
					<button type="submit" class="btn btn-primary" type="button">
						<i class="fas fa-search fa-sm"></i>
					</button>
				</div>
			</div>
		</form>

    </div>

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>

    <!-- Content Row -->
    <div class="row">
		
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thread>
					<tr>
						<th>ID</th>
						<th>Titulo</th>
						<th>Autor</th>
						<th>Descripción</th>
                        <th>Responsable</th>
                        <th>Mandado</th>
						<th></th>
					</tr>
				</thread>
				<tbody>
					<?php foreach($resultados as $resultado) { ?>
						<tr>
							<td><?php echo $resultado['resourceID'] ?></td>
							<?php if ( $resultado['state'] < 3 ) { ?>
								<td><?php echo $resultado['title'] ?></td>
							<?php } ?>
							<?php if ( $resultado['state'] >= 3 ) { ?>
								<td style="color: black" ><?php echo $resultado['title'] ?></td>
							<?php } ?>
							<td><?php echo $resultado['nombre']." ".$resultado['apellidos'] ?></td>
							<td><?php echo $resultado['description'] ?></td>
                            <td><?php echo $resultado['respMail'] ?></td>
                            <td><?php echo $resultado['created_at'] ?></td>
							<?php if ( $tipo == 1) { ?>
								<td><a href="<?php echo base_url(); ?>/recursos/revisarRecurso/<?php echo $resultado['resourceID']; ?>" class="btn btn-dark"><i class="fas fa-pen"></i></a></td>
							<?php } ?> 
							<?php if ( $tipo == 2) { ?>
								<td><a href="<?php echo base_url(); ?>/recursos/validarRecurso/<?php echo $resultado['resourceID']; ?>" class="btn btn-dark"><i class="fas fa-pen"></i></a></td>
							<?php } ?> 
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
