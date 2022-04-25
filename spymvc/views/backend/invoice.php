
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['invoice']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/invoices"><?php echo $lang['invoices']; ?></a></li>
              <li class="breadcrumb-item active">#<?php echo $inv['invoice']['inv_id']; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
    <!-- Main content -->
    <div class="invoice p-3 mb-3">
      <!-- title row -->
      <div class="row">
        <div class="col-12">
          <h4 class="page-header">
          <?php if(empty($options['app_logo'])) { ?>
            <i class="fa fa-globe"></i> <?php echo $options['dhp_name']; ?>
          <?php } else { ?>
            <img src="<?php echo base_url(); ?>assets/usr_pics/<?php echo $options['app_logo']; ?>" width='25%'>
          <?php } ?>
            <small class="float-right">Date: <?php echo date('d M Y', strtotime($inv['invoice']['inv_created'])); ?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
        <?php echo $lang['from']; ?>
          <address>
            <strong><?php echo $options['dhp_name']; ?></strong><br>
            <?php echo $options['address']; ?><br>
            <?php echo $options['city']; ?>, <?php echo $options['state']; ?><br>
            <?php echo $lang['contact']; ?>: <?php echo $options['contact_no']; ?><br>
            <?php echo $lang['email']; ?>: <?php echo $options['email']; ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        <?php echo $lang['to']; ?>
          <address>
            <strong><?php echo $inv['tenant_details']['ten_name']; ?></strong><br>
            <?php echo $inv['tenant_details']['ten_address']; ?><br>
            <?php echo $lang['contact']; ?>: <?php echo $inv['tenant_details']['ten_contact']; ?><br>
            <?php echo $lang['email']; ?>: <?php echo $inv['tenant_details']['ten_email']; ?>
            <?php if(!empty($options['tax_num_label']) && !empty($inv['tenant_details']['ten_tax_number'])) { ?>
            <br><b><?php echo $options['tax_num_label']; ?>:</b> <?php echo $inv['tenant_details']['ten_tax_number']; ?>
            <?php } ?>
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b><?php echo $lang['invoice']; ?> #<?php echo $inv['invoice']['inv_id']; ?></b><br>
          <br>
          <b><?php echo $lang['category']; ?>:</b> <?php echo $inv['invoice']['inv_for']; ?><br>
          <b><?php echo $lang['invoice'].' '.$lang['date']; ?>:</b> <?php echo date('d M Y', strtotime($inv['invoice']['inv_created'])); ?><br>
          <b><?php echo $lang['status']; ?>:</b>
            <?php if($inv['invoice']['inv_status'] == 'PARTIALLY PAID'){ ?>
            <small class="badge badge-warning"><?php echo $inv['invoice']['inv_status']; ?></small>
            <?php } else if($inv['invoice']['inv_status'] == 'UNPAID'){ ?>
            <small class="badge badge-danger"><?php echo $inv['invoice']['inv_status']; ?></small>
            <?php } else { ?>
            <small class="badge badge-success"><?php echo $inv['invoice']['inv_status']; ?></small>
            <?php } ?>
          <br>
          <b><?php echo $lang['amount']; ?>:</b> <?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_total']; ?>
          <?php if(!empty($options['tax_num'])) { ?>
            <br><b><?php echo $options['tax_num_label']; ?>:</b> <?php echo $options['tax_num']; ?>
          <?php } ?>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-xs-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th><?php echo $lang['qty']; ?></th>
              <th><?php echo $lang['product']; ?></th>
              <th><?php echo $lang['serial']; ?> #</th>
              <th><?php echo $lang['description']; ?></th>
              <th><?php echo $lang['subtotal']; ?></th>
            </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                foreach($inv['invoice_items'] as $inv_itm)
                {
                ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $inv_itm['item_name']; ?></td>
                        <td><?php echo $inv_itm['item_id']; ?></td>
                        <td><?php echo $inv_itm['item_desc']; ?></td>
                        <td><?php echo $options['currency_symbol']; ?> <?php echo $inv_itm['item_price']; ?></td>
                    </tr>
                <?php
                $i++;
                }
                ?>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-sm-12 col-md-9 table-responsive">
          <p class="lead"><?php echo $lang['payments']; ?>:</p>

            <table class="table table-striped">
                <thead>
                    <tr>
                    <th><?php echo $lang['qty']; ?></th>
                    <th><?php echo $lang['transactionid']; ?></th>
                    <th><?php echo $lang['payment'].' '.$lang['method']; ?></th>
                    <th><?php echo $lang['amount']; ?></th>
                    <th><?php echo $lang['payment'].' '.$lang['date']; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    foreach($inv['invoice_payments'] as $inv_pay)
                    {
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $inv_pay['payment_trans_id']; ?></td>
                            <td><?php echo $inv_pay['payment_method']; ?></td>
                            <td><?php echo $options['currency_symbol']; ?> <?php echo $inv_pay['payment_amnt']; ?></td>
                            <td><?php echo date('d M Y H:i:s', strtotime($inv_pay['payment_date'])); ?></td>
                        </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
        <div class="col-sm-12 col-md-3">

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th class="width50"><?php echo $lang['subtotal']; ?>:</th>
                <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_amnt']; ?></td>
              </tr>

              <?php if($inv['invoice']['inv_tax'] > 0) { ?>
                <tr>
                  <th><?php echo $options['tax_name']; ?> (<?php echo $inv['invoice']['inv_tax_per']; ?>%)</th>
                  <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_tax']; ?></td>
                </tr>
              <?php } ?>

              <?php if($inv['invoice']['inv_tax2'] > 0) { ?>
                <tr>
                  <th><?php echo $options['tax2_name']; ?> (<?php echo $inv['invoice']['inv_tax2_per']; ?>%)</th>
                  <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_tax2']; ?></td>
                </tr>
              <?php } ?>

              <tr>
                <th><?php echo $lang['total']; ?>:</th>
                <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_total']; ?></td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-12">
          <br><p><?php echo $options['invoice_footer']; ?></p>
        </div>
      </div>

      <div class="row no-print">
        <div class="col-xs-12">
          <a href="<?php echo base_url(); ?>index.php/admin/export_invoice/<?php echo $inv['invoice']['inv_id']; ?>" class="btn btn-success" target="_blank"><i class="fa fa-download"></i> <?php echo $lang['download']; ?></a>
          <button type='button' onClick="window.print();" class="btn btn-default pull-right"><i class="fa fa-print"></i> <?php echo $lang['print']; ?></button>
        </div>
      </div>
    </div>
              </div></div></div></section>
  </div>
  <!-- /.content-wrapper -->

