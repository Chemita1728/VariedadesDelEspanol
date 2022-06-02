<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		
		<h1 class="h3 mb-1 text-gray-800"><?php echo $titulo; ?></h1>
		
		<?php if ( $tipo['funcion'] == 0 ) { ?>
			<form method="POST" action="<?php echo base_url(); ?>/usuarios/buscarActivo" class="mr-4 navbar-search">
		<?php } ?> 
		<?php if ( $tipo['funcion'] == 1 ) { ?>
			<form method="POST" action="<?php echo base_url(); ?>/usuarios/buscarNoActivo" class="mr-4 navbar-search">
		<?php } ?> 
			<div class="input-group">
				<select class="form-control bg-light" id="donde" name="donde">
					<option value="apellidos">Apellido</option>
					<option value="nombre">Nombre</option>
					<option value="email">Correo</option>
				</select>
				<input type="text" name="info" id="info" class="form-control bg-light" placeholder="Buscar...">  
				<div class="input-group-append">
					<button type="submit" class="btn btn-primary" type="button">
						<i class="fas fa-search fa-sm"></i>
					</button>
				</div>
			</div>
		</form>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>

	<div>
		<p>
			<a href="<?php echo base_url(); ?>/usuarios/nuevoUsuario" class="btn btn-info">Nuevo Usuario</a>
		</p>
	</div>
    <!-- Content Row -->
    <div class="row">

		<?php
			function cambioRol($numero){
				$valor = array ( 'Colaborador', 'Experto', 'Administrador');
				return $valor[$numero - 1];
			}
			function cambioNivelEsp($numero){
				$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
				return $valor[$numero -1];
			}
		?>
		
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thread>
					<tr>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Correo</th>
						<th>Rol</th>
						<th>Nivel de Español</th>
						<th>Universidad</th>
						<th>Lugar de Nacimiento</th>
						<th>Responsable</th>
						<th></th>
						<th></th>
					</tr>
				</thread>
				<tbody>
					<?php foreach($datos as $dato) { ?>
						<input type="hidden" value="<?php echo $dato['id']; ?>">
						<tr>
							<td><?php echo $dato['nombre'] ?></td>
							<td><?php echo $dato['apellidos'] ?></td>
							<td><?php echo $dato['email'] ?></td>
							<td><?php echo cambioRol($dato['role']) ?></td>
							<td><?php echo cambioNivelEsp($dato['spanishlvl']) ?></td>
							<td><?php echo $dato['university'] ?></td>
							<td><?php echo $dato['birthPlace'] ?></td>
							<td><?php echo $dato['respMail'] ?></td>

							<td><a href="<?php echo base_url(); ?>/usuarios/editar/<?php echo $dato['id']; ?>" class="btn btn-dark"><i class="fas fa-pencil-alt"></i></a></td>
							<?php if ( $tipo['funcion'] == 0 && $dato['role'] != 3 ) { ?>
								<td><a href="<?php echo base_url(); ?>/usuarios/desactivar/<?php echo $dato['id']; ?>" class="btn btn-dark"><i class="fas <?php echo $tipo['flecha']; ?>"></i></a></td>
							<?php } ?> 
							<?php if ($tipo['funcion'] == 1) { ?>
								<td><a href="<?php echo base_url(); ?>/usuarios/activar/<?php echo $dato['id']; ?>" class="btn btn-dark"><i class="fas <?php echo $tipo['flecha']; ?>"></i></a></td>
							<?php } ?>  
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
