<?php
if(!isset($esid))
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
            <h1><?php echo $lang['assign'].' '.$lang['extraservice']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/extraservices"><?php echo $lang['extraservices']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['assign'].' '.$lang['extraservice']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['assignestotenant']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'assignes');
            echo form_open_multipart("admin/processes", $attributes); 
			?>
      <div class="card-body">
                <input type="hidden" name="esid" value="<?php echo $esid; ?>">
                <input type="hidden" name="requestid" value="<?php echo $reqid; ?>">

                <div class="form-group row">
                    <label for="bedname" class="col-sm-1 col-form-label"><?php echo $lang['extraservice'].' '.$lang['name']; ?></label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control" name="es_name" value="<?php echo $esdata['es_name']; ?>" readonly>
                    </div>
				  
                    <label for="roomname" class="col-sm-1 col-form-label"><?php echo $lang['extraservice'].' '.$lang['details']; ?></label>
                    <div class="col-sm-5">
                    <textarea class="form-control" name="es_details" readonly><?php echo $esdata['es_details']; ?></textarea>
                    </div>
                </div>

				<div class="form-group row">
				    <label for="room" class="col-sm-1 col-form-label"><?php echo $lang['tenant']; ?></label>
                    <div class="col-sm-11">
                        <select class="form-control smartselect" id="tenantforbed" name="assignbed_tenant">
                        <option value="">--<?php echo $lang['select'].' '.$lang['tenant']; ?>--</option>
                        <?php
                        foreach($tenlist as $ten)
                        {
                        ?>
                            <option value="<?php echo $ten['ten_uid']; ?>" <?php if($ten['ten_uid'] == $tenuid) { echo 'selected'; } ?>><?php echo $ten['ten_name']; ?></option>
                        <?php
                        }
                        ?>
                        </select>
                        <?php echo form_error('assignbed_tenant', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="bedtotalprice" class="col-sm-1 col-form-label"><?php echo $lang['baseprice']; ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="bedbaseprice" name="base_amnt" value="<?php echo $esdata['es_price']; ?>">
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

                <?php
                $tax1 = calcTax($options['tax_per'],$esdata['es_price']);
                $tax2 = calcTax($options['tax2_per'],$esdata['es_price']);
                $total_with_tax = $esdata['es_price']+$tax1+$tax2;
                ?>
				
				
				<div class="form-group row">
				    <label for="bedtotalprice" class="col-sm-1 col-form-label"><?php echo $lang['total']; ?></label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="bedtotalprice" name="total_amnt" value="<?php echo $total_with_tax; ?>">
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
                    <label for="lease_from" class="col-sm-1 col-form-label"><?php echo $lang['from']; ?></label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control datepicker" id="lease_from" name="lease_from" placeholder="<?php echo $lang['from'].' '.$lang['date']; ?>" value="<?php echo set_value('lease_from'); ?>">
                    <?php echo form_error('lease_from', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>

                    <label for="lease_to" class="col-sm-1 col-form-label"><?php echo $lang['to']; ?></label>
                    <div class="col-sm-5">
                    <input type="text" class="form-control datepicker" id="lease_to" name="lease_to" placeholder="<?php echo $lang['to'].' '.$lang['date']; ?>" value="<?php echo set_value('lease_to'); ?>">
                    <?php echo form_error('lease_to', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                    </div>
                </div>

			</div>
			<div class="card-footer">
                <button type="submit" name="savebedant" class="btn btn-success"><?php echo $lang['assign']; ?></button>
                <a href="<?php echo $burl; ?>admin/extraservices" class="btn btn-warning"><?php echo $lang['cancel']; ?></a>
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

