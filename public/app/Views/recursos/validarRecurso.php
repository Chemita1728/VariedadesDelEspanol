<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Validar Recurso</h1>
    </div>
	<!-- Page Heading -->

    <?php
        function cambioNivelEsp($numero){
			$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
			return $valor[$numero -1];
		}
        function cambioVariedad($numero){
            $valor = array ( 'Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol');
            return $valor[$numero -1];
        }
    ?>

    <script type="text/javascript">
        function desocultar() {
            var mensaje = document.getElementById("mensaje");
            if (mensaje.style.display === "none") {
                mensaje.style.display = "block";
            } else {
                mensaje.style.display = "none";
            }
        }
    </script>

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>

    <input type="hidden" type="text" id="idRec"  name="idRec" value="<?php echo $resultado['resourceID']; ?>"/>

	<div class="contaired-fluid mb-4">
		<div class="form-group">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><?php echo $resultado['title'] ?></h6>
                </div>
                <div class="card-body">
                    <p>Fuente del material audiovisual: <?php echo $resultado['source']; ?></p>
                    <p>Descripción: <?php echo $resultado['description']; ?></p>
                    <p>Nivel de Español: <?php echo cambioNivelEsp($resultado['spanishlvlRes']); ?></p>
                    <p>Variedad del Español: <?php echo cambioVariedad($resultado['variety']); ?></p>
                    <p>Link: <?php echo $resultado['link']; ?></p>
                    <p>Autor: <?php echo $resultado['nombre']." ".$resultado['apellidos']; ?></p>
                    <p>Editor: <?php echo $resultado['respMail']; ?></p>
                </div>
			</div>
		</div>

        <?php if ( $resultado['file'] != NULL ) { ?>
            <h1 class="h5 mb-4 text-gray-800">Archivo Relacionado</h1>
            <div id="botonArchivo" class="input-group col-lg-4 mb-4" style="display: block">
                <button type="button" onclick="verArchivo()" class="btn btn-primary">Ver archivo asociado al resultado</button>
            </div>

            <?php if ( $resultado['fileFormat'] == "pdf" ) { ?>
                <div class="mb-4" id="archivo" style="display: none">
                    <embed src="<?php echo base_url(); ?>/uploads/files/<?php echo $resultado['file'] ?>" type="application/pdf" width="100%" height="600" />
                </div>
            <?php } ?> 
            <?php if ( $resultado['fileFormat'] == "docx" ) { ?>
                <div class="mb-4" id="archivo" style="display: none">
                    <h4>El archivo que esta relacionado con este recurso es un .docx</h4>
                    <h5>No es posible verlo dentro de esta web y tendra que descargarlo si quiere hacerlo.</h5>
                </div>
            <?php } ?> 
            <div class="mb-4" id="botonDescarga" style="display: none">    
                <a href="<?php echo base_url(); ?>/recursos/descargarArchivo/<?php echo $resultado['resourceID']; ?>" class="btn btn-primary"> Descargar Archivo Asociado</a> 
            </div>
        <?php } ?> 

        <?php if ( $resultado['file2'] != NULL ) { ?>
            <h1 class="h5 mb-4 text-gray-800">Archivo Secundario</h1>
            <div id="botonArchivoSecundario" class="input-group col-lg-4 mb-4" style="display: block">
                <button type="button" onclick="verArchivoSecundario()" class="btn btn-primary">Ver archivo secundario</button>
            </div>

            <?php if ( $resultado['file2Format'] == "pdf" ) { ?>
                <div class="mb-4" id="archivoSecundario" style="display: none">
                    <embed src="<?php echo base_url(); ?>/uploads/secondaryFiles/<?php echo $resultado['file2'] ?>" type="application/pdf" width="100%" height="600" />
                </div>
            <?php } ?> 
            <?php if ( $resultado['file2Format'] == "docx" ) { ?>
                <div class="mb-4" id="archivoSecundario" style="display: none">
                    <h4>El archivo secundario que esta relacionado con este recurso es un .docx</h4>
                    <h5>No es posible verlo dentro de esta web y tendra que descargarlo si quiere hacerlo.</h5>
                </div>
            <?php } ?> 
            <div class="mb-4" id="botonDescargaSecundario" style="display: none">    
                <a href="<?php echo base_url(); ?>/recursos/descargarArchivo/<?php echo $resultado['resourceID']; ?>" class="btn btn-primary"> Descargar Archivo Secundario</a> 
            </div>
        <?php } ?> 

        <select class="form-control bg-light mb-4" id="parametro" name="parametro" onchange="cargarCaracteristicas()">
            <option disabled selected>Selecciona una opción</option>    
            <option value=1>Pronunciación</option>
            <option value=2>Gramatica</option>
            <option value=3>Vocabulario</option>
        </select>
        <div class="table-responsive" id="tablaCaracteristicas" style="display: none">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thread id="tablaNombres">
                    <tr>
                        <th id="nombreCar1"></th>
                        <th id="nombreCar2"></th>
                        <th id="nombreCar3"></th>
                    </tr>
                </thread>
                <tbody id="tablaValores"></tbody>
            </table>
        </div>

        <button onclick="desocultar()" class="btn btn-secondary"> Hacer Comentario </button>
        <a href="<?php echo base_url(); ?>/recursos/publicar/<?php echo $resultado['resourceID']; ?>" class="btn btn-secondary">Validar/Publicar Recurso</a>
	
	</div>
    
    <div class="contaired-fluid mb-4 col-sm-8" style="display: none" id="mensaje">
        <div class="form-group">

            <form method="POST" action="<?php echo base_url(); ?>/recursos/enviarComentario/<?php echo $resultado['resourceID']; ?>" autocomplere="off">
            <div class="row"> <input type="hidden" id="state"  name="state" value="<?php echo $resultado['state']; ?>"/></div>

            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Comentario del Editor</h6>
                </div>
                <div class="card-body">
                    <input class="form-control" id="comentario" name="comentario" type="text" autofocus require />
                </div>  
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Mandar Comentario</button>
    </div>

    <script>

        function cargarCaracteristicas(){
            var parametro = document.getElementById("parametro").value;
            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/cargarCaracteristicas",
                method: "POST",
                data: {parametro: parametro}
            }).done(function(res){
                
                document.getElementById("tablaCaracteristicas").style.display = "block";

                var caracteristica = JSON.parse(res);
                $('#nombreCar1').html(caracteristica.title1);
                $('#nombreCar2').html(caracteristica.title2);
                $('#nombreCar3').html(caracteristica.title3);
                cargarValores(parametro);
            });
        }

        function cargarValores(parametro){
            var id = document.getElementById("idRec").value;
            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/cargarValores",
                method: "POST",
                data: {id: id, parametro: parametro}
            }).done(function(res){
                var valores = JSON.parse(res);
                $("#tablaValores tr").remove(); 
				valores.forEach(function(valor, index) {
                    document.getElementById("tablaValores").insertRow(-1).innerHTML = '<td id="val'+index+'1"></td><td id="val'+index+'2"></td><td id="val'+index+'3"></td>';
                    $('#val'+index+'1').html(valor.at1);
                    $('#val'+index+'2').html(valor.at2);
                    $('#val'+index+'3').html(valor.at3);
                });
            })
        }

        function verArchivo() {
            document.getElementById("archivo").style.display = "block";
            document.getElementById("botonDescarga").style.display = "block";
            document.getElementById("botonArchivo").style.display = "none";
        }
        function verArchivoSecundario() {
            document.getElementById("archivoSecundario").style.display = "block";
            document.getElementById("botonDescargaSecundario").style.display = "block";
            document.getElementById("botonArchivoSecundario").style.display = "none";
        }

    </script>

</div>

