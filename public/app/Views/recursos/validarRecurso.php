<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Revisar Recurso</h1>
    </div>
	<!-- Page Heading -->

    <?php
        $oculto = true;
        function cambioNivelEsp($numero){
			$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
			return $valor[$numero -1];
		}
        function desocultar(){
            $oculto = false;
        }
    ?>

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
                    <p>Fuente: <?php echo $recurso['font']; ?></p>
                    <p>Descripción: <?php echo $recurso['description']; ?></p>
                    <p>Nivel de Español: <?php echo $recurso['spanishlvl']; ?></p>
                    <p>Variedad del Español: <?php echo $recurso['variety']; ?></p>
                    <p>Fichero: <?php echo $recurso['file']; ?></p>
                    <p>Link: <?php echo $recurso['link']; ?></p>
                    <p>Autor: <?php echo $recurso['autor']; ?></p>
                    <p>Editor: <?php echo $recurso['editor']; ?></p>
                    <p>Nivel de Español: <?php echo cambioNivelEsp($recurso['spanishlvl']) ?></p> 
                </div>
			</div>
		</div>

        <button onclick="desocultar()" class="btn btn-warning"> Hacer Comentario </button>
        <a href="<?php echo base_url(); ?>/recursos/publicar" class="btn btn-warning">Validar/Publicar Recurso</a>
	
	</div>

    <?php if($oculto == false){?>
        <div class="contaired-fluid">
            <div class="form-group">

                <form method="POST" action="<?php echo base_url(); ?>/recursos/enviarComentario" autocomplere="off">
                <div class="row"> <input type="hidden" id="id"  name="id" value="<?php echo $recurso['resourceID']; ?>"/></div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold">Comentario del Editor</h6>
                    </div>
                    <div class="card-body">
                        <input class="form-control" id="apellidos" name="apellidos" type="text" autofocus require />
                    </div>  
                </div>

            </div>

            <a href="<?php echo base_url(); ?>/recursos/publicar" class="btn btn-warning">Mandar Comentario</a>
        </div>
    <?php }?>
	</div>
    </div>

</div>

