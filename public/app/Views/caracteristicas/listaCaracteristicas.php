<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		
        <?php if($tipo == 1) { ?>
            <h1 class="h3 mb-1 text-gray-800">Lista de Caracteristicas de Pronunciación</h1>
        <?php } ?>
        <?php if($tipo == 2) { ?>
            <h1 class="h3 mb-1 text-gray-800">Lista de Caracteristicasde Gramatica</h1>
        <?php } ?>
        <?php if($tipo == 3) { ?>
            <h1 class="h3 mb-1 text-gray-800">Lista de Vocabulario</h1>
        <?php } ?>
		
    </div>
	<!-- Page Heading -->

	<?php if( session('msg') ): ?>
		<p><?php echo session('msg'); ?><p>
	<?php endif; ?>

    <div class="row">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thread>
					<tr>
                        <?php if($tipo < 3) { ?>
                            <th>Rasgo</th>
                            <th>Ejemplo</th>
                            <th>Descripción</th>
                        <?php } ?>
                        <?php if($tipo == 3) { ?>
                            <th>Lema</th>
                            <th>Forma</th>
                            <th>Significado</th>
                        <?php } ?>
						<th></th>
					</tr>
				</thread>
				<tbody>
					<?php foreach($valores as $valor) { ?>
                        <tr>
                            <td><?php echo $valor['at1'] ?></td>
                            <td><?php echo $valor['at2'] ?></td>
                            <td><?php echo $valor['at3'] ?></td>
                            <?php if($tipo == 1) { ?>
                                <td><a onclick="deletePronunciacionPopUp(<?php echo $valor['valID']; ?>)" class="btn btn-dark"><i class="fas fa-trash"></i></a></td> 
                            <?php } ?>
                            <?php if($tipo == 2) { ?>
                                <td><a onclick="deleteGramaticaPopUp(<?php echo $valor['valID']; ?>)" class="btn btn-dark"><i class="fas fa-trash"></i></a></td> 
                            <?php } ?>
                            <?php if($tipo == 3) { ?>
                                <td><a onclick="deleteVocabularioPopUp(<?php echo $valor['valID']; ?>)" class="btn btn-dark"><i class="fas fa-trash"></i></a></td> 
                            <?php } ?>
                            </tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

    <script>

    function deletePronunciacionPopUp(valID) {
        if( confirm("¿Estás seguro de que quieres borrar esta caracteristica?")){
            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/borrarPronunciacion",
                method: "POST",
                data: {valID: valID}
            }).done(function(res){
                alert(res);
                window.location.href = "<?php echo base_url(); ?>/recursos/listaCaracteristicas/1";
            });
            
        }
    }

    function deleteGramaticaPopUp(valID) {
        if( confirm("¿Estás seguro de que quieres borrar esta caracteristica?")){
            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/borrarGramatica",
                method: "POST",
                data: {valID: valID}
            }).done(function(res){
                alert(res);
                window.location.href = "<?php echo base_url(); ?>/recursos/listaCaracteristicas/2";
            });
            
        }
    }

    function deleteVocabularioPopUp(valID) {
        if( confirm("¿Estás seguro de que quieres borrar esta caracteristica?")){
            $.ajax({
                url: "<?php echo base_url(); ?>/recursos/borrarVocabulario",
                method: "POST",
                data: {valID: valID}
            }).done(function(res){
                alert(res);
                window.location.href = "<?php echo base_url(); ?>/recursos/listaCaracteristicas/3";
            });
            
        }
    }
    </script>

</div>
