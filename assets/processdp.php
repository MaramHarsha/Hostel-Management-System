<?php
$filename = $_GET['filename'];
$format = $_GET['format'];

move_uploaded_file($_FILES['webcam']['tmp_name'], 'usr_pics/'.$filename.'.'.$format);
?>