<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Recurso</h1>
    </div>
	<!-- Page Heading -->

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

    <div class="card shadow mb-4">  
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold"><?php echo $recurso['title'] ?></h6>
            <p class="m-0">Autor: <?php echo $recurso['autor'] ?></p>
            <p class="m-0">Supervisor: <?php echo $recurso['editor'] ?></p>
        </div>
        <div class="card-body">
            <p><?php echo $recurso['description'] ?></p>
            <p>Fuente: <?php echo $recurso['font'] ?></p>
            <p>Archivo:</p>
            <p>Link:</p>
            <p>Variedad: <?php echo cambioVariedad($recurso['variety']) ?></p>
            <p>Nivel de Español: <?php echo cambioNivelEsp($recurso['spanishlvl']) ?></p>
        </div>
    </div>

    <?php foreach($valores as $valor) { ?>
        <div class="card shadow mb-4"> 
            <div class="card-body">
                <p><?php echo $caracteristicas[$valor['charID'] - 1]['title1'] ?></p>
                <p><?php echo $valor['at1'] ?></p>
                <p><?php echo $caracteristicas[$valor['charID'] - 1]['title2'] ?></p>
                <p><?php echo $valor['at2'] ?></p>
                <p><?php echo $caracteristicas[$valor['charID'] - 1]['title3'] ?></p>
                <p><?php echo $valor['at3'] ?></p>
            </div>
        </div>
    <?php } ?>

	</div>

    </div>
    </div>

</div>

