<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Nuevo Recurso</h1>
    </div>
	<!-- Page Heading -->

	<form action="" method="post">
		<label for="campo">Buscar: </label>
		<input type="text" name="campo" id="campo">
	</form>
	<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thread>
            <tr>
                <th>AT1</th>
                <th>AT2</th>
                <th>AT3</th>
            </tr>
        </thread>
        <tbody>
        </tbody>
    </table>

    <script>

        $.ajax({
            url: "<?php echo base_url(); ?>/recursos/buscarVocabulario",
            method: "POST"
        }).done(function(res){
            var datos = JSON.parse(res);
            datos.forEach(function(dato, index) {
                document.getElementById("dataTable").insertRow(-1).innerHTML = '<td id="'+index+'1"></td><td id="'+index+'2"></td><td id="'+index+'3"></td>';
                $('#'+index+'1').html(dato.at1);
                $('#'+index+'2').html(dato.at2);
                $('#'+index+'3').html(dato.at3);
            });
            

        })

    </script>

	</div>
    </div>

</div>
