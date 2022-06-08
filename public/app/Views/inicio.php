<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pagina Principal</h1>
    </div>

    <?php
        function cambioNivelEsp($numero){
			$valor = array ( 'A1', 'A2', 'B1', 'B2', 'C1', 'C2', 'Nativo' );
			return $valor[$numero -1];
		}
    ?>

    <!-- Content Row -->
    <div class="row">

        <?php foreach($recursos as $recurso) { ?>
            <div class="col-xl-4 mb-4">
                <!-- Approach -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold"><?php echo $recurso['title'] ?></h6>
                        <p class="m-0">Autor: <?php echo $recurso['autor'] ?></p>
                    </div>
                    <div class="card-body">
                        <p><?php echo $recurso['description'] ?></p>
                        <p>Nivel de Español: <?php echo cambioNivelEsp($recurso['spanishlvl']) ?></p>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

</div>

<!-- /.container-fluid -->
