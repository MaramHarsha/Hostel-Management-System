<!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Room Structure</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/rooms"><?php echo $lang['rooms']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['room'].' '.$lang['structure']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['room'].' '.$lang['structure']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
                <div class="row">
                <?php
                foreach($bedsdata as $bed)
                {
                    $bdcolor = ($bed['bed_status'] == 1) ? 'bg-yellow' : 'bg-green';
                    $bdstatus = ($bed['bed_status'] == 1) ? 'Occupied' : 'Vecant';
                ?>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box <?php echo $bdcolor; ?>">
                        <span class="info-box-icon"><i class="fa fa-bed"></i></span>

                        <div class="info-box-content">
                        <span class="info-box-text">
                        <?php if($bed['bed_status'] == 1){ ?>
                        <small class="label bg-yellow"><?php echo $lang['occupied']; ?></small>
                        <a href="JavaScript:Void(0);" onclick="return retractBed('<?php echo $bed['bed_uid']; ?>');" title="<?php echo $lang['retract'].' '.$lang['bed']; ?>" class="btn btn-primary btn-xs"><i class="far fa-minus-square"></i></a>
                        <?php } else { ?>
                        <small class="label bg-green"><?php echo $lang['vecant']; ?></small>
                        <a href="../beds/assign/<?php echo $bed['bed_uid']; ?>" title="<?php echo $lang['assign'].' '.$lang['bed']; ?>" class="btn btn-primary btn-xs"><i class="far fa-plus-square"></i></a>
                        <?php } ?>
                        </span>
                        <span class="info-box-number"><?php echo $bed['bed_name']; ?></span>
                        <div class="progress">
                            <div class="progress-bar" class="width100"></div>
                        </div>
                            <span class="progress-description">
                            <?php echo $bed['bed_details']; ?>
                            </span>
                        </div>
                    </div>
                    </div>
                <?php
                }
                ?>
                </div>
            </div>
          <!-- /.box -->
		</div>
	</div>
	</section>
	<!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

