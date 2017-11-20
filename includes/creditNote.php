<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    require $conf->includesFolderBASEPATH.'functions.php';
    $functions = new Functions();
    
    $post_request = json_decode(file_get_contents("php://input"), true);
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "submitCN") == 0)){
        if(array_key_exists("cn", $post_request) && (is_array($post_request['cn'])) &&
           array_key_exists("singleCN", $post_request) && (is_array($post_request['singleCN'])) ){
            print_r($functions->submitCN($post_request['cn'], $post_request['singleCN']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "cancelCN") == 0)){
        if(array_key_exists("invNum", $post_request) && (strcmp($post_request['invNum'], '') != 0) && (strcmp($post_request['invNum'], '0') != 0)){
            print_r($functions->cancelCN($post_request['invNum']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getAllEstm") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getAllEstimate($_GET['ccode'], $_GET['estimateNo'], $_GET['cpoNo']));
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
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getCNDetails") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getCNDetails($_GET['ccode']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getCpoNums") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0) &&
                array_key_exists("estimateNo", $_GET) && (strcmp($_GET['estimateNo'], '') != 0) && 
                (strcmp($_GET['estimateNo'], 'Estimate Number') != 0)){
            print_r($functions->getCPOnums($_GET['ccode'], $_GET['estimateNo']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getEmployees") == 0)){
        print_r($functions->getEmployeesList());
    }
    
    
?>
