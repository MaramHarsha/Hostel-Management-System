<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $title; ?></title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url(); ?>assets/templates/<?php echo $options['web_template']; ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url(); ?>assets/templates/<?php echo $options['web_template']; ?>/vendor/fotorama/fotorama.css" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="<?php echo base_url(); ?>assets/templates/<?php echo $options['web_template']; ?>/css/modern-business.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">

      <a class="navbar-brand" href="<?php echo $burl; ?>">

      <?php if(empty($options['app_logo'])) { ?>
        <?php echo $options['dhp_name']; ?>
      <?php } else { ?>
        <img src="<?php echo base_url(); ?>assets/usr_pics/<?php echo $options['app_logo']; ?>" width='25%'>
      <?php } ?>

      </a>

      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $burl; ?>">Home</a>
          </li>

          <?php
          foreach($webpages as $webp)
          {
            if($webp['show_in_menu'] == 1 && slug($webp['web_page_name']) != 'home-page')
            {
          ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $burl; ?><?php echo slug($webp['web_page_name']); ?>"><?php echo $webp['web_page_name']; ?></a>
            </li>
          <?php
            }
          } 
          ?>

          <li class="nav-item">
            <a class="nav-link" href="<?php echo $burl; ?>gallery">Gallery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $burl; ?>blog">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $burl; ?>contact">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo $burl; ?>admin/login">Login</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>