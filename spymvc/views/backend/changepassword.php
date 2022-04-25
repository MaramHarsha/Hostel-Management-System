<!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Change Password</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard">Home</a></li>
              <li class="breadcrumb-item active">Change Password</li>
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
              <h3 class="card-title">Change Password</h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'changepass');
      echo form_open_multipart("admin/updatepassword", $attributes); 
			?>
      <div class="card-body">
                        
				<div class="form-group row">
                    <label for="bedname" class="col-sm-1 col-form-label">Current Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" id="c_pass" name="c_pass" value="<?php echo set_value('c_pass'); ?>">
                        <?php echo form_error('c_pass', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="bedname" class="col-sm-1 col-form-label">New Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" id="n_pass" name="n_pass" value="<?php echo set_value('n_pass'); ?>">
                        <?php echo form_error('n_pass', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="bedname" class="col-sm-1 col-form-label">Confirm Password</label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control" id="cn_pass" name="cn_pass" value="<?php echo set_value('cn_pass'); ?>">
                        <?php echo form_error('cn_pass', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>	  
                </div>
				
			
			</div>
			<div class="card-footer">
                <button type="submit" name="savebedant" class="btn btn-success">Save</button>
            </div>
			
			
            <?php echo form_close(); ?>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		</div>
	</div>
	</section>
	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

