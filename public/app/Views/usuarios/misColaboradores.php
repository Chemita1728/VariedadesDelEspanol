<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		
		<h1 class="h3 mb-1 text-gray-800"><?php echo $titulo; ?></h1>
		
		<div class="mr-4 navbar-search"> 
			<div class="input-group mr-4 navbar-search">
				<select class="form-control bg-light" id="parametro" name="parametro">
					<option value="apellidos">Apellido</option>
					<option value="nombre">Nombre</option>
					<option value="email">Correo</option>
				</select>
				<input type="text" name="buscarUsuario" id="buscarUsuario" class="form-control bg-light" placeholder="Buscar...">  
				<div class="input-group-append">
					<button type="submit" class="btn btn-primary" disabled>
						<i class="fas fa-search fa-sm"></i>
					</button>
				</div>
			</div>
		</div>
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>

	<div>
		<p>
			<a href="<?php echo base_url(); ?>/usuarios/nuevoUsuario" class="btn btn-primary">Nuevo Usuario</a>
		</p>
	</div>
    <!-- Content Row -->
    <div class="row">

		<div class="table-responsive">
			<table class="table table-bordered" width="100%" cellspacing="0">
				<thread>
					<tr>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Correo</th>
						<th>Nivel de Español</th>
						<th>Universidad</th>
						<th>Lugar de Nacimiento</th>
						<th></th>
						<th></th>
					</tr>
				</thread>
				<tbody id="tablaUsuarios"></tbody>
			</table>
		</div>	
	</div>

	<script>

			buscarUsuarios();

			function cambiarNivelEsp(numero){
				valor = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo'];
				return valor[numero -1];
			}

			$(document).on('keyup', '#buscarUsuario', function(){
				var palabra = $(this).val();
				if( palabra != "" ){
					buscarUsuarios(palabra);
				}else{
					buscarUsuarios();
				}
			});
			
			function buscarUsuarios(palabra){
				var parametro = document.getElementById("parametro").value;
				$.ajax({
					url: "<?php echo base_url(); ?>/usuarios/buscarMisColaboradores",
					method: "POST",
					data: {palabra: palabra, parametro: parametro}
				}).done(function(res){
					var datos = JSON.parse(res);
					$("#tablaUsuarios tr").remove(); 
					datos.forEach(function(dato, index) {
						document.getElementById("tablaUsuarios").insertRow(-1).innerHTML = '<td id="'+index+'1"></td><td id="'+index+'2"></td><td id="'+index+'3"></td><td id="'+index+'4"></td><td id="'+index+'5"></td><td id="'+index+'6"></td><td><a href="'+window.location.origin+'/usuarios/editar/'+dato.id+'" class="btn btn-dark"><i class="fas fa-pencil-alt"></i></a></td><td><a href="'+window.location.origin+'/usuarios/desactivar/'+dato.id+'" class="btn btn-dark"><i class="fas fa-arrow-down"></i></a></td>';
						$('#'+index+'1').html(dato.nombre);
						$('#'+index+'2').html(dato.apellidos);
						$('#'+index+'3').html(dato.email);
						$('#'+index+'4').html(cambiarNivelEsp(dato.spanishlvl));
						$('#'+index+'5').html(dato.university);
						$('#'+index+'6').html(dato.birthPlace);
					});
				})
			}

		</script>

</div>
