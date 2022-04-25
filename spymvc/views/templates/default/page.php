<div class="container">

    <h1 class="mt-5 mb-3"><?php echo $webpage['web_page_name']; ?></h1>

    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo $burl; ?>">Home</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $webpage['web_page_name']; ?></li>
    </ol>

    <div class="row">
      <div class="col-12">
        <?php echo $webpage['web_page_content']; ?>
      </div>
    </div>
</div>