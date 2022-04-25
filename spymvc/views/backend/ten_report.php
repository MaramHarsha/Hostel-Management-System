<html>
    <head>
    <?php
    foreach($gc->css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/dist/css/MercuryGMS.css">
    <?php foreach($gc->js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    </head>
    <body>
    <?php echo $gc->output; ?>
    </body>
</html>