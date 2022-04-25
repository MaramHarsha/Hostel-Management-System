

  <header>
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
          <?php
          $i = 0;
            foreach($gallery as $gal)
            {
              if($gal['gal_slider_img'] == 1)
              {
          ?>
          <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>" class="<?php if($i==0) echo'active'; ?>"></li>
          <?php
            $i++;
            }
          } 
        ?>
      </ol>
      <div class="carousel-inner" role="listbox">

        <?php
        $i = 1;
          foreach($gallery as $gal)
          {
            if($gal['gal_slider_img'] == 1)
            {
          ?>
            <div class="carousel-item <?php if($i==1) echo'active'; ?>" style="background-image: url('<?php echo base_url(); ?>assets/uploads/files/<?php echo $gal['gal_img']; ?>')">
              <div class="carousel-caption d-none d-md-block">
                <h3><?php echo $gal['gal_title']; ?></h3>
              </div>
            </div>
          <?php
            $i++;
            }
          } 
        ?>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
  </header>

  <div class="container">

    <h1 class="my-4">Welcome to <?php echo $options['dhp_name']; ?></h1>

    <div class="row">
      <div class="col-12 mb-4">
          <?php echo $webpage['web_page_content']; ?>
      </div>
    </div>

  </div>

