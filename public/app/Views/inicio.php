<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pagina Principal</h1>
    </div>

    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="navbar-search col-lg-6 mb-4"> 

                        <div class="input-group navbar-search mr-4 mb-4">
                            <select class="form-control bg-light col-lg-3" id="busqueda1" name="busqueda1">
                                <option value="1">Titulo</option>
                                <option value="2">Descripción</option>
                            </select>
                            <input class="form-control" id="texto1" name="texto1" type="text" autofocus require />
                        </div>

                        <div class="input-group mr-4 navbar-search mb-4">
                            <select class="form-control bg-light col-lg-4" style="appearance:none" disabled>
                                <option>Nombre del Autor</option>
                            </select>
                            <input class="form-control" id="autor" name="autor" type="text" autofocus require />
                        </div>

                        <form id="seleccionables">
                            <select class="form-control mb-4" id="nivel" name="nivel">
                                <option value="" disabled selected>Elige el nivel de español del Recurso</option>
                                <option value="1">A1</option>
                                <option value="2">A2</option>
                                <option value="3">B1</option>
                                <option value="4">B2</option>
                                <option value="5">C1</option>
                                <option value="6">C2</option>
                                <option value="7">Nativo</option>
                            </select>

                            <select class="form-control" id="variedad" name="variedad">
                                <option value="" disabled selected>Elige la variedad del español del Recurso</option>
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
                        </form>

                    </div>
                    <div  class="col-lg-6 mb-4">
                        <form id="radios" class="row">
                            <div class="col-lg-6 mb-4"> 
                                <p>Elige el tipo de archivo</p>
                                <label><input type="radio" id="archivo" name="archivo" value="image" /> Imagen</label> <br />
                                <label><input type="radio" id="archivo" name="archivo" value="video" /> Video</label> <br />
                                <label><input type="radio" id="archivo" name="archivo" value="application" /> Archivo</label> <br />
                            </div>
                            <div class="col-lg-6 mb-4" id="divImagen" style="display: none"> 
                                <p>Elige el tipo Imagen</p>
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="jpg" /> JPG</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="png" /> PNG</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="jpeg" /> JPEG</label> <br />
                            </div>
                            <div class="col-lg-6 mb-4" id="divVideo" style="display: none"> 
                                <p>Elige el tipo de video</p>
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="mp4" /> MP4</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="mov" /> MOV</label> <br />
                            </div>
                            <div class="col-lg-6 mb-4" id="divArchivo" style="display: none"> 
                                <p>Elige el tipo de archivo</p>
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="pdf" /> PDF</label> <br />
                                <label><input type="radio" id="archivoSecundario" name="archivoSecundario" value="doc" /> DOC</label> <br />
                            </div>
                        </form>
                        <button type="button" onclick="resetearForms()" class="btn btn-primary">Resetear Busqueda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        function cambioNivelEsp($numero){
			$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
			return $valor[$numero -1];
		}
    ?>

    <div id="grid" class="row">
    </div>

    <script>

        // funcion que se ejecuta al cargar la pagina
        buscarRecursos();

        // funaciones para cambiar numeros por texto
        function cambiarVariedad(numero){
            valor = ['Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol'];
            return valor[numero -1];
        }
        function cambiarNivelEsp(numero){
            valor = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo'];
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
        // se ejecuta al ecribir en autor
        $(document).on('keyup', '#autor', function(){
            buscarRecursos();
        });

        // se ejecuta al cambiar radio de archivo
        $(document).on('change', '#archivo', function(){
            var formatoSeleccionado = $("input[name='archivo']:checked").val();
            var divImagen = document.getElementById("divImagen");
            var divVideo = document.getElementById("divVideo");
            var divArchivo = document.getElementById("divArchivo");
            if( formatoSeleccionado == "image" ){
                divImagen.style.display = "block";
                divVideo.style.display = "none";
                divArchivo.style.display = "none";
            } else if ( formatoSeleccionado == "video" ){
                divImagen.style.display = "none";
                divVideo.style.display = "block";
                divArchivo.style.display = "none";
            } else if ( formatoSeleccionado == "application" ) {
                divImagen.style.display = "none";
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
            divImagen.style.display = "none";
            divVideo.style.display = "none";
            divArchivo.style.display = "none";
            buscarRecursos();
        }

        // funcion que carga los recursos con todos los campos de busqueda
        function buscarRecursos(){

            var busqueda1 = document.getElementById("busqueda1").value;
            var texto1 = document.getElementById("texto1").value;
            var autor = document.getElementById("autor").value;

            var nivel = document.getElementById("nivel").value;
            var variedad = document.getElementById("variedad").value;

            var formato = $("input[name='archivo']:checked").val();
            var formatoSecundario = $("input[name='archivoSecundario']:checked").val();

            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/buscarRecursos",
                method: "POST",
                data: {busqueda1: busqueda1, 
                        texto1: texto1, 
                        autor: autor, 
                        nivel: nivel,
                        variedad: variedad,
                        formato: formato,
                        formatoSecundario: formatoSecundario 
                        }
            }).done(function(res){
                var datos = JSON.parse(res);
                
                $("#grid").empty(); 

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

                                    var autor = document.createElement("p");
                                    autor.className = "m-0";
                                    autor.textContent = dato.autor;
                                    dropDown.appendChild(autor);
                            
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
