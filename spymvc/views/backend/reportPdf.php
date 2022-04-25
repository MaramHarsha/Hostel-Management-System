<html>
    <body>
    <!-- Main content -->
    <section class="invoice">

        <h2 class="page-header">
        <?php echo $options['dhp_name']; ?>
        </h2>
        <small><?php echo $report_name; ?><br><br>
        <?php
        if(!empty($from_date)) { echo date("d M Y", strtotime($from_date)); }
        if(!empty($to_date)) { echo ' To '.date("d M Y", strtotime($to_date)); }
        ?>
        </small>
        <hr/>
 
      <div class="row">
        <?php
        if($report == 'income') {
        ?>
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" border="1" width="100%">
                <thead>
                <tr>
                <th><?php echo $lang['serial']; ?> #</th>
                <th><?php echo $lang['tenant'].' '.$lang['name']; ?></th>
                <th><?php echo $lang['invoiceid']; ?></th>
                <th><?php echo $lang['transactionid']; ?></th>
                <th class="text_right"><?php echo $lang['amount']; ?></th>
                <th><?php echo $lang['method']; ?></th>
                <th><?php echo $lang['date']; ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    $amnttotal = 0;
                    foreach($incomereport as $inc)
                    {
                        $amnttotal += $inc['payment_amnt'];
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $inc['ten_name']; ?></td>
                            <td><?php echo $inc['inv_id']; ?></td>
                            <td><?php echo $inc['payment_trans_id']; ?></td>
                            <td class="text_right"><?php echo $options['currency_symbol']; ?> <?php echo amnt($inc['payment_amnt']); ?></td>
                            <td><?php echo $inc['payment_method']; ?></td>
                            <td><?php echo date("d M Y H:i:s", strtotime($inc['payment_date'])); ?></td>
                        </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <th colspan='4'><?php echo $lang['total']; ?></th>
                    <th class="text_right"><b><?php echo $options['currency_symbol']; ?> <?php echo amnt($amnttotal); ?></b></th>
                    <th colspan='2'></th>
                </tfoot>
            </table>
            </div>
        <?php } ?>


        <?php
        if($report == 'expense') {
        ?>
            <div class="col-xs-12 table-responsive">
            <table class="table table-striped" border="1" width="100%">
                <thead>
                <tr>
                <th><?php echo $lang['serial']; ?> #</th>
                <th><?php echo $lang['expense'].' '.$lang['name']; ?></th>
                <th><?php echo $lang['category']; ?></th>
                <th><?php echo $lang['customer']; ?></th>
                <th class="text_right"><?php echo $lang['amount']; ?></th>
                <th><?php echo $lang['method']; ?></th>
                <th><?php echo $lang['refno']; ?></th>
                <th><?php echo $lang['date']; ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $i=1;
                    $amnttotal = 0;
                    foreach($expensereport as $exp)
                    {
                        $amnttotal += $exp['exp_amnt'];
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $exp['exp_name']; ?></td>
                            <td><?php echo $exp['exp_cat_name']; ?></td>
                            <td><?php echo $exp['exp_customer_details']; ?></td>
                            <td class="text_right"><?php echo $options['currency_symbol']; ?> <?php echo amnt($exp['exp_amnt']); ?></td>
                            <td><?php echo $exp['exp_payment_method']; ?></td>
                            <td><?php echo $exp['exp_ref_no']; ?></td>
                            <td><?php echo date("d M Y", strtotime($exp['exp_date'])); ?></td>
                        </tr>
                    <?php
                    $i++;
                    }
                    ?>
                </tbody>
                <tfoot>
                    <th colspan='4'><?php echo $lang['total']; ?></th>
                    <th class="text_right"><b><?php echo $options['currency_symbol']; ?> <?php echo amnt($amnttotal); ?></b></th>
                    <th colspan='2'></th>
                </tfoot>
            </table>
            </div>
        <?php } ?>

      </div>
    </section>
    </body>
</html>

