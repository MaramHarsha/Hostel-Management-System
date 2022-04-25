    <?php
    if(!isset($configuid))
    {
        $configuid = 0;
    }
    ?>
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['configurations']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['configurations']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['configurations']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'configurations');
      echo form_open_multipart("admin/updateconfig", $attributes);
			?>
            <div class="card-body">

      <h3><span class="badge badge-secondary"><?php echo $lang['gend']; ?></span></h3><hr/>

      <div class="form-group row">
        <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['hpdname']; ?></label>
        <div class="col-sm-11">
          <input type="text" class="form-control" id="dhp_name" name="dhp_name" value="<?php echo $options['dhp_name']; ?>">
          <?php echo form_error('dhp_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
        </div> 
      </div>

      <div class="form-group row">
        <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['app'].' '.$lang['footer']; ?></label>
        <div class="col-sm-11">
          <input type="text" class="form-control" id="app_footer" name="app_footer" value="<?php echo $options['app_footer']; ?>">
          <?php echo form_error('app_footer', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
        </div> 
      </div>

      <div class="form-group row">
        <label for="applogo" class="col-sm-1 col-form-label"><?php echo $lang['app'].' '.$lang['logo']; ?></label>
        <div class="col-sm-5">
          <input type="file" class="form-control" id="ten_photo_select" name="ten_photo_select" value="<?php echo $options['app_logo']; ?>">
          <?php echo form_error('app_logo', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
        </div> 
        <div class="col-sm-5">
        <input type="hidden" name="app_logo" value="<?php echo $options['app_logo']; ?>">
        <?php if(!empty($options['app_logo'])) { ?> <img src="<?php echo base_url().'assets/usr_pics/'.$options['app_logo']; ?>" width="25%"/> <?php } ?>
        </div>
      </div>
      
      <div class="form-group row">
                <label for="contactno" class="col-sm-1 col-form-label"><?php echo $lang['contact']; ?></label>

                <div class="col-sm-5">
                  <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo $options['contact_no']; ?>">
                  <?php echo form_error('contact_no', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                </div>
        
        <label for="email" class="col-sm-1 col-form-label"><?php echo $lang['email']; ?></label>

                <div class="col-sm-5">
                  <input type="text" class="form-control" id="email" name="email" value="<?php echo $options['email']; ?>">
                  <?php echo form_error('email', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                </div> 
      </div>

      <div class="form-group row">
          <label for="country" class="col-sm-1 col-form-label"><?php echo $lang['country']; ?></label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="country" name="country" value="<?php echo $options['country']; ?>">
            <?php echo form_error('country', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
				  </div> 
				  <label for="state" class="col-sm-1 col-form-label"><?php echo $lang['state']; ?></label>
          <div class="col-sm-5">
            <input type="text" class="form-control" id="state" name="state" value="<?php echo $options['state']; ?>">
            <?php echo form_error('state', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
				  </div> 
      </div>
				
				<div class="form-group row">
                  <label for="city" class="col-sm-1 col-form-label"><?php echo $lang['city']; ?></label>
                  <div class="col-sm-5">
                  <input type="text" class="form-control" id="city" name="city" value="<?php echo $options['city']; ?>">
                  <?php echo form_error('city', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
					</div>
					<label for="address" class="col-sm-1 col-form-label"><?php echo $lang['address']; ?></label>

                  <div class="col-sm-5">
                    <textarea class="form-control" id="address" name="address"><?php echo $options['address']; ?></textarea>
                    <?php echo form_error('address', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>
				  </div>

          <div class="form-group row">
                  <label for="city" class="col-sm-1 col-form-label"><?php echo $lang['currency'].' '.$lang['code']; ?></label>
                  <div class="col-sm-5">
                  <input type="text" class="form-control" id="currency_code" name="currency_code" value="<?php echo $options['currency_code']; ?>">
                  <?php echo form_error('currency_code', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
					</div>
					<label for="address" class="col-sm-1 col-form-label"><?php echo $lang['currency'].' '.$lang['symbol']; ?></label>

                  <div class="col-sm-5">
                  <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" value="<?php echo $options['currency_symbol']; ?>">
                  <?php echo form_error('currency_symbol', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>
          </div>
          <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['language']; ?></label>
              <div class="col-5">
                <select class="form-control smartselect" id="lang" name="lang">
                    <?php
                    foreach($languages as $eachlang)
                    {
                    ?>
                        <option value="<?php echo strtolower($eachlang['lang_name']); ?>" <?php if($options['lang'] == strtolower($eachlang['lang_name'])) { echo 'selected'; } ?>><?php echo $eachlang['lang_name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
              </div> 
          </div>        

          <h3><span class="badge badge-secondary"><?php echo $lang['smtpd']; ?></span></h3><hr/>
            <div class="form-group row">
              <label for="smtphost" class="col-sm-1 col-form-label"><?php echo $lang['smtp'].' '.$lang['host']; ?></label>

              <div class="col-sm-5">
                <input type="text" class="form-control" id="smtp_host" name="smtp_host" value="<?php echo $options['smtp_host']; ?>">
                <?php echo form_error('smtp_host', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div>
              
              <label for="smtpusername" class="col-sm-1 col-form-label"><?php echo $lang['smtp'].' '.$lang['username']; ?></label>

              <div class="col-sm-5">
                <input type="text" class="form-control" id="smtp_username" name="smtp_username" value="<?php echo $options['smtp_username']; ?>">
                <?php echo form_error('smtp_username', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>
            <div class="form-group row">
              <label for="smtppass" class="col-sm-1 col-form-label"><?php echo $lang['smtp'].' '.$lang['password']; ?></label>

              <div class="col-sm-5">
                <input type="text" class="form-control" id="smtp_pass" name="smtp_pass" value="<?php echo $options['smtp_pass']; ?>">
                <?php echo form_error('smtp_pass', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div>
              
              <label for="smtpport" class="col-sm-1 col-form-label"><?php echo $lang['smtp'].' '.$lang['port']; ?></label>

              <div class="col-sm-5">
                <input type="text" class="form-control" id="smtp_port" name="smtp_port" value="<?php echo $options['smtp_port']; ?>">
                <?php echo form_error('smtp_port', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <h3><span class="badge badge-secondary"><?php echo $lang['paymentsettings']; ?></span></h3><hr/>
            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['paymentgateway']; ?></label>
              <div class="col-5">
                <select class="form-control smartselect" id="payment_gtw" name="payment_gtw">
                  <option value="stripe" <?php if($options['payment_gtw'] == 'stripe') { echo 'selected'; } ?>>Stripe</option>
                  <option value="paystack" <?php if($options['payment_gtw'] == 'paystack') { echo 'selected'; } ?>>Paystack</option>
                  <option value="razorpay" <?php if($options['payment_gtw'] == 'razorpay') { echo 'selected'; } ?>>Razorpay</option>
                </select>
              </div> 
          </div> 
            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['ssk']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="stripe_secret_key" name="stripe_secret_key" value="<?php echo $options['stripe_secret_key']; ?>">
                <?php echo form_error('stripe_secret_key', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['spk']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="stripe_publishable_key" name="stripe_publishable_key" value="<?php echo $options['stripe_publishable_key']; ?>">
                <?php echo form_error('stripe_publishable_key', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['paystack_secret_Key']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="paystack_secret_Key" name="paystack_secret_Key" value="<?php echo $options['paystack_secret_Key']; ?>">
                <?php echo form_error('paystack_secret_Key', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['paystack_public_Key']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="paystack_public_Key" name="paystack_public_Key" value="<?php echo $options['paystack_public_Key']; ?>">
                <?php echo form_error('paystack_public_Key', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['razp_web_key']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="razp_web_key" name="razp_web_key" value="<?php echo $options['razp_web_key']; ?>">
                <?php echo form_error('razp_web_key', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <h3><span class="badge badge-secondary"><?php echo $lang['taxsettings']; ?></span></h3><hr/>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['tax'].' '.$lang['name']; ?> 1</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="tax_name" name="tax_name" value="<?php echo $options['tax_name']; ?>">
                <?php echo form_error('tax_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['tax']; ?> % 1</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="tax_per" name="tax_per" value="<?php echo $options['tax_per']; ?>">
                <?php echo form_error('tax_per', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['tax'].' '.$lang['name']; ?> 2</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="tax2_name" name="tax2_name" value="<?php echo $options['tax2_name']; ?>">
                <?php echo form_error('tax2_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['tax']; ?> % 2</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="tax2_per" name="tax2_per" value="<?php echo $options['tax2_per']; ?>">
                <?php echo form_error('tax2_per', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['taxnumlabel']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="tax_num_label" name="tax_num_label" value="<?php echo $options['tax_num_label']; ?>">
                <?php echo form_error('tax_num_label', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['taxnum']; ?></label>
              <div class="col-sm-5">
                <input type="text" class="form-control" id="tax_num" name="tax_num" value="<?php echo $options['tax_num']; ?>">
                <?php echo form_error('tax_num', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <h3><span class="badge badge-secondary"><?php echo $lang['invsettings']; ?></span></h3><hr/>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['invoicefooternote']; ?></label>
              <div class="col-sm-11">
                <textarea class="form-control" id="invoice_footer" name="invoice_footer"><?php echo $options['invoice_footer']; ?></textarea>
                <?php echo form_error('invoice_footer', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

            <h3><span class="badge badge-secondary"><?php echo $lang['othersettings']; ?></span></h3><hr/>

            <div class="form-group row">
              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['tsid']; ?></label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="tid_start" name="tid_start" value="<?php echo $options['tid_start']; ?>">
                <?php echo form_error('tid_start', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['rsid']; ?></label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="rid_start" name="rid_start" value="<?php echo $options['rid_start']; ?>">
                <?php echo form_error('rid_start', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 

              <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['bsid']; ?></label>
              <div class="col-sm-3">
                <input type="text" class="form-control" id="bid_start" name="bid_start" value="<?php echo $options['bid_start']; ?>">
                <?php echo form_error('bid_start', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
              </div> 
            </div>

        </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success"><?php echo $lang['save']; ?></button>
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

 