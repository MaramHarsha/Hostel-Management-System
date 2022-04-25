<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="DHPMS is a complete all in one Drom, Hostel & PG Management Software.">
  <meta name="author" content="DHPMS - Spykra Technologies">

  <title><?php echo $options['dhp_name']; ?> - DHPMS</title>

  <link href="<?php echo base_url(); ?>assets/frontend/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/frontend/css/scrolling-nav.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top" style="width:60%">
      <?php if(empty($options['app_logo'])) { ?>
        <?php echo $options['dhp_name']; ?>
      <?php } else { ?>
        <img src="<?php echo base_url(); ?>assets/usr_pics/<?php echo $options['app_logo']; ?>" width='25%'>
      <?php } ?>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
        <?php
        foreach($webpages as $webp)
        {
          if($webp['show_in_menu'] == 1)
          {
        ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#<?php echo slug($webp['web_page_name']); ?>"><?php echo $webp['web_page_name']; ?></a>
          </li>
        <?php
          }
        } 
        ?>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger btn btn-sm btn-success" href="<?php echo $burl; ?>admin/">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <header class="bg-primary text-white">
    <div class="container text-center">
      <h1>Welcome to <?php echo $options['dhp_name']; ?></h1>
      <p class="lead"><?php echo $options['address']; ?></p>
    </div>
  </header>
  
  <?php
  $i = 0;
  $class = '';
  foreach($webpages as $webp)
  {
    $class = ($i % 2 == 0) ? 'class="bg-light"' : '';
  ?>
      <section id="<?php echo slug($webp['web_page_name']); ?>" <?php echo $class; ?>>
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <?php echo $webp['web_page_content']; ?>
            </div>
          </div>
        </div>
      </section>
  <?php
  } 
  ?>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; <?php echo $options['dhp_name']; ?> - Powered by AdminLTE</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url(); ?>assets/frontend/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/frontend/js/scrolling-nav.js"></script>

</body>

</html>
