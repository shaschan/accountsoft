<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();

    require_once $conf->PHPMailerBASEPATH."class.phpmailer.php";
    require_once $conf->includesFolderBASEPATH."dbconn.php";

    class Mailer extends DbConn
    {
        public function sendmail($user, $subject, $body)
        {
            $conf = new config();
            $mail = new PHPMailer();
            $mail->IsSMTP();                                      // set mailer to use SMTP
            $mail->Host = "smtp.gmail.com";  // specify main and backup server
            $mail->Port = 465;
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = $conf->smtpUsername;  // SMTP username
            $mail->Password = $conf->smtpPass; // SMTP password

            $mail->From = $conf->mailFromEmail;
            $mail->FromName = $conf->mailFromName;
            $mail->AddAddress($user['email'], $user['first_name']);
            $mail->AddReplyTo($conf->mailFromEmail, $conf->mailFromName);

            $mail->WordWrap = 50;                                 // set word wrap to 50 characters
            $mail->SMTPSecure = 'ssl';
//            $mail->SMTPDebug = 2;
            $mail->IsHTML(true);                                  // set email format to HTML

            $mail->Subject = $subject;
            $mail->Body    = $body;
            return $mail->Send();
        }

        public function sendVerfication($user, $hash=''){

            $conf = new config();
            $subject = $conf->verificationSubject;

            $result;

            if(strcmp($hash, '') == 0){
                $err = '';
                try {
                    $db = new DbConn;
                    $tbl_user = $db->tbl_user;
                } catch (PDOException $e) {
                    $err = "Error: " . $e->getMessage();
                }

                $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_user." WHERE email = :emailormob or mobile = :emailormob");
                $stmt->bindParam(':emailormob', $user);
                $stmt->execute();

                // Gets query result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if($result['activated'] == '1' && $result['active'] == '1'){
                    //already activated and active
                    return 0;
                }else if($result['activated'] == '1' && $result['active'] == '0'){
                    //deactivated account
                    return 0;
                }else if($result['activated'] == '0' && $result['active'] == '0'){
                    //not activated yet
                    $hash = $result['hash'];
                }
            }else{
                $result = $user;
            }

            if(strcmp(trim($hash),'') == 0){
                return 0;
            }

            $body = '<div style="text-transform: capitalize;"> Hi '.trim($result['first_name']).',</div><br><br>Welcome to MegaFMS.<br><br>Please click on '
                . '<a href="'.$conf->includesFolderURL.'/verify?token='.$hash.'&email='.trim($result['email']).'">'
                . 'this link</a> to activate your account.<br><br><br><div style="font-weight: 900;">Admin<br><span style="font-weight: 100;">Megalution Service Pvt Ltd</span></div>';

            return $this->sendmail($result, $subject, $body);
        }
    }
