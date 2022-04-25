
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $lang['extraservices']; ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo $burl; ?>admin/dashboard"><?php echo $lang['home']; ?></a></li>
              <li class="breadcrumb-item active"><?php echo $lang['extraservices']; ?></li>
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
              <h3 class="card-title"><?php echo $lang['extraservices']; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
              <table id="example1" class="table responsive table-bordered table-hover dt-responsive nowrap">
                <thead>
                <tr>
                  <th width="5%"><?php echo $lang['id']; ?></th>
                  <th width="25%"><?php echo $lang['name']; ?></th>
                  <th width="35%"><?php echo $lang['details']; ?></th>
                  <th width="20%"><?php echo $lang['price']; ?></th>
                  <?php if($isadmin) { ?> <th><?php echo $lang['branch']; ?></th> <?php } ?>
                  <th width="15%"></th>
                </tr>
                </thead>
                <tbody>

                <?php
                foreach ($eslist as $es)
                {
                ?>
                  <tr>
                  <td><?php echo $es['id']; ?></td>
                  <td><?php echo $es['es_name']; ?></td>
                  <td><?php echo $es['es_details']; ?></td>
                  <td><?php echo $es['es_price']; ?></td>
                  <?php if($isadmin) { ?> <td><?php echo $es['branch']; ?></td> <?php } ?>
                  <td>
                  <a href="extraservices/edit/<?php echo $es['id']; ?>" title="<?php echo $lang['edit'].' '.$lang['extraservice']; ?>" class="btn btn-warning btn-xs"><i class="far fa-edit"></i></a>
                  <a href="JavaScript:Void(0);" onclick="return deletees('<?php echo $es['id']; ?>');" title="<?php echo $lang['delete'].' '.$lang['extraservice']; ?>" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                  <a href="extraservices/assign/<?php echo $es['id']; ?>" title="<?php echo $lang['assign'].' '.$lang['extraservice']; ?>" class="btn btn-primary btn-xs"><i class="far fa-plus-square"></i></a>
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

