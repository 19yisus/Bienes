<!-- jQuery -->
<script src="<?php echo constant('URL');?>Views/Assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo constant('URL');?>Views/Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo constant('URL');?>Views/Assets/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?php echo constant('URL');?>Views/Assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?php echo constant('URL');?>Views/Assets/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo constant('URL');?>Views/Assets/plugins/jquery-validation/jquery.validate.js"></script>
<script src="<?php echo constant('URL');?>Views/Assets/plugins/jquery-validation/additional-methods.js"></script>

<?php if($nameController != ''){ ?>
  <script src="<?php echo constant('URL');?>Views/Js/<?php echo $nameController.'/'.$nameController;?>.js"></script>
  <script src="<?php echo constant('URL');?>Views/Js/JqueryValidations/<?php echo $nameController;?>.js"></script>
<?php    }?>


