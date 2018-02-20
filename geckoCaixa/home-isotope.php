<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <div class="container-fluid innpage-<?php echo $filenameID; ?>">
      <div class="row">
        <?php include("inc/navbar-cajas.php"); // primera sección de contenido, barra de navegación ?>
      </div>
      <div class="row">
        <?php include("inc/sidebar-cajas.php"); // segunda sección de contenido, el menú lateral ?>
        <div class="inner-content col-xs-12 col-sm-10">
          <?php include("inc/group-machines.php");?>
          <?php include("inc/bottom-machine.php"); // el contenido de esta vista de panel de escritorio del usaurio ?>
        </div>
      </div>
    </div>
    <?php include("inc/modals/modal-cajas-opciones-caja-historico.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-orden.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-actualizar.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-entradasalida.php");?>
    <?php include("inc/modals/modals-cajas-maquina-estados.php");?>
    <?php include("inc/modals/modal-cajas-creditar-maquina.php");?>
    <?php include("inc/modals/modal-cajas-lista-2.php");?>
  </body>
</html>