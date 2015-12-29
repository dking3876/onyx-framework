<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $PageTitle; ?></title>
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/screen.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/print.css" media="print" rel="stylesheet" type="text/
        css" />
        <!--[if IE]>
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/ie.css" media="screen, projection" rel="styleshee
        t" type="text/css" />
        <![endif]-->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL; ?>onyx/assets/images/favicon.ico">
        <?php echo $PageStyles; ?>
        <script src="<?php echo BASE_URL; ?>onyx/assets/js/Onyx.js" type="text/javascript"></script>
        <?php echo $PageHeaderScripts; ?>
</head>
    <body class="<?php echo $page; ?>">
        <header>
            <nav class="onyx-nav">
                <div class="logo-container">
                    <?php renderImage('onyxlogo-150x150.png', 'onyx'); ?>
                </div>
            </nav>
        </header>