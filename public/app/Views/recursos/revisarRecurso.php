<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Revisar Recurso</h1>
    </div>
	<!-- Page Heading -->

    <div class="contaired-fluid mb-4">
		<div class="form-group">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Comentario del revisor de este recurso</h6>
                </div>
                <div class="card-body">
                    <p><?php echo $recurso['expComment']; ?></p>
                </div>
			</div>
		</div>

        <button onclick="desocultarForm()" class="btn btn-secondary"> Editar Recurso </button>
	
	</div>

    <form method="POST" action="<?php echo base_url(); ?>/recursos/mandarRevision/<?php echo $recurso['resourceID']; ?>" autocomplere="off" enctype="multipart/form-data">
	
	<div class="contaired-fluid" style="display: none" id="formEntero">
		<div class="form-group">

			<?php
				$selectedFornat = $recurso['source'];
				$selectedVariety = $recurso['variety'];
				$selectedSpLevel = $recurso['spanishlvlRes'];
				function cambioNivelEsp($numero){
					$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2' );
					return $valor[$numero -1];
				}
				function cambioVariedad($numero){
					$valor = array ( 'Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol');
					return $valor[$numero -1];
				}
			?> 

			<div class="row">
				<input type="hidden" type="text" id="idRec"  name="idRec" value="<?php echo $recurso['resourceID']; ?>"/>
                <input type="hidden" id="state"  name="state" value="<?php echo $recurso['state']; ?>"/>    
				<div class="col-12 col-sm-6">
					<label>Titulo</label>
					<input class="form-control" id="title" name="title" type="text" value="<?php echo $recurso['title']; ?>"/>
				</div>
                <div class="col-12 col-sm-6"></div>
				<div class="col-12 col-sm-8">
					<label>Descripción</label>
					<input class="form-control" id="description" name="description" type="text" value="<?php echo $recurso['description']; ?>"/>
				</div>
				<div class="col-12 col-sm-6">
					<label>Nivel de Español de la gente a la que va dirigido el recurso</label>
					<select class="form-control" id="nivel" name="nivel">
						<option <?php if($selectedSpLevel == '1'){echo("selected");}?> value="1">A1</option>
						<option <?php if($selectedSpLevel == '2'){echo("selected");}?> value="2">A2</option>
						<option <?php if($selectedSpLevel == '3'){echo("selected");}?> value="3">B1</option>
						<option <?php if($selectedSpLevel == '4'){echo("selected");}?> value="4">B2</option>
						<option <?php if($selectedSpLevel == '5'){echo("selected");}?> value="5">C1</option>
						<option <?php if($selectedSpLevel == '6'){echo("selected");}?> value="6">C2</option>
					</select>
				</div>
				<div class="col-12 col-sm-6">
					<label>Variedad</label>
					<select class="form-control" id="variety" name="variety">
						<option <?php if($selectedVariety == '1'){echo("selected");}?> value="1">Castellano</option>
						<option <?php if($selectedVariety == '2'){echo("selected");}?> value="2">Andaluz</option>
						<option <?php if($selectedVariety == '3'){echo("selected");}?> value="3">Canario</option>
						<option <?php if($selectedVariety == '4'){echo("selected");}?> value="4">Caribeño</option>
						<option <?php if($selectedVariety == '5'){echo("selected");}?> value="5">Mexicano-Centroamericano</option>
						<option <?php if($selectedVariety == '6'){echo("selected");}?> value="6">Andino</option>
						<option <?php if($selectedVariety == '7'){echo("selected");}?> value="7">Austral</option>
						<option <?php if($selectedVariety == '8'){echo("selected");}?> value="8">Chileno</option>
						<option <?php if($selectedVariety == '9'){echo("selected");}?> value="9">Español de Guinea Ecuatorial</option>
						<option <?php if($selectedVariety == '10'){echo("selected");}?> value="10">Judeoespañol</option>
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
						<option <?php if($selectedFornat == ''){echo("selected");}?> value="" selected="selected">Seleccione una fuente</option>
						<option <?php if($selectedFornat == 'Youtube'){echo("selected");}?> value="Youtube">Youtube</option>
						<option <?php if($selectedFornat == 'Kahoot'){echo("selected");}?> value="Kahoot">Kahoot</option>
					</select>
				</div>
				<div class="col-12 col-sm-6">
					<label>Enlace del Material</label>
					<input class="form-control" id="link" name="link" type="text" value="<?php echo $recurso['link']; ?>" />
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
				<h1 class="h5 mb-0 text-gray-800">Archivo secundario relacionado con el recurso </h1>
			</div>
			<div class="row">	
				<div class="col-12 col-sm-6">
					<input class="form-control" id="file2" name="file2" type="file">
				</div>
			</div>
		</div>

		<div class="row">

			<?php for ($i = 1; $i <= 2; $i++) { ?>
				<?php 
					if($i == 1) { $vector="pro[]"; $nombre = "Pronunciación"; }
					if($i == 2) { $vector="gra[]"; $nombre = "Gramática"; }
					//if($i == 3) { $vector="voc[]"; $nombre = "Vocabulario"; }
				?>
				<div class="col-lg-6">
					<div class="card shadow mb-4">
						<!-- Card Header - Accordion -->
						<a href="#<?php echo $nombre ?>" class="d-block card-header py-3" data-toggle="collapse"
							role="button" aria-expanded="true" aria-controls="<?php echo $nombre ?>">
							<h6 class="m-0 font-weight-bold"><?php echo $nombre ?></h6>
						</a>
						<!-- Card Content - Collapse -->
						<div class="collapse" id="<?php echo $nombre ?>">
							<div class="card-body">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<tbody>
											<?php $igual = false; ?>
											<?php foreach($todosLosValores as $valor) { ?>
												<tr>
													<?php if($valor['charID'] == $i) { ?>	
														<td><?php echo $valor['at1'] ?></td>
														<?php foreach($valoresDeRecurso as $seleccionado) { ?>
															<?php if($seleccionado['charID'] == $i && $valor['valID']==$seleccionado['valID'] ) { ?>
																<?php $igual = true; ?>
																<td><input type="checkbox" name="<?php echo $vector ?>" value="<?php echo $valor['valID'] ?>" checked/></td>
															<?php }?>
														<?php }?>
														<?php if($igual == false ) { ?>
															<td><input type="checkbox" name="<?php echo $vector ?>" value="<?php echo $valor['valID'] ?>"/></td>
														<?php }?>
													<?php }?>
												</tr>
												<?php $igual = false; ?>
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
        
        <button type="submit" class="btn btn-primary">Volver a mandar para verificación</button>
        
		<script>

			function desocultarForm() {
				var form = document.getElementById("formEntero");
				if (form.style.display === "none") {
					form.style.display = "block";
				} else {
					form.style.display = "none";
				}
			}

			cargarSeleccionados();
			
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

			function cargarSeleccionados(){
				var id = document.getElementById("idRec").value;
				$.ajax({
					url: "<?php echo base_url(); ?>/recursos/cargarSeleccionados",
					method: "POST",
					data: {id: id}
				}).done(function(res){
					var datos = JSON.parse(res);
					datos.forEach(function(dato, index) {
						seleccionados.push(dato.valID);
					});
					buscarVocabulario();
				})
			}

			$primero = true;
			$verBoton = false;
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

					if($primero){
						getChecked();
						$primero = false;
					}
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
    
	</div>

</div>

