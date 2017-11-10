<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    require $conf->includesFolderBASEPATH.'functions.php';
    $functions = new Functions();
    
    $post_request = json_decode(file_get_contents("php://input"), true);

    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "createClient") == 0)){
        if(array_key_exists("client", $post_request) && (is_array($post_request['client']))){
            print_r($functions->createNewClient($post_request['client']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "updateClient") == 0)){
        if(array_key_exists("client", $post_request) && (is_array($post_request['client']))){
            print_r($functions->updateClient($post_request['client']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($post_request) && array_key_exists("token", $post_request) && (strcmp($post_request['token'], "submitQuote") == 0)){
        if(array_key_exists("quoteData", $post_request) && (is_array($post_request['quoteData']))){
            print_r($functions->submitQuote($post_request['quoteData']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getClients") == 0)){
        print_r($functions->getClientsList());
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getQuotes") == 0)){
        if(array_key_exists("ccode", $_GET) && (strcmp($_GET['ccode'], '') != 0)){
            print_r($functions->getQuotes($_GET['ccode']));
        }else{
            print_r(1);
        }
    }
    
    if(isset($_GET) && array_key_exists("token", $_GET) && (strcmp($_GET['token'], "getEmployees") == 0)){
        print_r($functions->getEmployeesList());
    }
    
?>
