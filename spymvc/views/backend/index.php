
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><?php echo $lang['dashboard']; ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active"><?php echo $lang['dashboard']; ?></li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <?php if(isset($userdata) && $userdata['user_type'] == 'member') { ?>

        
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $options['currency_symbol']; ?> <?php echo amnt($usercounts['upaidamnt']); ?></h3>

              <p><?php echo $lang['total'].' '.$lang['balance'].' '.$lang['amount']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cash"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/tenant/<?php echo $userdata['user_id']; ?>/tenantview#allpayments" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $options['currency_symbol']; ?> <?php echo amnt($usercounts['paidamnt']); ?></h3>

              <p><?php echo $lang['total'].' '.$lang['paid'].' '.$lang['amount']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cash"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/tenant/<?php echo $userdata['user_id']; ?>/tenantview#allpayments" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $usercounts['upaidinv']; ?></h3>

              <p><?php echo $lang['total'].' '.$lang['unpaid'].' '.$lang['invoices']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-document"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/tenant/<?php echo $userdata['user_id']; ?>/tenantview#pendinginv" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $usercounts['alles']; ?></h3>

              <p><?php echo $lang['assigned'].' '.$lang['extraservices']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-pizza"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/tenant/<?php echo $userdata['user_id']; ?>/tenantview#alles" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->


      <?php } else { ?>
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $modulecounts['tenants']; ?></h3>

              <p><?php echo $lang['total'].' '.$lang['tenants']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-contacts"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/tenants" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $modulecounts['rooms']; ?></h3>

              <p><?php echo $lang['total'].' '.$lang['rooms']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-home"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/rooms" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $modulecounts['beds']; ?></h3>

              <p><?php echo $lang['total'].' '.$lang['beds']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-bed"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/beds" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $modulecounts['upaidinv']; ?></h3>

              <p><?php echo $lang['unpaid'].' '.$lang['invoices']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/invoices" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3><?php echo $options['currency_symbol']; ?> <?php echo amnt($modulecounts['upaidamnt']); ?></h3>

              <p><?php echo $lang['total'].' '.$lang['balance'].' '.$lang['amount']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cash"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/invoices" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $options['currency_symbol']; ?> <?php echo amnt($modulecounts['paidamnt']); ?></h3>

              <p><?php echo $lang['total'].' '.$lang['paid'].' '.$lang['amount']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cash"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/payments" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $options['currency_symbol']; ?> <?php echo amnt($modulecounts['thismonthincome']); ?></h3>

              <p><?php echo date("F"); ?> <?php echo $lang['income']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cash"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/payments" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $options['currency_symbol']; ?> <?php echo amnt($modulecounts['thismonthexpense']); ?></h3>

              <p><?php echo date("F"); ?> <?php echo $lang['expense']; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-cash"></i>
            </div>
            <a href="<?php echo $burl; ?>admin/expenses" class="small-box-footer"><?php echo $lang['viewmore']; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <?php } ?>

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

