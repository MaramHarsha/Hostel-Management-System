
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['tenants']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['tenants']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['tenants']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
              <table id="example1" class="table responsive table-bordered table-hover dt-responsive nowrap">
                <thead>
                <tr>
                  <th><?php echo $lang['id']; ?></th>
                  <th width="10%"><?php echo $lang['photo']; ?></th>
                  <th width="10%"><?php echo $lang['name']; ?></th>
                  <th><?php echo $lang['gender']; ?></th>
                  <?php if($isadmin) { ?> <th><?php echo $lang['branch']; ?></th> <?php } ?>
                  <th width="20%"><?php echo $lang['contact']; ?></th>
                  <th><?php echo $lang['roomnbed']; ?></th>
                  <th><?php echo $lang['status']; ?></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
				<?php
				foreach ($tenlist as $tenant)
				{
				?>
                <tr>
					<td><?php echo $tenant['ten_uid']; ?></td>
					<td><img src="<?php echo base_url(); ?>assets/usr_pics/<?php echo $tenant['ten_pic']; ?>" class="img-circle memlistimg" alt="<?php echo $tenant['ten_name']; ?>"></td>
					<td><?php echo $tenant['ten_name']; ?></td>
					<td><?php if($tenant['ten_gender'] == 'M') { ?><i class="fa fa-mars malecolor"></i>Male <?php } else { ?><i class="fa fa-venus femalecolor"></i>Female <?php } ?></td>
          <?php if($isadmin) { ?> <td><?php echo $tenant['branch']; ?></td> <?php } ?>
          <td>
					<b>Email</b>: <?php echo $tenant['ten_email']; ?><br>
					<b>Mobile</b>: <?php echo $tenant['ten_contact']; ?><br>
					<b>Address</b>: <?php echo $tenant['ten_address']; ?><br>
					</td>
					<td>
					<b>Room</b>: <?php echo $tenant['room']; ?><br>
					<b>Bed</b>: <?php echo $tenant['bed']; ?><br>
					</td>
					<td>
					<?php if($tenant['ten_isactive'] == 1){ ?>
					<small class="badge badge-success"><?php echo $lang['active']; ?></small>
					<?php } else { ?>
					<small class="badge badge-warning"><?php echo $lang['inactive']; ?></small>
					<?php } ?>
					</td>
					<td>
					<a href="tenant/<?php echo $tenant['ten_uid']; ?>" class="btn btn-primary btn-xs" title="<?php echo $lang['view_tenant']; ?>"><i class="fas fa-eye"></i></a>
					<a href="edittenant/<?php echo $tenant['ten_uid']; ?>" class="btn btn-warning btn-xs" title="<?php echo $lang['edit'].' '.$lang['tenant']; ?>"><i class="far fa-edit"></i></a>
					<a href="JavaScript:Void(0);" onclick="return deletetenant('<?php echo $tenant['ten_uid']; ?>');" class="btn btn-danger btn-xs" title="<?php echo $lang['delete'].' '.$lang['tenant']; ?>"><i class="fas fa-trash-alt"></i></a>
            <?php if($tenant['room'] != 'N/A' && $tenant['bed'] != 'N/A'){ ?>
              <a href="JavaScript:Void(0);" onclick="return retractTenBed('<?php echo $tenant['ten_uid']; ?>');" title="<?php echo $lang['retract'].' '.$lang['bed']; ?>" class="btn btn-primary btn-xs"><i class="far fa-minus-square"></i></a>
            <?php } else { ?>
              <a href="tenants/assignbed/<?php echo $tenant['ten_uid']; ?>" title="<?php echo $lang['assign'].' '.$lang['bed']; ?>" class="btn btn-primary btn-xs"><i class="far fa-plus-square"></i></a>
            <?php } ?>
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

