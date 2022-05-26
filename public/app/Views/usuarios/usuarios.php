<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		
		<h1 class="h3 mb-1 text-gray-800"><?php echo $titulo; ?></h1>
		
		<form class="mr-4 navbar-search">
			<div class="input-group">
				<input method="POST" type="text" name="info" id="info" action="<?php echo base_url(); ?>/usuarios/buscar" class="form-control bg-light small" placeholder="Buscar...">  
				<div class="input-group-append">
					<button type="submit" class="btn btn-primary" type="button">
						<i class="fas fa-search fa-sm"></i>
					</button>
				</div>
			</div>
		</form>
    </div>
	<!-- Page Heading -->
    
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
							<td><a href="<?php echo base_url(); ?>/usuarios/eliminar/<?php echo $dato['id']; ?>" class="btn btn-dark"><i class="fas fa-arrow-down"></i></a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
