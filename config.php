<?php
    
    Class config {
        const  PROJECT = "/accountsoft/";
        public $landingPageName = "Financial Management System";
        public $landingPageTitle = "FMS: Financeial Management System by Megalution Service Pvt Ltd.";
        public $landingPageDesc = "A platform to maintain accounts receivables and payables for a company system. Easily maintainable and Handable.";
        public $fmsLink = "https://megalution.in/fms";
        public $siteName = "megalution.in";
        public $assetsFolderBASEPATH;
        public $includesFolderBASEPATH;
        public $srcFolderBASEPATH;
        public $srcFolderURL;
        public $assetsFolderURL;
        public $includesFolderURL;
        public $PHPMailerURL;
        public $PHPMailerBASEPATH;
        
        public $smtpUsername = "shashishchandra@gmail.com";
        public $smtpPass = "password";
        public $mailFromEmail = "shashishchandra@gmail.com";
        public $mailFromName = "Shashish Chandra";
        
        public $verificationSubject = "MegaFMS Verification Link";
        
        public function __construct() {
            $this->assetsFolderURL = "http://".$_SERVER['SERVER_NAME'].self::PROJECT."assets/";
            $this->includesFolderURL = "http://".$_SERVER['SERVER_NAME'].self::PROJECT."includes/";
            $this->srcFolderURL = "http://".$_SERVER['SERVER_NAME'].self::PROJECT."src/";
            $this->assetsFolderBASEPATH = __DIR__."/assets/";
            $this->includesFolderBASEPATH = __DIR__."/includes/";
            $this->srcFolderBASEPATH = __DIR__."/src/";
            $this->PHPMailerBASEPATH = __DIR__."/PHPMailer/";
            $this->PHPMailerURL = "http://".$_SERVER['SERVER_NAME'].self::PROJECT."PHPMailer/";
        }
        
    }
?>

