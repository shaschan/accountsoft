<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    require $conf->includesFolderBASEPATH.'functions.php';
    $functions = new Functions();

    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "check") == 0)){
        if(array_key_exists("company", $_GET) && (strcmp($_GET['company'], "") != 0)){
            print_r($functions->checkCompanyExists($_GET['company']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "save") == 0)){
        if(array_key_exists("company", $_GET) && (strcmp($_GET['company'], "") != 0)){
            print_r($functions->saveCompanyDetails($_GET['company']));
        }else{
            print_r(1);
        }
    }
?>

