<h2>Hola <?= $nombre ?>, el experto <?= $respNombre ?> <?= $respApellidos ?> ha solicitado su registro en la aplicación Variantes del Español<h4>
<h3>Datos que han sido introducidos: <h3>
    <p>Nombre: <?= $nombre ?><p>
    <p>Apellidos: <?= $apellidos ?><p>
    <p>Correo: <?= $email ?><p>

<a href="<?php echo base_url(); ?>/usuarios/registroParaUsuario?tempId=<?= $tempId ?>">Registrarse</a>

