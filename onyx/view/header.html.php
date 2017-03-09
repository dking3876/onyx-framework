<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $PageTitle; ?></title>
        <!--[if IE]>
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/ie.css" media="screen, projection" rel="styleshee
        t" type="text/css" />
        <![endif]-->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL; ?>onyx/assets/images/favicon.ico">
        <?php $PageStyles(); ?>
        <?php $PageHeaderScripts(); ?>
</head>
    <body class="OnyxAdministration <?php echo $page; ?>">
        <div id="onyx-admin-sidesection">
        <div id="onyx-admin-menu-section">
            <?php if($authorized){ ?>
            <ul class="administrator-menu-items">
                <li>Dashboard</li>
                <li>Extensions</li>
                <li>Settings</li>
                <li>Users</li>
                
            </ul>
            <?php } ?>
        </div>        
    </div>
    <div id="onyx-admin-topsection">
        <div id="information">
            <div class="top-section-innercontainer">
                <div class="right-container">
                Welcome to <?php echo isset($sitename)? $sitename : 'OnyxPHP'; ?> 
            </div>
            </div>
        </div>
        <div id="onyx-glance">
            <div id="onyx-brand">
                <div class="full-container">
                    <a href="https://www.onyxphp.com" target="_blank"><?php renderImage('onyxlogo-150x150.png', 'onyx'); ?></a>
            </div>
            <div id="user-info">
                <div class="full-container">
                {User info here}
                </div>
            </div>
        </div>
        <div class="top-dash">
            <div class="page-breadcrumbs" style="color:#0084A8;font-size:16px;height:100%;line-height:35px; ">
                <?php echo $page; ?>
            </div>
        </div>
        
    </div>
        <div class="onyx-admincontent-section">