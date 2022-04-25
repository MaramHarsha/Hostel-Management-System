
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['make'].' '.$lang['payment']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['make'].' '.$lang['payment']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['make'].' '.$lang['payment']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'paymentForm');
      echo form_open_multipart("admin/madepayment", $attributes); 
			?>
            <div class="card-body">
                        
				<div class="form-group row">
          <label for="invoice" class="col-sm-1 col-form-label"><?php echo $lang['invoice']; ?></label>

          <div class="col-sm-11">
            <select class="form-control smartselect" id="pay_invoice" name="invoice">
                    <option value="">--<?php echo $lang['select'].' '.$lang['invoice']; ?>--</option>
                    <?php
                    foreach($allinvs as $inv)
                    {
                    ?>
                        <option value="<?php echo $inv['inv_id']; ?>"><?php echo $inv['inv_id']; ?> - <?php echo $inv['ten_name']; ?> - <?php echo $inv['inv_status']; ?></option>
                    <?php
                    }
                    ?>
            </select>
            <?php echo form_error('invoice', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>
        </div>
        <div class="form-group row">
          <label for="total" class="col-sm-1 col-form-label"><?php echo $lang['total']; ?></label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="total" name="total" value="<?php echo set_value('total'); ?>" readonly>
            <?php echo form_error('total', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>

          <label for="paid" class="col-sm-1 col-form-label"><?php echo $lang['paid']; ?></label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="paid" name="paid" value="<?php echo set_value('paid'); ?>" readonly>
            <?php echo form_error('paid', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
				  </div>

          <label for="balance" class="col-sm-1 col-form-label"><?php echo $lang['balance']; ?></label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="balance" name="balance" value="<?php echo set_value('balance'); ?>" readonly>
            <?php echo form_error('balance', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
				  </div>
        </div>

        <div class="form-group row">
          <label for="pay_amnt" class="col-sm-1 col-form-label"><?php echo $lang['paying']; ?></label>
          <div class="col-sm-3">
            <input type="text" class="form-control" id="pay_amnt" name="pay_amnt" value="<?php echo set_value('pay_amnt'); ?>">
            <?php echo form_error('pay_amnt', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
        </div>
        </div>

        <?php if($options['payment_gtw'] == 'stripe') {  ?>
        <div class="form-group row">
            <label for="pay_amnt" class="col-sm-1 col-form-label"><?php echo $lang['cardnumber']; ?></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="cardNumber" size="20" autocomplete="off" id="cardNumber" value="<?php echo set_value('cardNumber'); ?>">
                <?php echo form_error('cardNumber', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
            </div>

            <label for="pay_amnt" class="col-sm-1 col-form-label"><?php echo $lang['expmm']; ?></label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="cardExpMonth" placeholder="MM" size="2" id="cardExpMonth" value="<?php echo set_value('cardExpMonth'); ?>">
                <?php echo form_error('cardExpMonth', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
            </div>

            <label for="pay_amnt" class="col-sm-1 col-form-label"><?php echo $lang['expmm']; ?></label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="cardExpYear" placeholder="YY" size="4" id="cardExpYear" value="<?php echo set_value('cardExpYear'); ?>">
                <?php echo form_error('cardExpYear', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
            </div>

            <label for="pay_amnt" class="col-sm-1 col-form-label"><?php echo $lang['cvv']; ?></label>
            <div class="col-sm-1">
                <input type="text" class="form-control" name="cardCVC" size="4" autocomplete="off" id="cardCVC" value="<?php echo set_value('cardCVC'); ?>">
                <?php echo form_error('cardCVC', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
            </div>
        </div>
        <?php } ?>
        <input type="hidden" id="pay_transid" name="pay_transid">

        </div>
        <div class="card-footer">
        <?php if($options['payment_gtw'] == 'stripe') {  ?>

          <button type="submit" name="paybttn" class="btn btn-success"><?php echo $lang['pay']; ?></button>

        <?php } elseif($options['payment_gtw'] == 'paystack') { ?>

          <button type="button" name="paybttn" class="btn btn-success" onclick="payWithPaystack('<?php echo $userdata['user_email']; ?>','<?php echo $options['currency_code']; ?>')"><?php echo $lang['pay']; ?></button>
        
        <?php } elseif($options['payment_gtw'] == 'razorpay') { ?>
        
          <button type="button" name="paybttn" class="btn btn-success" onclick="payWithRazorpay('<?php echo $userdata['user_email']; ?>','<?php echo $options['currency_code']; ?>','<?php echo $userdata['user_name']; ?>','<?php echo $options['dhp_name']; ?>')"><?php echo $lang['pay']; ?></button>
        
        <?php } ?>


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

