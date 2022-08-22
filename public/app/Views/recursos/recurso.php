<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Recurso</h1>

        <?php if ( session('role') > 1 || session('email') == $resultado['author'] ) { ?>
            <a href="<?php echo base_url(); ?>/recursos/crearCSV/<?php echo $resultado['resourceID']; ?>" class="btn btn-dark">
                <i class="fas fa-arrow-down"></i>
            </a> 
            <a href="<?php echo base_url(); ?>/recursos/editarRecurso/<?php echo $resultado['resourceID']; ?>" class="btn btn-dark">
                <i class="fas fa-pencil-alt"></i>
            </a>     
        <?php } ?> 

    </div>
	<!-- Page Heading -->

    <?php
        $selected = $resultado['variety'];
        function cambioNivelEsp($numero){
            $valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
            return $valor[$numero -1];
        }
        function cambioVariedad($numero){
            $valor = array ( 'Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol');
            return $valor[$numero -1];
        }
    ?> 

    <input type="hidden" type="text" id="idRec"  name="idRec" value="<?php echo $resultado['resourceID']; ?>"/>

    <div class="card shadow mb-4">  
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><?php echo $resultado['title'] ?></h6>
            <p class="m-0">Autor: <?php echo $resultado['nombre']." ".$resultado['apellidos'] ?></p>
        </div>
        <div class="card-body">
            <p><?php echo $resultado['description'] ?></p>
            <p>Fuente del material audiovisual: <?php echo $resultado['source'] ?></p> 
            <p>Link: <a target="_blank" href=<?php echo $resultado['link'] ?>><?php echo $resultado['link'] ?></a></p>
            <p>Variedad: <?php echo cambioVariedad($resultado['variety']) ?></p>
            <p>Nivel de Español: <?php echo cambioNivelEsp($resultado['spanishlvlRes']) ?></p>
        </div>
    </div>

    <?php if ( $resultado['file'] != NULL ) { ?>
        <div id="botonArchivo" class="input-group col-lg-4 mb-4" style="display: block">
            <button type="button" onclick="verArchivo()" class="btn btn-primary">Ver archivo asociado al resultado</button>
        </div>

        <?php if ( $resultado['format'] == "image" ) { ?>
            <div class="mb-4" id="archivo" style="display: none">
                <img height="300" src="<?php echo base_url(); ?>/uploads/imagenes/<?php echo $resultado['file'] ?>" alt="Imagen del Recurso">
            </div>
        <?php } ?> 
        <?php if ( $resultado['format'] == "video" ) { ?>
            <video class="mb-4" id="archivo" controls style="display: none">
                <source src="<?php echo base_url(); ?>/uploads/videos/<?php echo $resultado['file'] ?>" type="video/mp4" width="100%">
            </video>
        <?php } ?> 
        <?php if ( $resultado['format'] == "application" ) { ?>
            <?php if ( $resultado['format2'] == "pdf" ) { ?>
                <div class="mb-4" id="archivo" style="display: none">
                    <embed src="<?php echo base_url(); ?>/uploads/pdfs/<?php echo $resultado['file'] ?>" type="application/pdf" width="100%" height="600" />
                </div>
            <?php } ?> 
            <?php if ( $resultado['format2'] == "docx" ) { ?>
                <div class="mb-4" id="archivo" style="display: none">
                    <h4>El archivo que esta relacionado con este recurso es un .docx</h4>
                    <h5>No es posible verlo dentro de esta web y tendra que descargarlo si quiere hacerlo.</h5>
                    
                </div>
            <?php } ?> 
        <?php } ?> 
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
            document.getElementById("botonArchivo").style.display = "none";
        }

    </script>

</div>


