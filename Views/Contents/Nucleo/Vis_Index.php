<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php $this->Wraper('Registro','Nucleo/Vis_Registro');?>
    <!-- Main content -->
    <div class="content">
      <?php $this->Catalogo(); ?>
    </div>
  <!-- /.content-wrapper -->
</div>
<?php $this->Footer('Nucleo'); ?>
<script src="<?php echo constant('URL');?>Views/Js/GLOBAL.js"></script>

<script>
  Paginador('NucleoController',1);
  IsNucleo();
</script>
</body>
</html>