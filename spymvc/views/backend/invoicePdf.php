<html>
<head>
    <meta charset="utf-8">
    

</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0" width="100%" border=1>
            <tr class="top">
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td class="title" style="width:65%">
                                <?php if(empty($options['app_logo'])) { ?>
                                  <?php echo $options['dhp_name']; ?>
                                <?php } else { ?>
                                  <img src="<?php echo base_url(); ?>assets/usr_pics/<?php echo $options['app_logo']; ?>" style="width:100%; max-width:300px;">
                                <?php } ?>
                            </td>
                            
                            <td>
                                <?php echo $lang['invoice']; ?> #: <?php echo $inv['invoice']['inv_id']; ?><br>
                                <?php echo $lang['date']; ?>: <?php echo date('d M Y', strtotime($inv['invoice']['inv_created'])); ?><br>
                                <?php echo $lang['status']; ?>: <?php echo $inv['invoice']['inv_status']; ?><br>
                                <?php echo $lang['amount']; ?>: <?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_total']; ?>
                                <?php if(!empty($options['tax_num'])) { ?>
                                    <br><b><?php echo $options['tax_num_label']; ?>:</b> <?php echo $options['tax_num']; ?>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table width="100%">
                        <tr>
                            <td style="width:75%">
                            <?php echo $lang['from']; ?>,<br>
                                <strong><?php echo $options['dhp_name']; ?></strong><br>
                                <?php echo $options['address']; ?><br>
                                <?php echo $options['contact_no']; ?>
                            </td>
                            
                            <td>
                            <?php echo $lang['to']; ?>,<br>
                                <strong><?php echo $inv['tenant_details']['ten_name']; ?></strong><br>
                                <?php echo $inv['tenant_details']['ten_address']; ?><br>
                                <?php echo $inv['tenant_details']['ten_contact']; ?>
                                <?php if(!empty($options['tax_num_label']) && !empty($inv['tenant_details']['ten_tax_number'])) { ?>
                                <br><b><?php echo $options['tax_num_label']; ?>:</b> <?php echo $inv['tenant_details']['ten_tax_number']; ?>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br><br>
        <table width="100%" border='1' style="border-collapse: collapse;">
            
            <tr class="heading">
              <td><?php echo $lang['qty']; ?></td>
              <td><?php echo $lang['product']; ?></td>
              <td><?php echo $lang['serial']; ?> #</td>
              <td><?php echo $lang['description']; ?></td>
              <td><?php echo $lang['subtotal']; ?></td>
            </tr>

            <?php
            $i=1;
            foreach($inv['invoice_items'] as $inv_itm)
            {
            ?>
                <tr class="item">
                    <td><?php echo $i; ?></td>
                    <td><?php echo $inv_itm['item_name']; ?></td>
                    <td><?php echo $inv_itm['item_id']; ?></td>
                    <td><?php echo $inv_itm['item_desc']; ?></td>
                    <td width="10%"><?php echo $options['currency_symbol']; ?> <?php echo $inv_itm['item_price']; ?></td>
                </tr>
            <?php
            $i++;
            }
            ?>
            
            
            <tr class="total">
                <td colspan='3'></td>
                <td><?php echo $lang['subtotal']; ?></td>
                <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_amnt']; ?></td>
            </tr>

            <?php if($inv['invoice']['inv_tax'] > 0) { ?>
              <tr class="total">
                <td colspan='3'></td>
                <td><?php echo $options['tax_name']; ?> (<?php echo $inv['invoice']['inv_tax_per']; ?>%)</td>
                <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_tax']; ?></td>
              </tr>
            <?php } ?>

            <?php if($inv['invoice']['inv_tax2'] > 0) { ?>
              <tr class="total">
                <td colspan='3'></td>
                <td><?php echo $options['tax2_name']; ?> (<?php echo $inv['invoice']['inv_tax2_per']; ?>%)</td>
                <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_tax2']; ?></td>
              </tr>
            <?php } ?>

            <tr class="total">
                <td colspan='3'></td>
                <td><?php echo $lang['total']; ?></td>
                <td><?php echo $options['currency_symbol']; ?> <?php echo $inv['invoice']['inv_total']; ?></td>
            </tr>
        </table>

        <p class="lead"><?php echo $lang['payments']; ?>:</p>

            <table width="100%" border='1' style="border-collapse: collapse;">
              <tr class="heading">
                <td><?php echo $lang['qty']; ?></td>
                <td><?php echo $lang['transactionid']; ?></td>
                <td><?php echo $lang['payment'].' '.$lang['method']; ?></td>
                <td><?php echo $lang['amount']; ?></td>
                <td><?php echo $lang['payment'].' '.$lang['date']; ?></td>
              </tr>

              <?php
              $i=1;
              foreach($inv['invoice_payments'] as $inv_pay)
              {
              ?>
                  <tr class="details">
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
            </table>
            <br><p><?php echo $options['invoice_footer']; ?></p>
    </div>
</body>
</html>