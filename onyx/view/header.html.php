<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $PageTitle; ?></title>
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/screen.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/print.css" media="print" rel="stylesheet" type="text/css" />
        <!--[if IE]>
        <link href="<?php echo BASE_URL; ?>onyx/assets/css/ie.css" media="screen, projection" rel="styleshee
        t" type="text/css" />
        <![endif]-->
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo BASE_URL; ?>onyx/assets/images/favicon.ico">
        <?php $PageStyles(); ?>
        
        <?php $PageHeaderScripts(); ?>
        <script src="<?php echo BASE_URL; ?>onyx/assets/js/Onyx.js" type="text/javascript"></script>
         <style>
        div{
            box-sizing: border-box;
        }
        #onyx-admin-sidesection{
            width:200px;
            background-color:black;
            position:fixed;
            top:0px;
            left:0px;
            height:100%;
            color:#FFF;
        }
        #onyx-admin-topsection{
            width:100%;
            background-color:black;
            background: url('http://onyxdev.dev/onyx/assets/images/onyx-pattern.jpg');
            background-size:cover;
            background-repeat:no-repeat;
            background-position: center;
            position:fixed;
            top:0px;
            left:0px;
            height:125px;
            z-index:2;
        }
        #information{
            position:absolute;
            top:0px;
            left:0px;
            background-color:#0084A8;
            height:50px;
            width:100%;
        }
        #onyx-glance {
            padding:0px !important;
	       width:200px;
            /*height:100%;*/
            background-color:black;
             background: url('http://onyxdev.dev/onyx/assets/images/3d-onyx.jpg');
            background-size:cover;
            background-repeat:no-repeat;
            position:absolute;
            color:#FFF;
        }
        #onyx-brand{
            height:50px;
            width:100%;
            color:#FFF;
        }
             #onyx-brand img{
            height:100%;
        }
        #user-info{           
            height:75px;
        }
        div#onyx-admin-menu-section {
            height: 100%;
            position: absolute;
            top: 0px;
            left: 0px;
            padding: 145px 5px 0px 10px;
            width: 100%;
                overflow-x: hidden;
    overflow-y: auto;
        }
        .top-section-innercontainer {
    color: black;
    padding: 10px 0px 0px 205px;
            height:100%;
}
        .right-container {
        float: right;
            color:#FFF;
    background-color: #000;
    height: 100%;
    padding: 10px;
    font-weight: 700;
    font-size: 16px;
            width:250px;
}
        .top-dash {
    padding: 55px;
    padding-left: 205px;
    color: #fff;
    width: 100%;
    height: 100%;
}
            
        .administrator-menu-items{
            list-style:none;
            padding-left:10px;
            margin:0px;
        }
        ul.administrator-menu-items li{
            display:block;
            line-height:30px;
            font-size:20px;
        }
        .onyx-admincontent-section {
    margin-left: 200px;
    margin-top: 125px;
    padding: 15px;
    
}
        .full-container {
    padding: 10px;
    background: rgba(250,250,250,0.6);
    height: 100%;
    width: 100%;
    color: #000;
}
    </style>
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
                    <a href="https://www.onyxphp.com" target="_blank"><?php renderImage('onyxlogo-150x150.png', 'onyx'); ?></a> <a href="https://www.onyxphp.com" target="_blank">Onyx</a>
                </div>
            </div>
            <div id="user-info">
                <div class="full-container">
                User info here
                </div>
            </div>
        </div>
        <div class="top-dash">
            <div class="page-breadcrumbs" style="color:#0084A8;">
                Onyx > <?php echo $page; ?>
            </div>
        </div>
        
    </div>
        <div class="onyx-admincontent-section">