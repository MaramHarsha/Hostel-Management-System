<?php
if(!isset($tenuid))
{
    die('Wrong Request!');
}
?>
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['assign'].' '.$lang['bed']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/tenants"><?php echo $lang['tenants']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['assign'].' '.$lang['bed']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['assignbedtotenant']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'assignbed');
            echo form_open_multipart("admin/processTenBed", $attributes); 
			?>
      <div class="card-body">
				<input type="hidden" name="assignbed_tenant" value="<?php echo $tenuid; ?>">
                <input type="hidden" name="request_from" value="tenants">
                <input type="hidden" name="bed_name" id="ten_bed_name" value="">
                <input type="hidden" name="room_name" id="ten_room_name" value="">

                <div class="form-group row roomselectionform">
                  <label for="tenantroom" class="col-sm-1 col-form-label"><?php echo $lang['room']; ?></label>

                  <div class="col-sm-5">
                    <select class="form-control roomselect" id="tenantroom" name="room_uid">
                      <optgroup class='def-cursor' label='Room' data-totalbeds='Total Beds' data-availablebeds='Available Beds' data-baseprice='Base Price'>
                      <option value="" data-totalbeds='' data-availablebeds='' data-baseprice=''>--<?php echo $lang['select'].' '.$lang['room']; ?>--</option>
                      <?php 
                      foreach($allrooms as $room)
                      {
                      ?>
                        <option data-totalbeds="<?php echo $room['allbeds']; ?>" data-availablebeds="<?php echo $room['avlbeds']; ?>" data-baseprice="<?php echo $options['currency_symbol']; ?> <?php echo $room['room_price']; ?>" value="<?php echo $room['room_uid']; ?>" <?php if($room['avlbeds']<1) echo'disabled'; ?>><?php echo $room['room_name']; ?></option>
                      <?php
                      }
                      ?>
                    </select>
                    <?php echo form_error('room_uid', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>

				  <label for="tenantbed" class="col-sm-1 col-form-label"><?php echo $lang['bed']; ?></label>

                  <div class="col-sm-5">
                    <select class="form-control smartselect" id="tenantbed" name="bed_uid">
                      <option value="">-- <?php echo $lang['select'].' '.$lang['bed']; ?> --</option>
                    </select>
                    <?php echo form_error('bed_uid', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>
                </div>
				
                <div class="form-group row">
				            <label for="bedtotalprice" class="col-sm-1 col-form-label"><?php echo $lang['base'].' '.$lang['price']; ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="bedbaseprice" name="base_amnt" value="">
                        <?php echo form_error('base_amnt', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="tax1per" class="col-sm-1 col-form-label"><?php echo $options['tax_name']; ?></label>
                    <div class="col-sm-3">
                      <div class="input-group">
                        <input type="text" class="form-control" id="tax1per" name="tax_per" value="<?php echo (isset($_POST['tax_per'])) ? set_value('tax_per') : $options['tax_per']; ?>">
                        <div class="input-group-append"> <span class="input-group-text">%</span> </div>
                      </div>
                      <?php echo form_error('tax_per', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="taxt2per" class="col-sm-1 col-form-label"><?php echo $options['tax2_name']; ?></label>
                    <div class="col-sm-3">
                      <div class="input-group">
                        <input type="text" class="form-control" id="tax2per" name="tax2_per" value="<?php echo (isset($_POST['tax2_per'])) ? set_value('tax2_per') : $options['tax2_per']; ?>">
                        <div class="input-group-append"> <span class="input-group-text">%</span> </div>
                      </div>
                        <?php echo form_error('tax2_per', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>
                </div>

				        <div class="form-group row">
				            <label for="bedtotalprice" class="col-sm-1 col-form-label"><?php echo $lang['total']; ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="bedtotalprice" name="total_amnt" value="">
                        <?php echo form_error('total_amnt', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="bedpaidprice" class="col-sm-1 col-form-label"><?php echo $lang['paid']; ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="bedpaidprice" name="paid_amnt" value="<?php echo set_value('paid_amnt'); ?>">
                        <?php echo form_error('paid_amnt', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="bedbalprice" class="col-sm-1 col-form-label"><?php echo $lang['balance']; ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="bedbalprice" name="bal_amnt" value="<?php echo set_value('bal_amnt'); ?>">
                        <?php echo form_error('bal_amnt', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="lease_from" class="col-sm-1 col-form-label"><?php echo $lang['leasefrom']; ?></label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control datepicker" id="lease_from" name="lease_from" placeholder="<?php echo $lang['leasefrom']; ?>" value="<?php echo set_value('lease_from'); ?>">
                    <?php echo form_error('lease_from', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="lease_to" class="col-sm-1 col-form-label"><?php echo $lang['leaseto']; ?></label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control datepicker" id="lease_to" name="lease_to" placeholder="<?php echo $lang['leaseto']; ?>" value="<?php echo set_value('lease_to'); ?>">
                    <?php echo form_error('lease_to', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>
                </div>

			</div>
			<div class="card-footer">
                <button type="submit" name="savebedant" class="btn btn-success"><?php echo $lang['assign']; ?></button>
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

