
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['aboutus']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['aboutus']; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo $lang['aboutus']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table class='table table-bordered'>
                <tr><td><b>System Name</b></td><td>Calgary Hostel Management System</td></tr>
                <tr><td><b><?php echo $lang['version']; ?></b></td><td><?php echo $options['app_version']; ?></td></tr>
                <tr><td colspan=2><center>Made with <i class="fas fa-heart"></i> in India. A Product of Spykra Technologies.</center></td></tr>
                <tr><td colspan=2><center><img src="<?php echo base_url(); ?>assets/backend/dist/img/spykra.png" class="text_center width20"></center></td></tr>
                </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		</div>
	</div>
	</section>
	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

