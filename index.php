<!DOCTYPE html>
<!--
Accounting Software Index File
Licensed under Megalution Service Pvt Ltd
Created By shaschan
-->
<html ng-app="fmsApp">
    <?php
        include_once dirname(__FILE__).'/config.php';
        $conf = new config();
        include $conf->includesFolderBASEPATH.'head.php';
        session_set_cookie_params(0);
        session_start();
        $firstTime = false;
        $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $query = array();
        $parts = parse_url($url);
        
        if(array_key_exists("query", $parts))
            parse_str($parts['query'], $query);
        
        if(array_key_exists("first", $query) && strcmp($query['first'],'true') == 0){
            $firstTime = true;
        }
    ?>
    <body style="font-family: QuickSand;">
        <!-- HEADER -->
        <?php 
            include $conf->includesFolderBASEPATH.'header.php';
        ?>
        <!-- MAIN -->
        <?php 
            if(!$firstTime && !array_key_exists("email",$_SESSION)) { //not first time and not logged in
                include $conf->srcFolderBASEPATH.'landing.php';
            }else if(array_key_exists("email",$_SESSION)){ //already logged in
                include $conf->srcFolderBASEPATH.'panel.php';
            }else if($firstTime){ //first time, definitely not logged in
                include $conf->srcFolderBASEPATH.'firstLogin.php';
            }
        ?>
        <!-- FOOTER -->
        <?php
            if(!array_key_exists("email",$_SESSION)){
                include $conf->includesFolderBASEPATH.'footer.php';
            }
        ?>
    </body>
</html>
