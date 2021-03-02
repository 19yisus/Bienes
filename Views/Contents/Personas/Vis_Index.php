<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Registro','Personas/Vis_Registro');?>
    <!-- Main content -->
    <div class="content">
      <?php $this->Catalogo(); ?>
    </div>
  <!-- /.content-wrapper -->
</div>
<?php $this->Footer('Personas'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>
<script src="<?php echo constant('URL');?>Views/Assets/plugins/inputmask/inputmask.js"></script>
<script src="<?php echo constant('URL');?>Views/Assets/plugins/inputmask/jquery.inputmask.js"></script>

<script>
  Paginador('PersonasController',1);
</script>
</body>
</html>