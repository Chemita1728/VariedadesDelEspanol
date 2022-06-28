<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Revisar Recurso</h1>
    </div>
	<!-- Page Heading -->

    <script type="text/javascript">
        function desocultar() {
            var form = document.getElementById("formEntero");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>

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

        <button onclick="desocultar()" class="btn btn-warning"> Editar Recurso </button>
	
	</div>

    <form method="POST" action="<?php echo base_url(); ?>/recursos/mandarRevision/<?php echo $recurso['resourceID']; ?>" autocomplere="off">
	
	<div class="contaired-fluid" style="display: none" id="formEntero">
		<div class="form-group">

			<?php
				$selected = $recurso['variety'];
				function cambioNivelEsp($numero){
					$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
					return $valor[$numero -1];
				}
				function cambioVariedad($numero){
					$valor = array ( 'Castellano', 'Andaluz', 'Canario', 'Caribeño', 'Mexicano-Centroamericano', 'Andino', 'Austral', 'Chileno', 'Español de Guinea Ecuatorial', 'Judeoespañol');
					return $valor[$numero -1];
				}
			?> 

			<div class="row">
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
					<label>Fuente</label>
					<input class="form-control" id="font" name="font" type="text" value="<?php echo $recurso['font']; ?>"/>
				</div>
				<div class="col-12 col-sm-6">
					<label>Variedad</label>
                    
					<select class="form-control" id="variety" name="variety">
						<option <?php if($selected == '1'){echo("selected");}?> value="1">Castellano</option>
						<option <?php if($selected == '2'){echo("selected");}?> value="2">Andaluz</option>
						<option <?php if($selected == '3'){echo("selected");}?> value="3">Canario</option>
						<option <?php if($selected == '4'){echo("selected");}?> value="4">Caribeño</option>
						<option <?php if($selected == '5'){echo("selected");}?> value="5">Mexicano-Centroamericano</option>
						<option <?php if($selected == '6'){echo("selected");}?> value="6">Andino</option>
						<option <?php if($selected == '7'){echo("selected");}?> value="7">Austral</option>
						<option <?php if($selected == '8'){echo("selected");}?> value="8">Chileno</option>
						<option <?php if($selected == '9'){echo("selected");}?> value="9">Español de Guinea Ecuatorial</option>
						<option <?php if($selected == '10'){echo("selected");}?> value="10">Judeoespañol</option>
					</select>
				</div>
			</div>	
		</div>	

		<div class="form-group">
			<div class="d-sm-flex align-items-center justify-content-between mb-4">
				<h1 class="h5 mb-0 text-gray-800">Información Extra </h1>
			</div>
			<div class="row">	
				<div class="col-12 col-sm-6">
					<label>Fichero</label>
					<input class="form-control" id="file" name="file" type="file" value="<?php echo $recurso['file']; ?>"/>
				</div>
				<div class="col-12 col-sm-6">
					<label>Enlace Interesante</label>
					<input class="form-control" id="link" name="link" type="text" value="<?php echo $recurso['link']; ?>"/>
				</div>
			</div>
		</div>
        
        <button type="submit" class="btn btn-success">Volver a mandar para verificación</button>
        
    
	</div>

    </div>
    </div>

</div>

