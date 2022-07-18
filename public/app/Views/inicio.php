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
                        <div class="input-group mr-4 navbar-search">
                            <select class="form-control bg-light col-lg-3" id="busqueda1" name="busqueda1">
                                <option value="1">Titulo</option>
                                <option value="2">Descripción</option>
                            </select>
                            <input class="form-control" id="texto1" name="texto1" type="text" autofocus require />
                        </div>
                    </div>
                    <div class="navbar-search col-lg-6 mb-4"> 
                        <div class="input-group mr-4 navbar-search">
                            <select class="form-control bg-light col-lg-4" style="appearance:none" disabled>
                                <option>Nombre del Autor</option>
                            </select>
                            <input class="form-control" id="autor" name="autor" type="text" autofocus require />
                        </div>
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

			buscarRecursos();

            function cambiarNivelEsp(numero){
                valor = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo'];
                return valor[numero -1];
            }

			var seleccionados = [];
			function ordenarArray(a, b) {
				return a - b;
			}
            
            $(document).on('keyup', '#texto1', function(){
				buscarRecursos();
			});
            $(document).on('keyup', '#autor', function(){
				buscarRecursos();
			});

			function buscarRecursos(){
                var busqueda1 = document.getElementById("busqueda1").value;
                var texto1 = document.getElementById("texto1").value;
                var autor = document.getElementById("autor").value;
				$.ajax({
					url: "<?php echo base_url(); ?>/recursos/buscarRecursos",
					method: "POST",
					data: {busqueda1: busqueda1, texto1: texto1, autor: autor}
				}).done(function(res){
					var datos = JSON.parse(res);

                    $("#grid").empty(); 

                    datos.forEach(function(dato, index) {

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
                            
                            card.appendChild(body);

                            contenedor.appendChild(card);
                            
                        grid.appendChild(contenedor);

                    });
                    
                    /*
					datos.forEach(function(dato, index) {



                        var newContent = document.createTextNode("Hola!¿Qué tal?");
                        newDiv.appendChild(newContent);

                        g = document.createElement('div');
                        g.setAttribute("id", "Div1");
                        createA.setAttribute('href', "http://google.com");
                        
						
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
                    */
				})
			}

		</script>

</div>

<!-- /.container-fluid -->
