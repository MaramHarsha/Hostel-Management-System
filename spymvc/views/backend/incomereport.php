
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ucfirst($report); ?> <?php echo $lang['report']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo ucfirst($report); ?> <?php echo $lang['report']; ?></li>
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
              <h3 class="card-title"><?php echo ucfirst($report); ?> <?php echo $lang['report']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
              <table class="table responsive table-bordered table-hover">
              <?php
			        $attributes = array('class' => 'form-horizontal', 'id' => $report.'report');
              echo form_open_multipart("admin/generate".ucfirst($report)."Report", $attributes);
              ?>
                <tr>
                <td>From</td><td><input type="text" class="form-control datepicker" name="from_date" placeholder="<?php echo $lang['from'].' '.$lang['date']; ?>"></td>
                <td>To</td><td><input type="text" class="form-control datepicker" name="to_date" placeholder="<?php echo $lang['to'].' '.$lang['date']; ?>"></td>
                </tr> 
                <tr>
                <td colspan='4' class='text_center'><button class='btn btn-primary' type='submit'><?php echo $lang['generate'].' '.$lang['report']; ?></button></td>
                </tr>
              <?php echo form_close(); ?>
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

