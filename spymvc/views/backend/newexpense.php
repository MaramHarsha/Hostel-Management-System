    <?php
    if(!isset($expenseuid))
    {
        $expenseuid = 0;
    }
    ?>
  <!-- content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo ($expenseuid == 0) ? 'New Expense' : 'Edit Expense'; ?>
        <small><?php echo ($expenseuid == 0) ? 'Add New Expense' : 'Edit Existing Expense'; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="beds"><i class="fa fa-home"></i> Expenses
		</a></li>
        <li class="active"><?php echo ($expenseuid == 0) ? 'New Expense' : 'Edit Expense'; ?></li>
      </ol>
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo ($expenseuid == 0) ? 'Add New Expense' : 'Edit Expense Information'; ?></h3>
            </div>
            <!-- /.box-header -->
			<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'addnewexpense');
                        if($expenseuid == 0)
                            echo form_open_multipart("admin/addexpense", $attributes); 
                        else
                            echo form_open_multipart("admin/updateexpense", $attributes);
			?>
            <div class="box-body">
			<?php 
			echo validation_errors(); 
			?>
                        
				<input type="hidden" name="expense_uid" value="<?php echo $expenseuid; ?>">
				<div class="form-group">
                  
				  <label for="room" class="col-sm-1 control-label">Expense Type</label>

                  <div class="col-sm-5">
					<select class="form-control">
						<option>option 1</option>
						
					</select>
				  </div><label for="price" class="col-sm-1 control-label">Price</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="price" name="price"value="<?php echo ($expenseuid == 0) ? set_value('price') : $beddata['price']; ?>">
                  </div> 
                </div>
				
				<div class="form-group">
                  <label for="date" class="col-sm-1 control-label">Date</label>

                  <div class="col-sm-5">
                    <input type="text" class="form-control" id="date" name="date"  value="<?php echo ($expenseuid == 0) ? set_value('date') : $beddata['date']; ?>">
                  </div>
				  
				  <label for="status" class="col-sm-1 control-label">Status</label>

                  <div class="col-sm-5">
					<select class="form-control">
						<option>option 1</option>
						
					</select>
				  </div>
                </div>
				<div class="form-group">
                  <label for="expensedetails" class="col-sm-1 control-label">Details</label>

                  <div class="col-sm-5">
                    <textarea class="form-control" id="expensedetails" name="extraservice_details"><?php echo ($expenseuid == 0) ? set_value('expense_details') : $roomdata['expense_details']; ?></textarea>
                  </div>
                </div>
			</div>
			<div class="box-footer">
                <button type="submit" name="savebedant" class="btn btn-success">Save</button>
                <?php if($expenseuid == 0) { ?><button type="submit" name="saveandnewbedant" class="btn btn-primary">Save & New</button><?php } ?>
                <a href="<?php echo $burl; ?>admin/rooms" class="btn btn-warning">Cancel</a>
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

 