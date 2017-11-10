<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    require $conf->includesFolderBASEPATH.'functions.php';
    $functions = new Functions();
    
    $post_request = json_decode(file_get_contents("php://input"), true);
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "generateAndAssignPC") == 0)){
        print_r($functions->generateAndAssignPC($post_request['ccode'], $post_request['estNo'],  $post_request['cponum'], $post_request['pc']));
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getAllEstm") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getAllEstimate($_GET['ccode'], $_GET['estimateNo']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getClients") == 0)){
        print_r($functions->getClientsList());
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getEstNos") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getEstimates($_GET['ccode']));
        }else{
            print_r(1);
        }
    }
    
    
?>
