  <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline-block">
      <b><?php echo $lang['version']; ?></b> <?php echo $options['app_version']; ?>
    </div>
    <strong><?php echo $options['app_footer']; ?> | <?php echo $lang['poweredby']; ?> JKLU | <?php echo $lang['designedby']; ?> <a href="https://adminlte.io/" target="_blank">AdminLTE</a>.</strong> <?php echo $lang['rightsreserved']; ?>
  </footer>
</div>
<!-- ./wrapper -->
<script language="javascript">
var base_url = '<?php echo base_url(); ?>';
var lang = <?php echo json_encode($lang); ?>;
var language = '<?php echo $language; ?>';
var languageabbr = '<?php echo $languageabbr; ?>';
</script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/jQuery/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/knob/jquery.knob.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/datepicker/locales/bootstrap-datepicker.<?php echo $languageabbr; ?>.js" charset="UTF-8"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/slimScroll/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/loadingoverlay.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/iframeResizer/jquery-iframe-auto-height.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/plugins/iframeResizer/jquery.browser.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/jquery.fullscreen.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/adminlte.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/demo.js"></script>
<script type="text/javascript">
$(function($) {
 $.ajaxSetup({
     data: {
         '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
     }
 });
});
</script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/MercuryGMS.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/bootbox.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/notify.js"></script>
<?php if($options['payment_gtw'] == 'stripe') { ?>

  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script type="text/javascript">
  var stripe_pub_key = '<?php echo $options['stripe_publishable_key'] ?>';
  </script>
  <?php if(!empty($options['stripe_publishable_key'])) { ?>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/dist/js/payment.js"></script>
  <?php } ?>

<?php } elseif($options['payment_gtw'] == 'paystack') { ?>

<script src="https://js.paystack.co/v1/inline.js"></script>
<script type="text/javascript">
  var pays_pub_key = '<?php echo $options['paystack_public_Key'] ?>';
</script>

<?php } elseif($options['payment_gtw'] == 'razorpay') { ?>

  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
  var razp_web_key = '<?php echo $options['razp_web_key'] ?>';
</script>

<?php } ?>

<?php
  if(isset($gc))
  {
    $i=1;
  foreach($gc->js_files as $file):
    if($i!=1)
    {
  ?>
  
      <script src="<?php echo $file; ?>"></script>
      
  <?php 
    } $i++;
  endforeach; 
  }
?>
<script language="javascript">
    <?php
    if(!empty($notify_msg) && isset($notify_type))
    {
    ?>
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        Toast.fire({
          type: '<?php echo $notify_type; ?>',
          title: '<?php echo $notify_msg; ?>'
	      });
    <?php
    }
    ?>
</script>
</body>
</html>