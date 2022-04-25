  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading/Breadcrumbs -->
    <h1 class="mt-4 mb-3">Blog</h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo $burl; ?>">Home</a>
      </li>
      <li class="breadcrumb-item active">Blog</li>
    </ol>

    <?php
    foreach($blog as $post)
    {
    ?>
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6">
            <a href="#">
    <img class="img-fluid rounded" src="<?php if(!empty($post['blog_image'])) { ?><?php echo base_url(); ?>assets/uploads/files/<?php echo $post['blog_image']; ?><?php } else { ?>http://placehold.it/750x300<?php } ?>" alt="">
            </a>
          </div>
          <div class="col-lg-6">
            <h2 class="card-title"><?php echo $post['blog_title'] ?></h2>
            <p class="card-text"><?php echo $post['blog_content'] ?></p>
          </div>
        </div>
      </div>
      <div class="card-footer text-muted">
        Posted on <?php echo $post['blog_date'] ?>
      </div>
    </div>
    <?php
    }
    ?>
  </div>
  <!-- /.container -->