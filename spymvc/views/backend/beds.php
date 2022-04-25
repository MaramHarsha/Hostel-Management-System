
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['beds']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['beds']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['beds']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
              <table id="example1" class="table responsive table-bordered table-hover dt-responsive nowrap">
                <thead>
                <tr>
                  <th width="5%"><?php echo $lang['id']; ?></th>
                  <th width="20%"><?php echo $lang['name']; ?></th>
                  <th width="30%"><?php echo $lang['details']; ?></th>
				          <th width="15%"><?php echo $lang['room']; ?></th>
                  <th width="10%"><?php echo $lang['status']; ?></th>
                  <th width="05%"></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($bedlist as $bed)
                {
                ?>
                  <tr>
                  <td><?php echo $bed['bed_uid']; ?></td>
                  <td><?php echo $bed['bed_name']; ?></td>
                  <td><?php echo $bed['bed_details']; ?></td>
                  <td><?php echo $bed['room_name']; ?> | <?php echo $options['currency_symbol'].' '. $bed['room_price']; ?></td>
                  <td>
                  <?php if($bed['bed_status'] == 1){ ?>
                  <small class="badge badge-warning"><?php echo $lang['occupied']; ?></small>
                  <a href="JavaScript:Void(0);" onclick="return retractBed('<?php echo $bed['bed_uid']; ?>');" title="Retract bed" class="btn btn-primary btn-xs"><i class="far fa-minus-square"></i></a>
                  <?php } else { ?>
                  <small class="badge badge-success"><?php echo $lang['vecant']; ?></small>
                  <a href="beds/assign/<?php echo $bed['bed_uid']; ?>" title="Assign bed" class="btn btn-primary btn-xs"><i class="far fa-plus-square"></i></a>
                  <?php } ?>
                  </td>
                  <td>
                  <a href="beds/edit/<?php echo $bed['bed_uid']; ?>" title="<?php echo $lang['edit'].' '.$lang['bed']; ?>" class="btn btn-warning btn-xs"><i class="far fa-edit"></i></a>
                  <a href="JavaScript:Void(0);" onclick="return deletebed('<?php echo $bed['bed_uid']; ?>');" title="<?php echo $lang['delete'].' '.$lang['bed']; ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
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

