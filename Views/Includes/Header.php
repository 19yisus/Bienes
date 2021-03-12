<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/toastr/toastr.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/datatables/dataTables.css">
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo constant('URL');?>Views/Assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <style>
    label ~ #ob{
      color: red;
      font-size: 17px;
      font-weight: bold;
    }
  </style>
  <title><?php echo ($title == '') ? constant('App_name')[0].' '.constant('App_name')[1] : $title; ?></title>
</head>
