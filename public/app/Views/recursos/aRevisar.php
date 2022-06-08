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
						<th>Titulo</th>
						<th>Autor</th>
						<th>Descripción</th>
                        <th>Responsable</th>
                        <th>Mandado</th>
						<th></th>
					</tr>
				</thread>
				<tbody>
					<?php foreach($recursos as $recurso) { ?>
						<tr>
							<td><?php echo $recurso['title'] ?></td>
							<td><?php echo $recurso['autor'] ?></td>
							<td><?php echo $recurso['description'] ?></td>
                            <td><?php echo $recurso['editor'] ?></td>
                            <td><?php echo $recurso['created_at'] ?></td>
							<td><a href="<?php echo base_url(); ?>/recursos/validarRecurso/<?php echo $recurso['resourceID']; ?>" class="btn btn-dark"><i class="fas fa-pen"></i></a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
