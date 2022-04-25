    <?php
    if(!isset($extraserviceuid))
    {
        $extraserviceuid = 0;
    }
    ?>
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo ($extraserviceuid == 0) ? $lang['new'].' '.$lang['extraservice'] : $lang['edit'].' '.$lang['extraservice']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/extraservices"><?php echo $lang['extraservices']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo ($extraserviceuid == 0) ? $lang['new'].' '.$lang['extraservice'] : $lang['edit'].' '.$lang['extraservice']; ?></li>
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
              <h3 class="card-title"><?php echo ($extraserviceuid == 0) ? $lang['addnewes'] : $lang['edites']; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'addnewextraservice');
      echo form_open_multipart("admin/saveextraservice", $attributes); 
			?>
      <div class="card-body">
                        
				<input type="hidden" name="extrservice_uid" value="<?php echo $extraserviceuid; ?>">
				<div class="form-group row">
          <label for="extraservicename" class="col-sm-1 col-form-label"><?php echo $lang['name']; ?></label>

          <div class="col-sm-5">
            <input type="text" class="form-control" id="extraservicename" name="es_name"  value="<?php echo ($extraserviceuid == 0) ? set_value('es_name') : $esdata['es_name']; ?>">
            <?php echo form_error('es_name', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
          </div>
				  

          <label for="extraserviceprice" class="col-sm-1 col-form-label"><?php echo $lang['price']; ?></label>

          <div class="col-sm-5">
					  <div class="input-group">
						<div class="input-group-append"> <span class="input-group-text"><?php echo $options['currency_symbol']; ?></span> </div>
						<input type="text" class="form-control" id="extraserviceprice" name="es_price" value="<?php echo ($extraserviceuid == 0) ? set_value('es_price') : $esdata['es_price']; ?>">
					  </div>
            <?php echo form_error('es_price', '<div class="alert alert-danger alert-dismissible alertsm">', '</div>'); ?>
				  </div>
        </div>

        <?php if($isadmin) { ?>
            <div class="form-group row">
              <label for="esbranch" class="col-sm-1 col-form-label"><?php echo $lang['branch']; ?></label>
              <div class="col-sm-5">
                <select class="form-control smartselect" id="esbranch" name="es_branch">
                  <option value="">--<?php echo $lang['select'].' '.$lang['branch']; ?>--</option>
                  <?php
                  $branchid = ($extraserviceuid == 0) ? set_value('es_branch') : $esdata['es_branch'];
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
                *<?php echo $lang['branch_es_note']; ?>
              </div>
            </div>
        <?php } else { ?>
          <input type="hidden" name="es_branch" value="<?php echo $branchid; ?>">
        <?php } ?>

				<div class="form-group row">
          <label for="extraservicedetails" class="col-sm-1 col-form-label"><?php echo $lang['details']; ?></label>

          <div class="col-sm-11">
            <textarea class="form-control" id="extraservicedetails" name="es_details"><?php echo ($extraserviceuid == 0) ? set_value('es_details') : $esdata['es_details']; ?></textarea>
          </div>
        </div>
  </div>
			<div class="card-footer">
                <button type="submit" name="saveextraserviceant" class="btn btn-success"><?php echo $lang['save']; ?></button>
                <?php if($extraserviceuid == 0) { ?><button type="submit" name="saveandnewsaveextraserviceant" class="btn btn-primary"><?php echo $lang['savenn']; ?></button><?php } ?>
                <a href="<?php echo $burl; ?>admin/extraservices" class="btn btn-warning"><?php echo $lang['cancel']; ?></a>
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

