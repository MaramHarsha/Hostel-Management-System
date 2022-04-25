
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['allrequests']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['allrequests']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['allrequests']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <table id="example1" class="table responsive table-bordered table-hover dt-responsive nowrap">
                    <thead>
                    <tr>
                    <th width="5%"><?php echo $lang['id']; ?></th>
                    <th width="20%"><?php echo $lang['request_type']; ?></th>
                    <th width="30%"><?php echo $lang['tenant']; ?></th>
                    <th width="15%"><?php echo $lang['bed']; ?></th>
                    <th width="10%"><?php echo $lang['room']; ?></th>
                    <th width="10%"><?php echo $lang['extraservice']; ?></th>
                    <th width="10%"><?php echo $lang['requestdate']; ?></th>
                    <th width="10%"><?php echo $lang['status']; ?></th>
                    <th width="05%"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($requests as $req)
                    {
                    ?>
                    <tr>
                    <td><?php echo $req['id']; ?></td>
                    <td><?php echo $req['request_type']; ?></td>
                    <td><?php echo $req['request_type']; ?></td>
                    <td><?php echo (isset($req['bed'])) ? $req['bed']['bed_name'] : ''; ?></td>
                    <td><?php echo (isset($req['room'])) ? $req['room']['room_name'] : ''; ?></td>
                    <td><?php echo (isset($req['es'])) ? $req['es']['es_name'] : ''; ?></td>
                    <td><?php echo $req['request_create_date']; ?></td>
                    <td><?php echo $req['request_status']; ?></td>
                    <td>
                    <?php if($userdata['user_type'] == 'admin' || $userdata['user_type'] == 'branch admin') { ?>
                    <?php if(isset($req['bed'])) { ?>
                    <a href="beds/assign/<?php echo $req['request_bed_uid']; ?>/<?php echo $req['request_ten_uid']; ?>/<?php echo $req['id']; ?>" title="<?php echo $lang['approverequest']; ?>" class="btn btn-success btn-xs"><i class="fas fa-check"></i></a>
                    <?php } else { ?>
                    <a href="extraservices/assign/<?php echo $req['request_es_uid']; ?>/<?php echo $req['request_ten_uid']; ?>/<?php echo $req['id']; ?>" title="<?php echo $lang['approverequest']; ?>" class="btn btn-success btn-xs"><i class="fas fa-check"></i></a>
                    <?php } ?>
                    <a href="rejectrequest/<?php echo $req['id']; ?>" title="<?php echo $lang['rejectrequest']; ?>" class="btn btn-danger btn-xs"><i class="fas fa-times"></i></a>
                    <?php } ?>
                    </td>
                    </tr>
                    <?php
                    }
                    ?>

                </tbody>
                    
              </table>
			</div>
          </div>
          <!-- /.box -->
		</div>
	</div>
	</section>
	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

