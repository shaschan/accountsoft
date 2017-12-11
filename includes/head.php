<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
?>
<head>
    <style type="text/css"></style>
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="language" content="en">
    <meta http-equiv="content-language" content="en">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">

    <meta name="environment" content="production">

    <title><?php echo $conf->landingPageName?></title>

    <meta name="title" content="<?php echo $conf->landingPageName?>">
    <meta name="og:title" content="<?php echo $conf->landingPageName?>">
    <meta property="og:title" content="<?php echo $conf->landingPageName?>">

    <meta name="description" content="<?php echo $conf->landingPageDesc?>">
    <meta name="og:description" content="<?php echo $conf->landingPageDesc?>">
    <meta property="og:description" content="<?php echo $conf->landingPageDesc?>">

    <link rel="canonical" href="<?php echo $conf->fmsLink?>">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo $conf->fmsLink?>">
    <meta property="og:site_name" content="<?php echo $conf->siteName?>">

    <meta property="og:image" content="">
    <meta property="og:image:secure_url" content="">

    <link rel="icon" type="image/x-icon" href="<?php echo $conf->assetsFolderURL?>/images/favicon.ico" />
    
    <link href="<?php echo $conf->assetsFolderURL?>/css/dist/font-awesome-3.2.1.css" rel="stylesheet">
    <!-- custom css files-->
    <link rel="stylesheet" href="<?php echo $conf->assetsFolderURL?>/css/sidebar.css">
    
    <link rel="stylesheet" href="<?php echo $conf->assetsFolderURL?>/css/customize.css">
    
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo $conf->assetsFolderURL?>/css/dist/bootstrap.min.css">
    
        <!-- Latest compiled Jquery UI CSS -->
    <!--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.all.css">-->
    

    <!-- jQuery library -->
    <script src="<?php echo $conf->assetsFolderURL?>/js/dist/jquery-3.2.1.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/dist/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
    <!-- Angular Js library-->
    <script src="<?php echo $conf->assetsFolderURL?>/js/dist/angular-1.3.9.min.js"></script>

    <!-- Latest compiled bootstrap JavaScript -->
    <script src="<?php echo $conf->assetsFolderURL?>/js/dist/bootstrap-3.3.7.min.js"></script>
    
    
    
    <!-- custom javascript files-->
    <script src="<?php echo $conf->assetsFolderURL?>/js/customize.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/sidebar.js"></script>
    
    <!-- angular controllers js files-->
    <script src="<?php echo $conf->assetsFolderURL?>/js/maincontroller.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/customdirectives.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/dashboardcontroller.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/quotecontroller.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/cpocontroller.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/invoicecontroller.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/debitNotecontroller.js"></script>
    <script src="<?php echo $conf->assetsFolderURL?>/js/creditNotecontroller.js"></script>

    

    <script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-106864477-1', {
          'cookieDomain': 'auto',
          'siteSpeedSampleRate': 100
        });
        
        ga('send', 'pageview');

    </script>

</head>