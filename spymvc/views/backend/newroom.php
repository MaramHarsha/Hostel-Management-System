    <?php
    if(!isset($roomuid))
    {
        $roomuid = 0;
    }
    ?>
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ($roomuid == 0) ? $lang['new'].' '.$lang['room'] : $lang['edit'].' '.$lang['room']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/rooms"><?php echo $lang['rooms']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo ($roomuid == 0) ? $lang['new'].' '.$lang['room'] : $lang['edit'].' '.$lang['room']; ?></li>
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
              <h3 class="card-title"><?php echo ($roomuid == 0) ? $lang['addnewroom'] : $lang['editroom']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'addnewroom');
      echo form_open_multipart("admin/saveroom", $attributes); 
			?>
            <div class="card-body">
                        
				<input type="hidden" name="room_uid" value="<?php echo $roomuid; ?>">
				<div class="form-group row">
          <label for="roomname" class="col-sm-1 col-form-label"><?php echo $lang['name']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="roomname" name="room_name" placeholder="<?php echo $lang['name']; ?>" value="<?php echo ($roomuid == 0) ? set_value('room_name') : $roomdata['room_name']; ?>">
            <?php echo form_error('room_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>
				  
				  <label for="roomprice" class="col-sm-1 col-form-label"><?php echo $lang['price']; ?></label>

          <div class="col-sm-5">
					  <div class="input-group">
            <div class="input-group-append"> <span class="input-group-text"><?php echo $options['currency_symbol']; ?></span> </div>
						<input type="text" class="form-control" id="roomprice" name="room_price" placeholder="<?php echo $lang['roomprice']; ?>" value="<?php echo ($roomuid == 0) ? set_value('room_price') : $roomdata['room_price']; ?>">
					  </div>
            <?php echo form_error('room_price', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
				  </div>
        </div>

        <?php if($isadmin) { ?>
            <div class="form-group row">
              <label for="roombranch" class="col-sm-1 col-form-label"><?php echo $lang['branch']; ?></label>
              <div class="col-sm-5">
                <select class="form-control smartselect" id="roombranch" name="room_branch">
                  <?php
                  $branchid = ($roomuid == 0) ? set_value('room_branch') : $roomdata['room_branch'];
                  foreach($branches as $branch)
                  {
                  ?>
                      <option value="<?php echo $branch['id']; ?>" <?php if($branchid == $branch['id']) { echo 'selected'; } ?>><?php echo $branch['branch_name']; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-6">
              </div>
            </div>
        <?php } else { ?>
          <input type="hidden" name="room_branch" value="<?php echo $branchid; ?>">
        <?php } ?>
				
				
				<div class="form-group row">
				  <label for="roomdetails" class="col-sm-1 col-form-label"><?php echo $lang['details']; ?></label>

                  <div class="col-sm-11">
                    <textarea class="form-control" id="roomdetails" name="room_details"><?php echo ($roomuid == 0) ? set_value('room_details') : $roomdata['room_details']; ?></textarea>
                    <?php echo form_error('room_details', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
                  </div>
                </div>
				
			</div>
			<div class="card-footer">
                <button type="submit" name="saveroomant" class="btn btn-success"><?php echo $lang['save']; ?></button>
                <?php if($roomuid == 0) { ?><button type="submit" name="saveandnewroomant" class="btn btn-primary"><?php echo $lang['savenn']; ?></button><?php } ?>
                <a href="<?php echo $burl; ?>admin/rooms" class="btn btn-warning"><?php echo $lang['cancel']; ?></a>
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

