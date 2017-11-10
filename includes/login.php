<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
//signup
//Array
//(
//    [token] => signup
//    [email] => shashishchandra@gmail.com
//    [fname] => shashish
//    [lname] => chandra
//    [mob] => 9540730867
//    [pass] => qwer1234
//)

    if(isset($_POST) && array_key_exists("token", $_POST) && (strcmp($_POST['token'], "signup") == 0)){
        $checkFlag = false;
        $user = array(); 
        $user['email'] = array_key_exists("email", $_POST) && strlen(trim($_POST['email'])) > 0 ? trim($_POST['email']): ($checkFlag = true);
        $user['first_name'] = array_key_exists("fname", $_POST) && strlen(trim($_POST['fname'])) > 0 ? trim($_POST['fname']): ($checkFlag = true);
        $user['last_name'] = array_key_exists("lname", $_POST) && strlen(trim($_POST['lname'])) > 0 ? trim($_POST['lname']): ($checkFlag = true);
        $user['mobile'] = array_key_exists("mob", $_POST) && strlen(trim($_POST['mob'])) > 0 ? trim($_POST['mob']): ($checkFlag = true);
        $user['password'] = array_key_exists("pass", $_POST) && strlen(trim($_POST['pass'])) > 0 ? password_hash(trim($_POST['pass']), PASSWORD_DEFAULT): ($checkFlag = true);
        
        if(!$checkFlag){
            require $conf->includesFolderBASEPATH.'signupform.php';
            $signupform = new SignUpForm();
            $ret = $signupform->createuser($user);
            echo $ret;//0 -> success
        }else{
            echo ("Fields missing");
        }
    }
    
    if(isset($_POST) && array_key_exists("token", $_POST) && (strcmp($_POST['token'], "login") == 0)){
        $checkFlag = false;
        $user = array(); 
        $user['emailormobile'] = array_key_exists("email", $_POST) && strlen(trim($_POST['email'])) > 0 ? trim($_POST['email']): ($checkFlag = true);
        $user['password'] = array_key_exists("pass", $_POST) && strlen(trim($_POST['pass'])) > 0 ? trim($_POST['pass']): ($checkFlag = true);
        
        if(!$checkFlag){
            require $conf->includesFolderBASEPATH.'loginForm.php';
            $loginform = new LoginForm();
            $ret = $loginform->checkLogin($user);
            echo $ret; //0 -> success
        }else{
            echo ("Fields missing");
        }
    }
    
    if(isset($_POST) && array_key_exists("token", $_POST) && (strcmp($_POST['token'], "verify") == 0)){
        require $conf->includesFolderBASEPATH.'mailer.php';
        $mail_ver = new Mailer();
        $checkFlag = false;
        $user = array_key_exists("email", $_POST) && strlen(trim($_POST['email'])) > 0 ? trim($_POST['email']): ($checkFlag = true);
        $ret = $mail_ver->sendVerfication($user);
        echo $ret;//1 -> success
    }
?>