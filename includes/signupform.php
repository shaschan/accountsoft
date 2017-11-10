<?php

include_once dirname(__FILE__,2).'/config.php';
$conf = new config();

require_once $conf->includesFolderBASEPATH."dbconn.php";

class SignUpForm extends DbConn
{
    public function createUser($user)
    {
        try {
            $success = 404;
            $ip_address =  $_SERVER['REMOTE_ADDR'];
            $datetimeNow = date("Y-m-d H:i:s");
            $db = new DbConn;
            $tbl_user = $db->tbl_user;

            $stmtcheck = $db->conn->prepare("SELECT * FROM ".$tbl_user." WHERE email = :email or mobile = :mobile");
            $stmtcheck->bindParam(':email', $user['email']);
            $stmtcheck->bindParam(':mobile', $user['mobile']);
            $stmtcheck->execute();
            $result = $stmtcheck->fetch(PDO::FETCH_ASSOC);
            
            if (is_array($result) && $result['activated'] == '0') {

                //Account not yet verified
                $failure = 1;
                return $failure;

            } elseif (is_array($result) && $result['activated'] == '1' && $result['active'] == '0') {

                //Account not ative
                $failure = 2;
                return $failure;

            }elseif(is_array($result)){
                
                //Already exists
                $failure = 3;
                return $failure;
            }
            
            $verify = 0;
            $hash = md5( rand(0,1000) );
            // prepare sql and bind parameters
            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_user." (email, first_name, last_name, mobile, password, activated, active, created_datetime, updated_datetime, ip, hash)
            VALUES (:email, :first_name, :last_name, :mobile, :password, :activated, :active, :created_datetime, :updated_datetime, :ip, :hash)");
            $stmt->bindParam(':email', $user['email']);
            $stmt->bindParam(':first_name', $user['first_name']);
            $stmt->bindParam(':last_name', $user['last_name']);
            $stmt->bindParam(':mobile', $user['mobile']);
            $stmt->bindParam(':password', $user['password']);
            $stmt->bindParam(':activated', $verify);
            $stmt->bindParam(':active', $verify);
            $stmt->bindParam(':created_datetime', $datetimeNow);
            $stmt->bindParam(':updated_datetime', $datetimeNow);
            $stmt->bindParam(':ip', $ip_address);
            $stmt->bindParam(':hash', $hash);
            $stmt->execute();

            $conf = new config();
            
            require $conf->includesFolderBASEPATH.'mailer.php';
            
            $mail_ver = new Mailer();
            $ret = $mail_ver->sendVerfication($user, $hash);
            
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }
        //Determines returned value ('true' or error code)
        if ($err == '') {

            $success = 0;

        } else {

            $success = $err;

        };

        return $success;

    }
}
