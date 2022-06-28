<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Revisar Recurso</h1>
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

	<div class="contaired-fluid mb-4">
		<div class="form-group">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><?php echo $recurso['title'] ?></h6>
                </div>
                <div class="card-body">
                    <p>*ID: <?php echo $recurso['resourceID']; ?></p>
                    <p>Fuente: <?php echo $recurso['font']; ?></p>
                    <p>Descripción: <?php echo $recurso['description']; ?></p>
                    <p>Nivel de Español: <?php echo cambioNivelEsp($recurso['spanishlvl']); ?></p>
                    <p>Variedad del Español: <?php echo cambioVariedad($recurso['variety']); ?></p>
                    <p>Fichero: <?php echo $recurso['file']; ?></p>
                    <p>Link: <?php echo $recurso['link']; ?></p>
                    <p>Autor: <?php echo $recurso['autor']; ?></p>
                    <p>Editor: <?php echo $recurso['editor']; ?></p>
                </div>
			</div>
		</div>

        <button onclick="desocultar()" class="btn btn-warning"> Hacer Comentario </button>
        <a href="<?php echo base_url(); ?>/recursos/publicar/<?php echo $recurso['resourceID']; ?>" class="btn btn-warning">Validar/Publicar Recurso</a>
	
	</div>

    
    <div class="contaired-fluid mb-4 col-sm-8" style="display: none" id="mensaje">
        <div class="form-group">

            <form method="POST" action="<?php echo base_url(); ?>/recursos/enviarComentario/<?php echo $recurso['resourceID']; ?>" autocomplere="off">
            <div class="row"> <input type="hidden" id="state"  name="state" value="<?php echo $recurso['state']; ?>"/></div>

            <div class="card shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold">Comentario del Editor</h6>
                </div>
                <div class="card-body">
                    <input class="form-control" id="comentario" name="comentario" type="text" autofocus require />
                </div>  
            </div>

        </div>

        <button type="submit" class="btn btn-success">Mandar Comentario</button>
    </div>
    
	</div>
    </div>

</div>

