<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Recursos Publicados</h1>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="navbar-search col-lg-6 mb-4"> 

                        <form id="seleccionables">

                            <select class="form-control mb-4" id="variedad" name="variedad">
                                <option value="" disabled selected>Elige Variedad de Español</option>
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

                            <select class="form-control mb-4" id="nivel" name="nivel">
                                <option value="" disabled selected>Elige Nivel de Español</option>
                                <option value="1">A1</option>
                                <option value="2">A2</option>
                                <option value="3">B1</option>
                                <option value="4">B2</option>
                                <option value="5">C1</option>
                                <option value="6">C2</option>
                            </select>

                            
                        </form>

                        <div class="input-group navbar-search mr-4 mb-4">
                            <select class="form-control bg-light col-lg-3" style="appearance:none" id="busqueda1" name="busqueda1">
                                <option value="1">Palabras Clave</option>
                            </select>
                            <input class="form-control" id="texto1" name="texto1" type="text" autofocus require />
                        </div>

                    </div>
                    <div  class="col-lg-6 mb-4">
                        <form id="radios" class="row">
                            <div class="col-lg-6 mb-4"> 
                                <p>Elige el tipo de recurso</p>
                                <label><input type="radio" id="archivo" name="archivo" value="video" /> Video</label> <br />
                                <label><input type="radio" id="archivo" name="archivo" value="application" /> Archivo</label> <br />
                            </div>
                            <div class="col-lg-6 mb-4" id="divVideo" style="display: none"> 
                                <p>Elige el tipo de video</p>
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="youtube" /> Youtube</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="noYoutube" /> Video Propio</label> <br />
                            </div>
                            <div class="col-lg-6 mb-4" id="divArchivo" style="display: none"> 
                                <p>Elige el tipo de archivo</p>
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="pdf" /> PDF</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="doc" /> DOC</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="word" /> WORD</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="kahoot" /> Enlace a Kahoot</label> <br />
                            </div>
                        </form>
                        <button type="button" onclick="resetearForms()" class="btn btn-primary">Resetear Busqueda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php for ($i = 1; $i <= 2; $i++) { ?>
            <?php 
                if($i == 1) { $vector="pro[]"; $nombre = "Pronunciacion"; }
                if($i == 2) { $vector="gra[]"; $nombre = "Gramatica"; }
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
                                        <?php foreach($valores as $valor) { ?>
                                            <tr>
                                                <?php if($valor['charID'] == $i) { ?>
                                                    <td><?php echo $valor['at1'] ?></td>
                                                    <td><input type="checkbox" id="caca" name="<?php echo $vector ?>" value="<?php echo $valor['valID'] ?>"/></td>
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
                        <table class="table table-bordered" id="tablaVocabulario" width="100%" cellspacing="0">
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

			<table class="table table-bordered" id="vocabularioFinal" width="100%" cellspacing="0" style="display: none">
				<tbody></tbody>
			</table>
        </div>

    </div>

    <div id="mensaje" style="display: none">
        <h2>No hay resultados para la busqueda</h2>
    </div>
    <div id="grid" class="row">
    </div>

    <script>

        //Cargamos el vocabulario
        buscarVocabulario();
        //Vector del vocabulario seleccionado
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
            buscarRecursos();
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
            })
        }

        ////////////////////////////////////////////////////////////////
        // funcion que se ejecuta al cargar la pagina
        buscarRecursos();

        // funaciones para cambiar numeros por texto
        function cambiarVariedad(numero){
            valor = ['Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol'];
            return valor[numero -1];
        }
        function cambiarNivelEsp(numero){
            valor = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
            return valor[numero -1];
        }

        var seleccionados = [];
        // funcion para ordenar array
        function ordenarArray(a, b) {
            return a - b;
        }

        // se ejecuta al ecribir en texto1
        $(document).on('keyup', '#texto1', function(){
            buscarRecursos();
        });
        // se ejecuta al cambiar radio de archivo
        $(document).on('change', '#archivo', function(){
            var formatoSeleccionado = $("input[name='archivo']:checked").val();
            var divVideo = document.getElementById("divVideo");
            var divArchivo = document.getElementById("divArchivo");
            if ( formatoSeleccionado == "video" ){
                divVideo.style.display = "block";
                divArchivo.style.display = "none";
            } else if ( formatoSeleccionado == "application" ) {
                divVideo.style.display = "none";
                divArchivo.style.display = "block";
            }
            buscarRecursos();
        });

        // se ejecuta al cambiar radio de archivo secundario
        $(document).on('change', '#archivoSecundario', function(){
            buscarRecursos();
        });

        // se ejecuta al cambiar el select de nivel
        $(document).on('change', '#nivel', function(){
            buscarRecursos();
        });
        // se ejecuta al cambiar el select de variedad
        $(document).on('change', '#variedad', function(){
            buscarRecursos();
        });
        
        // funcion que se ejecuta al pulsar el boton de resetear el formulario
        function resetearForms(){
            document.getElementById('seleccionables').reset();
            document.getElementById('radios').reset();
            divVideo.style.display = "none";
            divArchivo.style.display = "none";
            buscarRecursos();
        }

        // funcion que carga los recursos con todos los campos de busqueda
        function buscarRecursos(){

            var busqueda1 = document.getElementById("busqueda1").value;
            var texto1 = document.getElementById("texto1").value;

            var nivel = document.getElementById("nivel").value;
            var variedad = document.getElementById("variedad").value;

            var formato = $("input[name='archivo']:checked").val();
            var formatoSecundario = $("input[name='archivoSecundario']:checked").val();

            //var vocabulario = document.getElementsByName("vocFinal[]");

            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/buscarRecursos",
                method: "POST",
                data: {busqueda1: busqueda1, 
                        texto1: texto1, 
                        nivel: nivel,
                        variedad: variedad,
                        formato: formato,
                        formatoSecundario: formatoSecundario 
                        //vocabulario: JSON.stringify(vocabulario)
                        }
            }).done(function(res){
                var datos = JSON.parse(res);
                
                $("#grid").empty(); 

                if(datos.length == 0 ) document.getElementById("mensaje").style.display = "block";
                else document.getElementById("mensaje").style.display = "none";

                datos.forEach(function(dato, index) {

                    // se crea todo el recurso visualmente
                    var grid = document.getElementById("grid");

                    var contenedor = document.createElement("div");
                    contenedor.className = "col-xl-4 mb-4";

                    var card = document.createElement("div");
                    card.className = "card shadow mb-4";

                        var a = document.createElement("a");
                        a.href = "<?php echo base_url(); ?>/recursos/recurso/"+dato.resourceID+"";
                        a.style.cssText = "color:grey; text-decoration:none;";

                            var cardHeader = document.createElement("div");
                            cardHeader.className = "card-header py-3";

                                var dropDown = document.createElement("div");
                                dropDown.className = "dropdown no-arrow";

                                    var titulo = document.createElement("h6");
                                    titulo.className = "m-0 font-weight-bold";
                                    titulo.textContent = dato.title;
                                    dropDown.appendChild(titulo);

                                    var id = document.createElement("p");
                                    id.className = "m-0";
                                    id.textContent = dato.resourceID;
                                    dropDown.appendChild(id);

                                    // var autor = document.createElement("p");
                                    // autor.className = "m-0";
                                    // autor.textContent = dato.autor;
                                    // dropDown.appendChild(autor);
                            
                                cardHeader.appendChild(dropDown);
                        
                            a.appendChild(cardHeader);

                        card.appendChild(a);

                        var body = document.createElement("div");
                        body.className = "card-body";

                            var descripcion = document.createElement("p");
                            descripcion.textContent = dato.description;
                            body.appendChild(descripcion);

                            var level = document.createElement("p");
                            level.textContent = 'Nivel de Español: '+cambiarNivelEsp(dato.spanishlvl);
                            body.appendChild(level);

                            var variety = document.createElement("p");
                            variety.textContent = 'Variedad del Español: '+cambiarVariedad(dato.variety);
                            body.appendChild(variety);

                        card.appendChild(body);

                        contenedor.appendChild(card);

                    grid.appendChild(contenedor);

                });

            })
        }

		</script>

</div>

<!-- /.container-fluid -->