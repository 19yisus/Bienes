<?php $this->Headers(); $this->Exit(); ?>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php $this->Nav();?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php //$this->Wraper('Inicio');?>
    <!-- Main content -->
    <div class="content mt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="ms-0">Titular</h5>
              </div>
              <div class="card-body">
                <h4 class="card-title">Titulo </h4>

                <p class="card-text">
                  <?php var_dump($this->GetDatos());?>
                </p>
                <a href="" class="card-link">Enlace 1</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <?php $this->Footer();?>
</div>
<!-- ./wrapper -->
</body>
</html>


