<?php
include_once dirname(__FILE__,2).'/config.php';
$conf = new config();

require $conf->includesFolderBASEPATH."dbconn.php";

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$query = array();
$parts = parse_url($url);

if(array_key_exists("query", $parts))
    parse_str($parts['query'], $query);

if(!(array_key_exists("token", $query) && array_key_exists("email", $query))){
    header("location: ".$conf->includesFolderURL."404");
    exit();
}

$email = $query['email'];
$hash = $query['token'];
$verr = '';

try {
    $vdb = new DbConn;
    $tbl_user = $vdb->tbl_user;
    
    $stmt = $vdb->conn->prepare("SELECT * FROM ".$tbl_user." WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Gets query result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(strcmp($result['hash'],$hash) == 0 && strcmp($result['activated'],'0') == 0){
        // prepare sql and bind parameters
        $verify = 1;
        $vstmt = $vdb->conn->prepare('UPDATE '.$tbl_user.' SET activated = :verify, active = :verify WHERE email= :email');
        $vstmt->bindParam(':email', $email);
        $vstmt->bindParam(':verify', $verify);
        $vstmt->execute();
        session_start();
        
        $_SESSION['email']  = $result['email'];
        $_SESSION['mobile'] = $result['mobile'];
        $_SESSION['fname']  = $result['first_name'];

        header("location: ../../index?first=true");
        exit();
    }else{
        header("location: ".$conf->includesFolderURL."404");
        exit();
    }
    

} catch (PDOException $v) {

    $verr = 'Error: ' . $v->getMessage();

}