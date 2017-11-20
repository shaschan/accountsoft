<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    require $conf->includesFolderBASEPATH.'functions.php';
    $functions = new Functions();
    
    $post_request = json_decode(file_get_contents("php://input"), true);
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "submitDN") == 0)){
        if(array_key_exists("dn", $post_request) && (is_array($post_request['dn'])) &&
           array_key_exists("singleDN", $post_request) && (is_array($post_request['singleDN'])) ){
            print_r($functions->submitDN($post_request['dn'], $post_request['singleDN']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "cancelDN") == 0)){
        if(array_key_exists("invNum", $post_request) && (strcmp($post_request['invNum'], '') != 0) && (strcmp($post_request['invNum'], '0') != 0)){
            print_r($functions->cancelDN($post_request['invNum']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getClients") == 0)){
        print_r($functions->getClientsList());
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getInvNums") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0) &&
                array_key_exists("cponum", $_GET) && (strcmp($_GET['cponum'], '') != 0)){
            print_r($functions->getInvoices($_GET['ccode'], $_GET['cponum']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getAllInvs") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0) &&
                array_key_exists("invoiceNum", $_GET) && array_key_exists("cpoNo", $_GET) ){
            print_r($functions->getAllInvoices($_GET['ccode'], $_GET['cpoNo'], $_GET['invoiceNum']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getDNDetails") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getDNDetails($_GET['ccode']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getCpoNums") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getCPOnums($_GET['ccode']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getEmployees") == 0)){
        print_r($functions->getEmployeesList());
    }
    
    
?>
