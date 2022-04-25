<div class="container">

    <h1 class="mt-5 mb-3">Gallery</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo $burl; ?>">Home</a>
      </li>
      <li class="breadcrumb-item active">Gallery</li>
    </ol>

    <div class="row">
      <div class="col-12">
        <div class="fotorama" data-nav="thumbs">
          <?php
            foreach($gallery as $gal)
            {
          ?>
            <img src="<?php echo base_url(); ?>assets/uploads/files/<?php echo $gal['gal_img']; ?>">
          <?php
            }
          ?>
        </div>
      </div>
    </div>
</div>