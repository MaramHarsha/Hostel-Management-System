
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['invoices']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['invoices']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['invoices']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
              <table id="example1" class="table responsive table-bordered table-hover dt-responsive nowrap">
                <thead>
                <tr>
                    <th width="5%"><?php echo $lang['id']; ?></th>
                    <th width="25%"><?php echo $lang['invoice'].' '.$lang['category']; ?></th>
                    <th width="15%"><?php echo $lang['tenant'].' '.$lang['name']; ?></th>
                    <th width="15%"><?php echo $lang['status']; ?></th>
                    <th width="20%"><?php echo $lang['amount']; ?></th>
                    <th width="10%"><?php echo $lang['date']; ?></th>
                    <th width="15%"></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($allinvs as $inv)
                {
                ?>
                  <tr>
                  <td><?php echo $inv['inv_id']; ?></td>
                  <td><?php echo $inv['inv_for']; ?></td>
                  <td><?php echo $inv['ten_name']; ?></td>
                  <td>
                  <?php if($inv['inv_status'] == 'PARTIALLY PAID'){ ?>
                  <small class="badge badge-warning"><?php echo $inv['inv_status']; ?></small>
                  <?php } else if($inv['inv_status'] == 'UNPAID'){ ?>
                  <small class="badge badge-danger"><?php echo $inv['inv_status']; ?></small>
                  <?php } else { ?>
                  <small class="badge badge-success"><?php echo $inv['inv_status']; ?></small>
                  <?php } ?>
                  </td>
                  <td><?php echo $inv['inv_total']; ?></td>
                  <td><?php echo date('d M Y', strtotime($inv['inv_created'])); ?></td>
                  <td>
                  <a href="invoice/<?php echo $inv['inv_id']; ?>" title="<?php echo $lang['view'].' '.$lang['invoice']; ?>" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></a>
                  <a href="addpayment/<?php echo $inv['inv_id']; ?>" title="<?php echo $lang['add'].' '.$lang['payment']; ?>" class="btn btn-warning btn-xs"><i class="fas fa-plus-square"></i></a>
                  </td>
                  </tr>
                <?php
                }
                ?>
                </tbody>
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
		</div>
	</div>
	</section>
	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

