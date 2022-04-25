<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/MercuryGMS.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/iCheck/all.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/morris/morris.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/datepicker/datepicker3.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/select2/select2.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/select2/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <?php
  if(isset($gc))
  {
  foreach($gc->css_files as $file): ?>
      <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
      
  <?php endforeach; 
  }
  ?>
  
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/backend/dist/js/webcam.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <script src="<?php echo base_url(); ?>assets/backend/plugins/sweetalert/sweetalert2.min.js"></script>
</head>
<body class="hold-transition skin-black-light layout-fixed sidebar-mini text-sm">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <li class="d-none d-sm-block appname"><?php echo $options['dhp_name']; ?></li>
          <?php if(!empty($branch)) { ?><li class="d-none d-sm-block appname"><b><?php echo $lang['branch']; ?>: </b><?php echo $branch['branch_name']; ?></li><?php } ?>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
      <?php if(isset($userdata) && $userdata['user_type'] == 'admin') { ?>
        <li class="nav-item dropdown position-static">
          <a class="nav-link" data-toggle="dropdown" href="#" title="<?php echo $lang['branches']; ?>">
          <i class="fas fa-code-branch"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><?php echo $lang['branches']; ?></span>
            <?php foreach($branches as $branch) { ?>
              <div class="dropdown-divider"></div>
                <a href="<?php echo $burl; ?>admin/selectbranch/<?php echo $branch['id']; ?>" class="dropdown-item"><?php echo $branch['branch_name']; ?>
                <?php if(isset($userdata['branch']) && $userdata['branch']==$branch['id']) { ?>
                <i class="fas fa-check mr-2 float-right"></i>
                <?php } ?>
              </a>
            <?php } ?>
          </div>
        </li>
        <?php } ?>
        
        <li class="nav-item dropdown position-static">
          <a class="nav-link" data-toggle="dropdown" href="#" title="<?php echo $lang['languages']; ?>">
          <i class="fas fa-language"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header"><?php echo $lang['languages']; ?></span>
            <?php foreach($languages as $elang) { ?>
              <div class="dropdown-divider"></div>
                <a href="<?php echo $burl; ?>admin/lang/<?php echo strtolower($elang['lang_name']); ?>" class="dropdown-item"><?php echo $elang['lang_name']; ?>
                <?php if($language == strtolower($elang['lang_name'])) { ?>
                <i class="fas fa-check mr-2 float-right"></i>
                <?php } ?>
              </a>
            <?php } ?>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="dropdown" href="JavaScript:Void(0);" id="toggleFullscreen" title="<?php echo $lang['fullscreen']; ?>"><i class="fas fa-compress"></i></a>
        </li>
        

        <li class="nav-item dropdown position-static">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i> <?php echo $userdata['user_name']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">
              <img src="<?php echo base_url(); ?>assets/usr_pics/<?php echo $userdata['profphoto']; ?>" class="img-circle width50" alt="User Image">
              <p>
                <?php echo $userdata['user_name']; ?><br>
                <small><?php echo $userdata['user_email']; ?></small>
              </p>
            </span>
            <div class="dropdown-divider"></div>
            <a href="<?php echo $burl; ?>admin/changepassword" class="dropdown-item">
            <?php echo $lang['changepassword']; ?>
            </a>
            <div class="dropdown-divider"></div>
            <a href="<?php echo $burl; ?>admin/logout" class="dropdown-item">
            <?php echo $lang['signout']; ?>
            </a>
          </div>
        </li>
      </ul>
    </nav>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar elevation-4 sidebar-light-indigo">
    <a href="<?php echo $burl; ?>admin/dashboard" class="brand-link">
    <img src="<?php echo base_url(); ?>assets/backend/dist/img/dhpms_logo.png" alt="DHPMS Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">JKLU HRBS</span>
    </a>
    <div class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item"><a href="<?php echo $burl; ?>admin/dashboard" class="nav-link <?php if($cpage == 'dashboard') echo"active"; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i><p><?php echo $lang['dashboard']; ?></p></a>
          </li>
          <?php if(isset($userdata) && $userdata['user_type'] == 'member') { ?>

            <li class="nav-item"><a href="<?php echo $burl; ?>admin/tenant/<?php echo $userdata['user_id']; ?>/tenantview" class="nav-link <?php if($cpage == 'tenants') echo"active"; ?>">
              <i class="nav-icon fas fa-user"></i><p><?php echo $lang['myprofile']; ?></p></a>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link <?php if($cpage == 'makerequest') echo"active"; ?>">
                <i class="nav-icon fas fa-plus"></i><p><?php echo $lang['makerequest']; ?><i class="right fas fa-angle-left"></i></p></a>

                <ul class="nav nav-treeview">
                  <li class="nav-item"><a href="<?php echo $burl; ?>admin/requestbed" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['requestbed']; ?></p></a></li>
                  <li class="nav-item"><a href="<?php echo $burl; ?>admin/requestes" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['requestes']; ?></p></a></li>
                  <li class="nav-item"><a href="<?php echo $burl; ?>admin/allrequests" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['allrequests']; ?></p></a></li>
                </ul>
            </li>

            <li class="nav-item"><a href="<?php echo $burl; ?>admin/makepayment" class="nav-link <?php if($cpage == 'payments') echo"active"; ?>">
              <i class="nav-icon fas fa-money-check-alt"></i><p><?php echo $lang['make'].' '.$lang['payment']; ?></p></a>
            </li>

            <li class="nav-item"><a href="<?php echo $burl; ?>admin/notices" class="nav-link <?php if($cpage == 'notices') echo"active"; ?>">
              <i class="nav-icon fas fa-thumbtack"></i><p><?php echo $lang['notices']; ?></p></a>
            </li>

            <li class="nav-item"><a href="<?php echo $burl; ?>admin/events" class="nav-link <?php if($cpage == 'events') echo"active"; ?>">
              <i class="nav-icon far fa-calendar-alt"></i><p><?php echo $lang['events']; ?></p></a>
            </li>

          <?php } else { ?>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'tenants' || $cpage == 'newtenant') echo"active"; ?>">
              <i class="nav-icon fas fa-users"></i><p><?php echo $lang['tenants']; ?><i class="right fas fa-angle-left"></i><span class="badge badge-info right"><?php echo $modulecounts['tenants']; ?></span></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/tenants" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['manage'].' '.$lang['tenants']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/tenants/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['new'].' '.$lang['tenant']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'rooms' || $cpage == 'newroom') echo"active"; ?>">
              <i class="nav-icon fas fa-home"></i><p><?php echo $lang['rooms']; ?><i class="right fas fa-angle-left"></i><span class="badge badge-info right"><?php echo $modulecounts['rooms']; ?></span></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/rooms" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['manage'].' '.$lang['rooms']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/rooms/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['new'].' '.$lang['room']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'beds' || $cpage == 'newbed') echo"active"; ?>">
              <i class="nav-icon fas fa-bed"></i><p><?php echo $lang['beds']; ?><i class="right fas fa-angle-left"></i><span class="badge badge-info right"><?php echo $modulecounts['beds']; ?></span></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/beds" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['manage'].' '.$lang['beds']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/beds/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['new'].' '.$lang['bed']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'extraservices' || $cpage == 'newextraservice') echo"active"; ?>">
              <i class="nav-icon fas fa-external-link-alt"></i><p><?php echo $lang['extraservices']; ?><i class="right fas fa-angle-left"></i></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/extraservices" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['manage'].' '.$lang['extraservices']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/extraservices/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['new'].' '.$lang['extraservices']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'invoices' || $cpage == 'payments' || $cpage == 'expenses') echo"active"; ?>">
              <i class="nav-icon fas fa-money-check-alt"></i><p><?php echo $lang['accounting']; ?><i class="right fas fa-angle-left"></i></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/invoices" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['view'].' '.$lang['invoices']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/newinvoice" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['generate'].' '.$lang['invoices']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/payments" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['view'].' '.$lang['payments']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/payments/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['add'].' '.$lang['payment']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/expenses" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['view'].' '.$lang['expenses']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/expenses/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['add'].' '.$lang['expense']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'report') echo"active"; ?>">
              <i class="nav-icon fas fa-file-alt"></i><p><?php echo $lang['reports']; ?><i class="right fas fa-angle-left"></i></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/reports/income" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['income'].' '.$lang['report']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/reports/expense" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['expense'].' '.$lang['report']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'notices') echo"active"; ?>">
              <i class="nav-icon fas fa-thumbtack"></i><p><?php echo $lang['notices']; ?><i class="right fas fa-angle-left"></i></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/notices" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['manage'].' '.$lang['notices']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/notices/add" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['new'].' '.$lang['notice']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item"><a href="<?php echo $burl; ?>admin/allrequests" class="nav-link <?php if($cpage == 'makerequest') echo"active"; ?>">
              <i class="nav-icon fas fa-plus"></i><p><?php echo $lang['allrequests']; ?></p></a>
          </li>

          <?php if(isset($userdata) && $userdata['user_type'] == 'admin') { ?>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'settings') echo"active"; ?>">
              <i class="nav-icon fas fa-sliders-h"></i><p><?php echo $lang['settings']; ?><i class="right fas fa-angle-left"></i></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/branches" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['branches']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/expensecat" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['expense'].' '.$lang['categories']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/complaintcat" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['complaint'].' '.$lang['categories']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/emailtpl" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['email'].' '.$lang['templates']; ?></p></a></li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link <?php if($cpage == 'website') echo"active"; ?>">
              <i class="nav-icon far fa-window-maximize"></i><p><?php echo $lang['managewebsite']; ?><i class="right fas fa-angle-left"></i></p></a>

              <ul class="nav nav-treeview">
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/webpages" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['website'].' '.$lang['pages']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/blog" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['blog']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/gallery" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['gallery']; ?></p></a></li>
                <li class="nav-item"><a href="<?php echo $burl; ?>admin/filemanager" class="nav-link"><i class="far fa-circle nav-icon"></i> <p><?php echo $lang['filemanager']; ?></p></a></li>
              </ul>
          </li>
          
          <li class="nav-item"><a href="<?php echo $burl; ?>admin/events" class="nav-link <?php if($cpage == 'events') echo"active"; ?>">
            <i class="nav-icon far fa-calendar-alt"></i><p><?php echo $lang['events']; ?></p></a>
          </li>

          <li class="nav-item"><a href="<?php echo $burl; ?>admin/users" class="nav-link <?php if($cpage == 'users') echo"active"; ?>">
            <i class="nav-icon fas fa-user"></i><p><?php echo $lang['users']; ?></p></a>
          </li>

          
          <li class="nav-item"><a href="<?php echo $burl; ?>admin/configurations" class="nav-link <?php if($cpage == 'configurations') echo"active"; ?>">
            <i class="nav-icon fas fa-cogs"></i><p><?php echo $lang['configurations']; ?></p></a>
          </li>
          <?php } ?>
		
        <?php } ?>

        <li class="nav-item"><a href="<?php echo $burl; ?>admin/complaints" class="nav-link <?php if($cpage == 'complaints') echo"active"; ?>">
            <i class="nav-icon fas fa-ticket-alt"></i><p><?php echo $lang['complaints']; ?></p></a>
        </li>

        <?php if(isset($userdata) && $userdata['user_type'] != 'member') { ?>
        <li class="nav-item"><a href="https://spykra.com/docs/dhpms/" target="_blank" class="nav-link">
            <i class="nav-icon fas fa-book"></i><p><?php echo $lang['documentation']; ?></p></a>
        </li>

        <li class="nav-item"><a href="<?php echo $burl; ?>admin/about" class="nav-link <?php if($cpage == 'aboutus') echo"active"; ?>">
            <i class="nav-icon fas fa-info-circle"></i><p><?php echo $lang['aboutus']; ?></p></a>
        </li>
        <?php } ?>

      </ul>
    </nav>
  </aside>


<!-- Modals -->
<div id="aboutModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">About Us</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text_center">Calgary Hostel Management System</h3><hr/>
        <p class="floatright"><?php echo $lang['version']; ?>: <b><?php echo $options['app_version']; ?></b></p><br><br>
        &copy; A Product of Spykra Technologies.<br>
        <img src="<?php echo base_url(); ?>assets/backend/dist/img/spykra.png" class="text_center width20">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $lang['close']; ?></button>
      </div>
    </div>

  </div>
</div>
