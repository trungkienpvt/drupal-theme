<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php print $head; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
    <title><?php echo drupal_get_title() ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo PATH_CURRENT_THEME . 'style.css'?>"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<!--    <link rel="stylesheet" type="text/css" href="--><?php //echo PATH_CURRENT_THEME?><!--style.css" />-->
    <meta name="robots" content="index, follow">
    <meta name="author" content="">
    <?php manualMetaTags($_GET['q']) ?>
    <?php print $styles; ?>
    <?php print $scripts; ?>

</head>
<body>
<div id="wrap">
    <?php print $page_top; ?>
    <?php print $page; ?>
    <?php print $page_bottom; ?>
</div>
</body>
</html>