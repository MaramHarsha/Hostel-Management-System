<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/MercuryGMS.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page text-sm">
<div class="row">
<div class="col-lg-8 col-md-8 col-sm-6 loginbgcol1 d-none d-sm-block">
<img src="<?php echo base_url(); ?>assets/backend/dist/img/login_bg2.svg" class="loginbg">
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 loginbgcol2 h-100 d-flex justify-content-center align-items-center">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Calgary </b>HMS</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
  <div class="card-body login-card-body">
  <h4 class="text_center"><?php echo $options['dhp_name']; ?></h4>
    <p class="login-box-msg" id="loginmsg"><?php echo $lang['reg_title']; ?></p>
			<?php 
			echo validation_errors('<p class="alert alert-danger">'); 
            ?>
            <?php
			if($errmsg == 'success1')
			{
				echo"<p class='alert alert-success'>".$lang['registration_success_msg']."</p>";
			}
			?>

    <?php
    $attributes = array('id' => 'register');
    echo form_open_multipart("admin/signup", $attributes); 
    ?>
    <div class="input-group mb-3">
        <select class="form-control smartselect" id="tenantbranch" name="ten_branch">
            <option value="">--<?php echo $lang['select'].' '.$lang['branch']; ?>--</option>
            <?php
            $branchid = ($tenuid == 0) ? set_value('ten_branch') : $tendata['ten_branch'];
            foreach($branches as $branch)
            {
            ?>
                <option value="<?php echo $branch['id']; ?>"><?php echo $branch['branch_name']; ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="input-group mb-3">
        <input type="text" name="user_name" class="form-control" placeholder="<?php echo $lang['name']; ?>">
      </div>
      <div class="input-group mb-3">
        <input type="email" name="user_email" class="form-control" placeholder="<?php echo $lang['email']; ?>">
      </div>
      <div class="input-group mb-3">
        <input type="password" name="user_password" class="form-control" placeholder="<?php echo $lang['password']; ?>">
      </div>
      <div class="row">

        <!-- /.col -->
        <div class="col-12" class="floatright">
          <button type="submit" class="btn btn-primary btn-block"><?php echo $lang['register']; ?></button>
        </div>
        <!-- /.col -->
      </div>
    </form>

<?php
if(isset($options['enable_registration']) && $options['enable_registration'] == true)
{
?>
    <div class="social-auth-links text-center">
      <p>- OR -</p>
        <div class="col-12" class="floatright">
          <a href="<?php echo $burl; ?>admin/login" class="btn btn-success btn-block text-white"><?php echo $lang['signin']; ?></a>
        </div>
    </div>
<?php
}
?>
  </div>
</div>
  <!-- /.login-box-body -->

</div>
</div>
<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/backend/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>assets/backend/plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/dist/js/MercuryGMS.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
