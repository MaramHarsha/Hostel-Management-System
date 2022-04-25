    <?php
    if(!isset($tenuid))
    {
        $tenuid = 0;
    }
    ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ($tenuid == 0) ? $lang['new'].' '.$lang['tenant'] : $lang['edit'].' '.$lang['tenant']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/tenants"><?php echo $lang['tenants']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo ($tenuid == 0) ? $lang['new'].' '.$lang['tenant'] : $lang['edit'].' '.$lang['tenant']; ?></li>
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
              <h3 class="card-title"><?php echo ($tenuid == 0) ? $lang['newtenreg'] : $lang['edittenreg']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'addnewtenber');
      echo form_open_multipart("admin/savetenant", $attributes);
			?>
            <div class="card-body">

				<input type="hidden" name="ten_uid" value="<?php echo $tenuid; ?>">
				<div class="form-group row">
                  <label for="tenantname" class="col-sm-1 col-form-label"><?php echo $lang['name']; ?></label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="tenantname" name="ten_name" placeholder="<?php echo $lang['name']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_name') : $tendata['ten_name']; ?>">
                    <?php echo form_error('ten_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>

				  <label for="tenantemail" class="col-sm-1 col-form-label"><?php echo $lang['email']; ?></label>

                  <div class="col-sm-5">
                    <input type="email" class="form-control" id="tenantemail" name="ten_email" placeholder="<?php echo $lang['email']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_email') : $tendata['ten_email']; ?>">
                    <?php echo form_error('ten_email', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>
                </div>

				<div class="form-group row">
                  <label for="tenantphoto" class="col-sm-1 col-form-label"><?php echo $lang['photo']; ?></label>

                  <div class="col-sm-4">
				  <div id="my_camera"></div>
					<script language="JavaScript">
						Webcam.set({
							width: 220,
							height: 220,
							image_format: 'jpeg',
							jpeg_quality: 90,
              force_flash: true
						});
						Webcam.attach( '#my_camera' );
						var date = new Date();
						var components = [
							date.getYear(),
							date.getMonth(),
							date.getDate(),
							date.getHours(),
							date.getMinutes(),
							date.getSeconds(),
							date.getMilliseconds()
						];
						function take_snapshot() {
							Webcam.snap( function(data_uri) {
							document.getElementById('my_camera_result').innerHTML = '<img src="'+data_uri+'" width="148" class="img-circle"/>';
							var filename = components.join("");
							var image_fmt = 'jpeg';
							document.getElementById('ten_photo_webcam').value = filename+'.'+image_fmt;
							var url = '<?php echo base_url(); ?>assets/processdp.php?filename=' + filename + '&format=' + image_fmt;
								Webcam.upload( data_uri, url, function(code, text) {

								} );
							} );
						}
					</script>
                  </div>
				  <input type="hidden" name="ten_photo_webcam" id="ten_photo_webcam" value="<?php echo set_value('ten_photo_webcam'); ?>">
                  <div class="col-sm-2">
                                  <div id="my_camera_result"><?php if($tenuid != 0) { ?> <img src="<?php echo base_url().'assets/usr_pics/'.$tendata['ten_pic']; ?>" width="148" class="img-circle"/> <?php } ?></div>
                    <button type="button" class="btn btn-block btn-primary btn-sm" onClick="take_snapshot()"><?php echo $lang['take'].' '.$lang['photo']; ?></button>
                  </div>
				  <div class="col-sm-5">
          -OR-  
                <div class="custom-file">
                  <label for="tenantphotoselect" class="custom-file-label"><?php echo $lang['select'].' '.$lang['photo']; ?></label>
                  <input type="file" id="tenantphotoselect" class="custom-file-input" name="ten_photo_select" value="<?php echo set_value('ten_photo_select');?>">
                  <?php echo form_error('ten_photo_select', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                </div>

                  </div>
                </div>
        <input type="hidden" name="ten_pic" value="<?php if($tenuid != 0) { echo $tendata['ten_pic']; } ?>">
				<script>
				function checkIfCamPicAvailable() {
					var campic = document.getElementById('ten_photo_webcam').value;
					var picurl = '<?php echo base_url().'assets/usr_pics/'; ?>'+campic;
					if(campic!='')
					{
						document.getElementById('my_camera_result').innerHTML = '<img src="'+picurl+'" width="148" class="img-circle"/>';
					}
				}
				window.onload = checkIfCamPicAvailable;
				</script>
				<div class="form-group row">
          <label for="datepicker" class="col-sm-1 col-form-label"><?php echo $lang['dob']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control datepicker" id="ten_dob" name="ten_dob" placeholder="<?php echo $lang['dob']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_dob') : $tendata['ten_dob']; ?>">
            <?php echo form_error('ten_dob', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>

				  <label for="tenantgender" class="col-sm-1 col-form-label"><?php echo $lang['gender']; ?></label>

          <div class="col-sm-5">
						<label>
						  <input type="radio" name="ten_gender" class="flat-red" value="M" <?php if ($tenuid == 0) { echo 'checked'; } else { if($tendata['ten_gender'] == 'M') { echo 'checked'; } }  ?>> <?php echo $lang['male']; ?>
						</label>
						<label>
						  <input type="radio" name="ten_gender" class="flat-red" value="F" <?php if ($tenuid != 0 && $tendata['ten_gender'] == 'F') { echo 'checked'; } ?>> <?php echo $lang['female']; ?>
						</label>
						<label>
						  <input type="radio" name="ten_gender" class="flat-red" value="O" <?php if ($tenuid != 0 && $tendata['ten_gender'] == 'O') { echo 'checked'; } ?>> <?php echo $lang['other']; ?>
						</label>
					</div>
        </div>

				<div class="form-group row">
          <label for="tenantaddress" class="col-sm-1 col-form-label"><?php echo $lang['address']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="tenantaddress" name="ten_address" placeholder="<?php echo $lang['address']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_address') : $tendata['ten_address']; ?>">
          </div>

				  <label for="tenantcontact" class="col-sm-1 col-form-label"><?php echo $lang['contact']; ?></label>

            <div class="col-sm-5">
              <input type="text" class="form-control" id="tenantcontact" name="ten_contact" placeholder="<?php echo $lang['contact']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_contact') : $tendata['ten_contact']; ?>">
              <?php echo form_error('ten_contact', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
            </div>
        </div>

        <?php if($isadmin) { ?>
          <div class="form-group row">
            <label for="tenantbranch" class="col-sm-1 col-form-label"><?php echo $lang['branch']; ?></label>
            <div class="col-sm-5">
              <select class="form-control smartselect" id="tenantbranch" name="ten_branch">
                <option value="">--<?php echo $lang['select'].' '.$lang['branch']; ?>--</option>
                <?php
                $branchid = ($tenuid == 0) ? set_value('ten_branch') : $tendata['ten_branch'];
                foreach($branches as $branch)
                {
                ?>
                    <option value="<?php echo $branch['id']; ?>" <?php if($branchid == $branch['id']) { echo 'selected'; } ?>><?php echo $branch['branch_name']; ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="col-sm-6">
            <?php echo $lang['branch_tenant_note']; ?>
            </div>
          </div>
        <?php } else { ?>
          <input type="hidden" name="ten_branch" value="<?php echo $branchid; ?>">
        <?php } ?>

        <hr/>
				<h4><?php echo $lang['tax'].' '.$lang['details']; ?>:</h4>
        <hr/>
        
        <div class="form-group row">
          <label for="ten_tax_company_name" class="col-sm-1 col-form-label"><?php echo $lang['company_name']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="ten_tax_company_name" name="ten_tax_company_name" placeholder="<?php echo $lang['company_name']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_tax_company_name') : $tendata['ten_tax_company_name']; ?>">
            <?php echo form_error('ten_tax_company_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>

				  <label for="ten_tax_company_email" class="col-sm-1 col-form-label"><?php echo $lang['company_email']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="ten_tax_company_email" name="ten_tax_company_email" placeholder="<?php echo $lang['company_email']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_tax_company_email') : $tendata['ten_tax_company_email']; ?>">
            <?php echo form_error('ten_tax_company_email', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>
        </div>

        <div class="form-group row">
          <label for="ten_tax_number" class="col-sm-1 col-form-label"><?php echo $lang['company_taxno']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="ten_tax_number" name="ten_tax_number" placeholder="<?php echo $lang['company_taxno']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_tax_number') : $tendata['ten_tax_number']; ?>">
            <?php echo form_error('ten_tax_number', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>
        </div>


				<hr/>
				<h4><?php echo $lang['ecd']; ?>:</h4>
				<hr/>

				<div class="form-group row">
          <label for="tenantemcname" class="col-sm-1 col-form-label"><?php echo $lang['name']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="tenantemcname" name="ten_emc_name" placeholder="<?php echo $lang['name']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_emc_name') : $tendata['ten_emc_name']; ?>">
            <?php echo form_error('ten_emc_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>

				  <label for="tenantemcnum" class="col-sm-1 col-form-label"><?php echo $lang['contact']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="tenantemcnum" name="ten_emc_contact" placeholder="<?php echo $lang['contact']; ?>" value="<?php echo ($tenuid == 0) ? set_value('ten_emc_contact') : $tendata['ten_emc_contact']; ?>">
            <?php echo form_error('ten_emc_contact', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>
        </div>

				
				<hr/>
				<h4>*<?php echo $lang['ed']; ?>:</h4>
				<hr/>

				<div class="form-group row">
                  <label for="tenantstatus" class="col-sm-1 col-form-label"><?php echo $lang['status']; ?></label>

                  <div class="col-sm-5">

                  <?php 
                  $ten_status = ($tenuid == 0) ? set_value('ten_isactive') : $tendata['ten_isactive']; 
                  if($ten_status == 0)
                  {
                    $active = '';
                    $inactive = 'selected';
                  }
                  else
                  {
                    $active = 'selected';
                    $inactive = '';
                  }
                  ?>

                    <select class="form-control" id="tenantstatus" name="ten_isactive">
                      <option value="1" <?php echo $active; ?>><?php echo $lang['active']; ?></option>
                      <option value="0" <?php echo $inactive; ?>><?php echo $lang['inactive']; ?></option>
                    </select>
                  </div>

				  <label for="tenantcomments" class="col-sm-1 col-form-label"><?php echo $lang['comments']; ?></label>

                  <div class="col-sm-5">
                    <textarea class="form-control" id="tenantcomments" name="ten_comments"><?php echo ($tenuid == 0) ? set_value('ten_comments') : $tendata['ten_comments']; ?></textarea>
                  </div>
                </div>

			</div>
			<div class="card-footer">
                <button type="submit" name="savetenant" class="btn btn-success"><?php echo $lang['save']; ?></button>
                <?php if($tenuid == 0) { ?><button type="submit" name="saveandnewtenant" class="btn btn-primary"><?php echo $lang['savenn']; ?></button><?php } ?>
                <a href="<?php echo $burl; ?>admin/tenants" class="btn btn-warning"><?php echo $lang['cancel']; ?></a>
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
