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
    
	<form method="POST" action="<?php echo base_url(); ?>/recursos/crearRecurso" autocomplere="off" enctype="multipart/form-data">
	
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
					<textarea class="form-control" id="description" name="description" type="text" rows="5" autofocus require></textarea>
				</div>
				<div class="col-12 col-sm-6">
					<label>Nivel de Español de la gente a la que va dirigido el recurso</label>
					<select class="form-control" id="nivel" name="nivel">
						<option value="1">A1</option>
						<option value="2">A2</option>
						<option value="3">B1</option>
						<option value="4">B2</option>
						<option value="5">C1</option>
						<option value="6">C2</option>
					</select>
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
				<h1 class="h5 mb-0 text-gray-800">Material audiovisual </h1>
			</div>
			<div class="row">	
				<div class="col-12 col-sm-6">
					<label>Fuente del Material Audiovisual</label>
					<select class="form-control" id="source" name="source">
						<option value="" selected="selected">Seleccione una fuente</option>
						<option value="Youtube">Youtube</option>
						<option value="Kahoot">Kahoot</option>
					</select>
				</div>
				<div class="col-12 col-sm-6">
					<label>Enlace del Material</label>
					<input class="form-control" id="link" name="link" type="text" autofocus require />
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Archivo relacionado con el recurso </h1>
			</div>
			<div class="row">	
				<div class="col-12 col-sm-6">
					<input class="form-control" id="file" name="file" type="file">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Rasgos </h1>
			</div>
			<div class="row">

				<?php for ($i = 1; $i <= 2; $i++) { ?>
					<?php 
						if($i == 1) { $vector="pro[]"; $nombre = "Pronunciacion"; $titulo = "Pronunciación"; }
						if($i == 2) { $vector="gra[]"; $nombre = "Gramatica"; $titulo = "Gramática"; }
					?>
					<div class="col-lg-6">
						<div class="card shadow mb-4">
							<!-- Card Header - Accordion -->
							<a href="#<?php echo $nombre ?>" class="d-block card-header py-3" data-toggle="collapse"
							role="button" aria-expanded="true" aria-controls="<?php echo $nombre ?>">
							<h6 class="m-0 font-weight-bold"><?php echo $titulo ?></h6>
							</a>
							<!-- Card Content - Collapse -->
							<div class="collapse" id="<?php echo $nombre ?>">
								<div class="card-body">
									<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
										<tbody>
												<?php foreach($valores as $valor) { ?>
													<tr>
														<?php if($valor['charID'] == $i) { ?>
															<td><?php echo $valor['at1'] ?></td>
															<td><input type="checkbox" name="<?php echo $vector ?>" value="<?php echo $valor['valID'] ?>"/></td>
														<?php }?>
													</tr>
												<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				
				<div class="col-lg-12">
					<div class="card shadow mb-4">
						<!-- Card Header - Accordion -->
						<a href="#vocabulario" class="d-block card-header py-3" data-toggle="collapse"
						role="button" aria-expanded="true" aria-controls="vocabulario">
							<h6 class="m-0 font-weight-bold">Vocabulario</h6>
						</a>
					<!-- Card Content - Collapse -->
					<div class="collapse" id="vocabulario">
						<div class="card-body">
							<div class="input-group col-lg-4 mb-4">
								<input type="text" name="buscarVoc" id="buscarVoc" class="form-control bg-light" placeholder="Buscar..."> 
								<div class="input-group-append">
									<button class="btn btn-primary" disabled>
										<i class="fas fa-search fa-sm"></i>
									</button>
								</div> 
							</div>
							<div id="botonNuevoVocabulario" class="input-group col-lg-4" style="display: none">
								<button type="button" onclick="ocultarDesocultarNuevoVocabulario()" class="btn btn-primary">Añadir nuevo vocabulario</button>
							</div>
							<table class="table table-bordered" id="tablaVocabulario" width="100%" cellspacing="0">
								<tbody></tbody>
							</table>
							</div>
						</div>
					</div>
				</div>

				<table class="table table-bordered" id="vocabularioFinal" width="100%" cellspacing="0" style="display: none">
					<tbody></tbody>
				</table>

				<div id="nuevoVocabulario" class="col-lg-12" style="display: none">
					<!-- Approach -->
					<div class="card shadow mb-4">
						<div class="card-body">

							<label>Lema</label>
							<div class="input-group col-lg-6 mb-4">
								<input class="form-control" id="vocLema" name="vocLema" type="text" autofocus require />
							</div>
							<label>Forma</label>
							<div class="input-group col-lg-6 mb-4">
								<input class="form-control" id="vocForma" name="vocForma" type="text" autofocus require />
							</div>
							<label>Significado</label>
							<div class="input-group col-lg-12 mb-4">
								<input class="form-control" id="vocSignificado" name="vocSignificado" type="text" autofocus require />
							</div>

							<button type="button" onclick="introducirVocabulario()" class="btn btn-primary">Añadir Vocabulario</button>
							
						</div>
					</div>
				</div>
				
			</div>
		</div>

		<script>

			buscarVocabulario();

			var seleccionados = [];
			function ordenarArray(a, b) {
				return a - b;
			}
			$(document).on('click', "input:checkbox", getChecked);
			function getChecked(){
				//esta variable son los checkboxes que se ven
				var voc=document.getElementsByName("voc[]");
				//recorremos estos checkboxes
				for(var i=0; i<voc.length; i++){
					if( voc[i].checked == true && !seleccionados.includes(voc[i].value) ){
						//metemos en el array de seleccionados el valor del checkbox
						seleccionados.push(voc[i].value);
					} else if( voc[i].checked == false && seleccionados.includes(voc[i].value) ) {
						seleccionados.splice(seleccionados.indexOf(voc[i].value),1);
					}
				}
				seleccionados.sort(ordenarArray)
				//console.log(seleccionados);
				//borramos la tabla que almacena el vocabulario seleccionado
				$("#vocabularioFinal tr").remove(); 
				for(var i=0; i<seleccionados.length; i++){
					//hacemos una fila en la tabla invisible para poder almacenar el dato en un input del html
					document.getElementById("vocabularioFinal").insertRow(-1).innerHTML = '<td id="voc'+seleccionados[i]+'"><td><input type="checkbox" name="vocFinal[]" value="'+seleccionados[i]+'" checked/></td>';
					$('#voc'+seleccionados[i]+'').html(seleccionados[i]);			
				}

			}

			function ocultarDesocultarNuevoVocabulario() {
				var form = document.getElementById("nuevoVocabulario");
				if ( form.style.display === "none" ) {
					form.style.display = "block";
				} else {
					form.style.display = "none";
				}
			}

			$(document).on('keyup', '#buscarVoc', function(){
				var palabra = $(this).val();
				if( palabra != "" ){
					buscarVocabulario(palabra);
				}else{
					buscarVocabulario();
				}
			});

			function buscarVocabulario(palabra){
				$.ajax({
					url: "<?php echo base_url(); ?>/recursos/buscarVocabulario",
					method: "POST",
					data: {palabra: palabra}
				}).done(function(res){
					var datos = JSON.parse(res);
					
					$("#tablaVocabulario tr").remove(); 
					datos.forEach(function(dato, index) {
						var num = index+1;
						var checked = false;
						//vemos si esta seleccionado
						for(var i=0; i<seleccionados.length && checked == false; i++){
							if( dato.valID == seleccionados[i] ) checked = true;
						}
						if( checked == true ){
							document.getElementById("tablaVocabulario").insertRow(-1).innerHTML = '<td id="'+index+'1"></td><td id="'+index+'2"></td><td id="'+index+'3"></td><td><input type="checkbox" name="voc[]" value="'+dato.valID+'" checked/></td>';
						} else {
							document.getElementById("tablaVocabulario").insertRow(-1).innerHTML = '<td id="'+index+'1"></td><td id="'+index+'2"></td><td id="'+index+'3"></td><td><input type="checkbox" name="voc[]" value="'+dato.valID+'"/></td>';
						}
						$('#'+index+'1').html(dato.at1);
						$('#'+index+'2').html(dato.at2);
						$('#'+index+'3').html(dato.at3);
					});
					var boton = document.getElementById("botonNuevoVocabulario");
					if( datos.length == 0 ){
						boton.style.display = "block";
					} else 	boton.style.display = "none";
				})
			}

			function introducirVocabulario(){
				var lema = document.getElementById("vocLema").value;
				var forma = document.getElementById("vocForma").value;
				var sign = document.getElementById("vocSignificado").value;
				$.ajax({
					url: "<?php echo base_url(); ?>/recursos/introducirVocabulario",
					method: "POST",
					data: {lema: lema, forma: forma, sign: sign}
				}).done(function(){
					ocultarDesocultarNuevoVocabulario();
					document.getElementById("buscarVoc").value = "";
					buscarVocabulario();
				})
			}

		</script>

        <?php if (session('role') == 1) { ?>
            <button type="submit" class="btn btn-primary">Mandar para Verificación</button>
        <?php } ?> 
        <?php if (session('role') > 1) { ?>
            <button type="submit" class="btn btn-primary">Crear Recurso</button>
        <?php } ?> 
        
	</div>

</div>
