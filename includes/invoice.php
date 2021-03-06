<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    require $conf->includesFolderBASEPATH.'functions.php';
    $functions = new Functions();
    
    $post_request = json_decode(file_get_contents("php://input"), true);
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "submitInvoice") == 0)){
        if(array_key_exists("invoice", $post_request) && (is_array($post_request['invoice'])) &&
           array_key_exists("singleInvoice", $post_request) && (is_array($post_request['singleInvoice'])) ){
            print_r($functions->submitInvoice($post_request['invoice'], $post_request['singleInvoice']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "cancelInvoice") == 0)){
        if(array_key_exists("invNum", $post_request) && (strcmp($post_request['invNum'], '') != 0) && (strcmp($post_request['invNum'], '0') != 0)){
            print_r($functions->cancelInvoice($post_request['invNum']));
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
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getInvoiceDetails") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getInvoiceDetails($_GET['ccode']));
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
