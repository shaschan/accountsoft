<?php
include_once dirname(__FILE__,2).'/config.php';
$conf = new config();

require $conf->includesFolderBASEPATH."dbconn.php";

class LoginForm extends DbConn
{
    public function checkLogin($user)
    {
        $ip_address =  $_SERVER['REMOTE_ADDR'];
        $datetimeNow = date("Y-m-d H:i:s");
        $tbl_user = "";
        $success = 404;

        try {

            $db = new DbConn;
            $tbl_user = $db->tbl_user;
            $err = '';

        } catch (PDOException $e) {

            $err = "Error: " . $e->getMessage();

        }

        $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_user." WHERE email = :email or mobile = :mobile");
        $stmt->bindParam(':email', $user['emailormobile']);
        $stmt->bindParam(':mobile', $user['emailormobile']);
        $stmt->execute();

        // Gets query result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Checks password entered against db password hash
        if (password_verify($user['password'], $result['password']) && $result['activated'] == '1' && $result['active'] == '1') {

            //Success! Register $myusername, $mypassword and return "true"
            $success = 0;
            session_set_cookie_params(0);
            session_start();

            $_SESSION['user_id']  = $result['id'];
            $_SESSION['type']  = (strcmp($result['is_admin'], "YES") == 0) ? 'ADMIN' : 'USER';
            $_SESSION['email']  = $result['email'];
            $_SESSION['mobile']  = $result['mobile'];
            $_SESSION['fname']   = $result['first_name'];
            
            //update modified time
            $stmt = $db->conn->prepare("UPDATE ".$tbl_user." SET updated_datetime = :updated_datetime, ip = :ip where email = :email and mobile = :mobile");
            $stmt->bindParam(':updated_datetime', $datetimeNow);
            $stmt->bindParam(':ip', $ip_address);
            $stmt->bindParam(':email', $result['email']);
            $stmt->bindParam(':mobile', $result['mobile']);
            $stmt->execute();

        } elseif (password_verify($user['password'], $result['password']) && $result['activated'] == '0') {

            //Account not yet verified
            $success = 1;

        } elseif (password_verify($user['password'], $result['password']) && $result['activated'] == '1' && $result['active'] == '0') {

            //Account not ative
            $success = 2;

        }  else {

            //Wrong username or password
            $success = 3;

        }
        
        return $success;
    }
}
