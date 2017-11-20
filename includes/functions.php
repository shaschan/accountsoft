<?php
    include_once dirname(__FILE__,2).'/config.php';
    $conf = new config();
    ob_start();
    require $conf->includesFolderBASEPATH."dbconn.php";
    session_start();
    class Functions extends DbConn{
    
        public function checkCompanyExists($name){
            $name = json_decode($name);
            if(strcmp($name,"")) return 2;
            
            try {
                $db = new DbConn;
                $tbl_company = $db->tbl_company;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }

            $stmt = $db->conn->prepare("SELECT * FROM ".$tbl_company." WHERE name = :name and user_id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();

            // Gets query result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return 1;
            }else{
                return 0;
            }

        }
        
        public function saveCompanyDetails($compDets){
            $datetimeNow = date("Y-m-d H:i:s");
            
            $compDets = json_decode($compDets);

            if(strcmp($compDets->companyName, "") == 0 || strcmp($compDets->cin, "") == 0 ||
                    strcmp($compDets->pan, "") == 0 || strcmp($compDets->gst, "") == 0 || 
                    strcmp($compDets->sac, "") == 0 || strcmp($compDets->addr, "") == 0 ||
                    strcmp($_SESSION['user_id'], "") == 0)
                    return 2;
            
            try {
                $db = new DbConn;
                $tbl_company = $db->tbl_company;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_company." (name, CIN, PAN, GST, SAC, billing_address, user_id, added_on)
            VALUES (:name, :cin, :pan, :gst, :sac, :addr, :id, :added_on)");

            $stmt->bindParam(':name', $compDets->companyName);
            $stmt->bindParam(':cin', $compDets->cin);
            $stmt->bindParam(':pan', $compDets->pan);
            $stmt->bindParam(':gst', $compDets->gst);
            $stmt->bindParam(':sac', $compDets->sac);
            $stmt->bindParam(':addr', $compDets->addr);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->bindParam(':added_on', $datetimeNow);
            $stmt->execute();

            return 0;
        }
        
        public function createNewClient($client){
            $datetimeNow = date("Y-m-d H:i:s");
            
            $clientDets = $client;
            
            if(strcmp($clientDets['clientName'], "") == 0 || strcmp($clientDets['emails'], "") == 0 ||
                    strcmp($clientDets['billingAddress'], "") == 0 || strcmp($clientDets['pan'], "") == 0 || 
                    strcmp($clientDets['gst'], "") == 0 || strcmp($clientDets['sac'], "") == 0 ||
                    strcmp($_SESSION['user_id'], "") == 0 || strcmp($clientDets['ccode'], "") == 0)
                    return 2;
            
            try {
                $db = new DbConn;
                $tbl_client = $db->tbl_client;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_client." WHERE client_name = :client_name and user_id = :id or ccode = :client_code");
            $stmtSr->bindParam(':client_name', $clientDets['clientName']);
            $stmtSr->bindParam(':client_code', $clientDets['ccode']);
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetch(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return $result;
            }else{
            
                $stmt = $db->conn->prepare("INSERT INTO ".$tbl_client." (client_name, ccode, emails, billing_address, PAN, GST, SAC, user_id, added_date, modified_date)
                VALUES (:clientName, :client_code, :emails, :billing_address, :pan, :gst, :sac, :id, :added_date, :modified_date)");

                $stmt->bindParam(':clientName', $clientDets['clientName']);
                $stmt->bindParam(':client_code', $clientDets['ccode']);
                $stmt->bindParam(':emails', $clientDets['emails']);
                $stmt->bindParam(':billing_address', $clientDets['billingAddress']);
                $stmt->bindParam(':pan', $clientDets['pan']);
                $stmt->bindParam(':gst', $clientDets['gst']);
                $stmt->bindParam(':sac', $clientDets['sac']);
                $stmt->bindParam(':id', $_SESSION['user_id']);
                $stmt->bindParam(':added_date', $datetimeNow);
                $stmt->bindParam(':modified_date', $datetimeNow);
                $stmt->execute();

                return 0;
            }
        }
        
        public function updateClient($client){
            $datetimeNow = date("Y-m-d H:i:s");
            
            $clientDets = $client;
            
            if(strcmp($clientDets['clientName'], "") == 0 || strcmp($clientDets['emails'], "") == 0 ||
                    strcmp($clientDets['billingAddress'], "") == 0 || strcmp($clientDets['pan'], "") == 0 || 
                    strcmp($clientDets['gst'], "") == 0 || strcmp($clientDets['sac'], "") == 0 ||
                    strcmp($clientDets['ccode'], "") == 0 || strcmp($_SESSION['user_id'], "") == 0)
                    return 2;
            
            try {
                $db = new DbConn;
                $tbl_client = $db->tbl_client;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
    
            $stmtQuote = $db->conn->prepare("UPDATE ".$tbl_quote." SET ccode = :ccode WHERE ccode = :client_code AND user_id = :id");
            $stmtQuote->bindParam(':ccode', $clientDets['ccode']);
            $stmtQuote->bindParam(':client_code', $this->getCCodeByClientName($clientDets['clientName'])['ccode']);
            $stmtQuote->bindParam(':id', $_SESSION['user_id']);
            $stmtQuote->execute();
            
            $stmt = $db->conn->prepare("UPDATE ".$tbl_client." SET ccode = :client_code, emails = :emails,  billing_address = :billing_address, "
                    . "PAN = :pan, GST = :gst, SAC = :sac, modified_date = :modified_date "
                    . "WHERE client_name = :client_name AND user_id = :id");
            $stmt->bindParam(':client_name', $clientDets['clientName']);
            $stmt->bindParam(':client_code', $clientDets['ccode']);
            $stmt->bindParam(':emails', $clientDets['emails']);
            $stmt->bindParam(':billing_address', $clientDets['billingAddress']);
            $stmt->bindParam(':pan', $clientDets['pan']);
            $stmt->bindParam(':gst', $clientDets['gst']);
            $stmt->bindParam(':sac', $clientDets['sac']);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->bindParam(':modified_date', $datetimeNow);
            $stmt->execute();
            
            return 0;
            
        }
        
        public function generateAndAssignPC($ccode, $estNo, $cpoNo, $pc){
            
            if(strcmp($ccode, '') == 0 || strcmp($estNo, '') == 0 || strcmp($estNo, 'Estimate Number') == 0 ||
                    strcmp($cpoNo, '') == 0 || strcmp($pc, '') == 0)
                    return 1;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
    
            $stmtQuote = $db->conn->prepare("UPDATE ".$tbl_quote." SET pc = :pc, cponum = :cpoNo WHERE ccode = :ccode AND estimateNo = :estimateNo");
            $stmtQuote->bindParam(':cpoNo', $cpoNo);
            $stmtQuote->bindParam(':pc', $pc);
            $stmtQuote->bindParam(':ccode', $ccode);
            $stmtQuote->bindParam(':estimateNo', $estNo);
            $stmtQuote->execute();
            
            return 0;
        }
        
        public function getAllInvoices($ccode, $cpoNum = '', $invNum = ''){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ccode, "") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $invQry = '';
            if(strcmp($invNum, '') != 0){
                $invQry = " AND invoiceNum = '".$invNum."' ";
            }
            
            $cpoQry = '';
            if(strcmp($cpoNum, '') != 0){
                $cpoQry = " AND cponum = '".$cpoNum."' ";
            }
            
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_quote." WHERE user_id = :id AND ccode = :ccode ".$cpoQry.$invQry);
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return json_encode($result);
            }else{
                return 1;
            }
        }
        
        public function getInvoices($ccode, $cpoNum){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($cpoNum, "") == 0 || strcmp($ccode, "") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT DISTINCT(invoiceNum) FROM ".$tbl_quote." WHERE user_id = :id AND ccode = :ccode AND cponum = :cponum");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->bindParam(':cponum', $cpoNum);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return json_encode($result);
            }else{
                return 1;
            }
        }
        
        public function getAllEstimate($ccode, $estNo, $cponum = ''){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ccode, "") == 0) return 2;

            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
            
            $estQry = '';
            
            if(strcmp($estNo,'') != 0)
                    $estQry = " AND estimateNo = '".$estNo."' ";
            
            $cponumQry = '';
            
            if(strcmp($cponum,'') != 0)
                    $cponumQry = " AND cponum = '".$cponum."' ";
            
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_quote." WHERE user_id = :id AND ccode = :ccode ".$estQry.$cponumQry);
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                
                $data = array();
                
                for($idx = 0; $idx < count($result); $idx ++){
                    $data[$idx]['estimateNo'] = $result[$idx]['estimateNo'];
                    $data[$idx]['description'] = $result[$idx]['description'];
                    $data[$idx]['cponum'] = $result[$idx]['cponum'];
                    $data[$idx]['pc'] = $result[$idx]['pc'];
                    $data[$idx]['ppu'] = $result[$idx]['ppu'];
                    $data[$idx]['quantity'] = $result[$idx]['quantity'];
                    $data[$idx]['netValue'] = $result[$idx]['netValue'];
                    $data[$idx]['reimbursable'] = $result[$idx]['reimbursable'];
                    $data[$idx]['tax'] = $result[$idx]['tax'];
                    $data[$idx]['totalValue'] = $result[$idx]['totalValue'];
                    $data[$idx]['deliveryDate'] = $result[$idx]['deliveryDate'];
                    $data[$idx]['creationDate'] = $result[$idx]['creationDate'];
                    $data[$idx]['added_by'] = $this->getEmployeeByEcode($result[$idx]['addedBy'])['name'];
                    $data[$idx]['approved_by'] = $this->getEmployeeByEcode($result[$idx]['approvedBy1'])['name'].', '.$this->getEmployeeByEcode($result[$idx]['approvedBy2'])['name'];
                }
                
                return json_encode($data);
            }else{
                return 1;
            }
           
        }
        
        public function cancelInvoice($invNum){
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($invNum, "") == 0 || strcmp($invNum, "0") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_invoice = $db->tbl_invoice;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
            
            $stmtUp = $db->conn->prepare("UPDATE ".$tbl_invoice." SET status = 'cancelled' WHERE invoiceNum = :invoiceNum and status <>  'overwritten' ");
            $stmtUp->bindParam(':invoiceNum', $invNum);
            $stmtUp->execute();
            
            return 0;
        }
        
        public function submitInvoice($invoice, $singleInvoice){
            if( strcmp( $_SESSION['user_id'], "") == 0 || strcmp($invoice['ccode'], "") == 0 ||
                strcmp( $invoice['estNos'], "") == 0 || strcmp($invoice['estNos'], "Estimate Number") == 0 ||
                strcmp( $invoice['cpoNums'], "") == 0 || strcmp($invoice['cpoNums'], "PO Number") == 0 ||    
                strcmp( $singleInvoice['invoicenum'], "0") == 0 || strcmp($singleInvoice['invoicenum'], "") == 0 ||    
                strcmp( $singleInvoice['items']['adOrInOrFin'], "") == 0 || strcmp($singleInvoice['items']['adOrInOrFin'], "Select One") == 0 ||    
                strcmp( $singleInvoice['items']['tax'], "") == 0 || strcmp($singleInvoice['items']['totalValue'], "") == 0 ||
                strcmp( $singleInvoice['items']['paymentDate'], "") == 0 || strcmp($singleInvoice['items']['totalValue'], "") == 0 ||
                strcmp( $singleInvoice['items']['description'], "") == 0 || strcmp($singleInvoice['items']['netValue'], "") == 0 ||
                strcmp( $singleInvoice['addedBy'], "") == 0 || strcmp($singleInvoice['addedBy'], "Select Adder") == 0 ||    
                strcmp( $singleInvoice['approvedBy1'], "") == 0 || strcmp($singleInvoice['approvedBy1'], "Select Approver") == 0 ||
                strcmp( $singleInvoice['approvedBy2'], "") == 0 || strcmp($singleInvoice['approvedBy2'], "Select Approver") == 0
                ){
                    return 1;
            }
            
            $datetimeNow = date("Y-m-d H:i:s");
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $tbl_invoice = $db->tbl_invoice;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
            
            $stmtSrPr = $db->conn->prepare("SELECT invoiceNum FROM ".$tbl_quote." WHERE user_id = :id and ccode = :ccode and estimateNo = :estimateNo");
            $stmtSrPr->bindParam(':id', $_SESSION['user_id']);
            $stmtSrPr->bindParam(':ccode', $invoice['ccode']);
            $stmtSrPr->bindParam(':estimateNo',  $invoice['estNos']);
            $stmtSrPr->execute();
            
            $existingInvNo = ($stmtSrPr->fetch(PDO::FETCH_ASSOC))['invoiceNum'];

            $stmtUp = $db->conn->prepare("UPDATE ".$tbl_quote." SET invoiceNum = :invoiceNum WHERE user_id = :id and ccode = :ccode and estimateNo = :estimateNo");
            $stmtUp->bindParam(':invoiceNum', $singleInvoice['invoicenum']);
            $stmtUp->bindParam(':id', $_SESSION['user_id']);
            $stmtUp->bindParam(':ccode', $invoice['ccode']);
            $stmtUp->bindParam(':estimateNo',  $invoice['estNos']);
            $stmtUp->execute();
            
            if(strcmp($existingInvNo, "") != 0){
                $stmtUp = $db->conn->prepare("UPDATE ".$tbl_invoice." SET status = 'overwritten' WHERE invoiceNum = :invoiceNum");
                $stmtUp->bindParam(':invoiceNum', $existingInvNo);
                $stmtUp->execute();
            }
            
            $stmt = $db->conn->prepare("INSERT INTO ".$tbl_invoice." (invoiceNum, adOrInOrFin, description, netValue, tax, totalValue, paymentDate, status, addedBy, approvedBy1, approvedBy2, added_on)
            VALUES (:invoiceNum, :adOrInOrFin, :description, :netValue, :tax, :totalValue, :paymentDate, 'active', :addedBy, :approvedBy1, :approvedBy2, :added_on)");

            $stmt->bindParam(':invoiceNum', $singleInvoice['invoicenum']);
            $stmt->bindParam(':adOrInOrFin', $singleInvoice['items']['adOrInOrFin']);
            $stmt->bindParam(':description', $singleInvoice['items']['description']);
            $stmt->bindParam(':netValue', $singleInvoice['items']['netValue']);
            $stmt->bindParam(':tax', $singleInvoice['items']['tax']);
            $stmt->bindParam(':totalValue', $singleInvoice['items']['totalValue']);
            $stmt->bindParam(':paymentDate', $singleInvoice['items']['paymentDate']);
            $stmt->bindParam(':addedBy',  $singleInvoice['addedBy']);
            $stmt->bindParam(':approvedBy1',  $singleInvoice['approvedBy1']);
            $stmt->bindParam(':approvedBy2', $singleInvoice['approvedBy1']);
            $stmt->bindParam(':added_on', $datetimeNow);
            $stmt->execute();
            
            return 0;
        }
        
        public function getInvoiceDetails($ccode){
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ccode, "") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $tbl_invoice = $db->tbl_invoice;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_invoice." WHERE :ccode in (select ccode from ".$tbl_quote." where user_id = :id and ccode = :ccode) and status <> 'overwritten'");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                
                $data = array();
                
                for($idx = 0; $idx < count($result); $idx ++){
                    $data[$idx]['invoiceNum'] = $result[$idx]['invoiceNum'];
                    $data[$idx]['adOrInOrFin'] = $result[$idx]['adOrInOrFin'];
                    $data[$idx]['description'] = $result[$idx]['description'];
                    $data[$idx]['netValue'] = $result[$idx]['netValue'];
                    $data[$idx]['tax'] = $result[$idx]['tax'];
                    $data[$idx]['totalValue'] = $result[$idx]['totalValue'];
                    $data[$idx]['paymentDate'] = $result[$idx]['paymentDate'];
                    $data[$idx]['added_on'] = $result[$idx]['added_on'];
                    $data[$idx]['added_by'] = $this->getEmployeeByEcode($result[$idx]['addedBy'])['name'];
                    $data[$idx]['approved_by'] = $this->getEmployeeByEcode($result[$idx]['approvedBy1'])['name'].', '.$this->getEmployeeByEcode($result[$idx]['approvedBy2'])['name'];
                    $data[$idx]['status'] = $result[$idx]['status'];
                }
                
                return json_encode($data);
            }else{
                return 1;
            }
        }
        
        public function getCPOnums($ccode, $estNo = 'NA'){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ccode, "") == 0 ||
                   strcmp($estNo, "") == 0 || strcmp($estNo, "Estimate Number") == 0 ) return 2;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $estNoStr = '';
            
            if(strcmp($estNo,'NA') != 0){
                $estNoStr = " AND estimateNo = '".$estNo."' ";
            }
            
            $stmtSr = $db->conn->prepare("SELECT DISTINCT(cponum) FROM ".$tbl_quote." WHERE user_id = :id AND ccode = :ccode ".$estNoStr." AND cponum <> ''");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return json_encode($result);
            }else{
                return 1;
            }
           
        }
        
        public function getEstimates($ccode){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ccode, "") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT DISTINCT(estimateNo), invoiceNum FROM ".$tbl_quote." WHERE user_id = :id AND ccode = :ccode");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return json_encode($result);
            }else{
                return 1;
            }
           
        }
        
        public function getClientsList(){
            
            if(strcmp( $_SESSION['user_id'], "") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_client = $db->tbl_client;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_client." WHERE user_id = :id");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                return json_encode($result);
            }else{
                return 1;
            }
           
        }
        
        private function getCCodeByClientName($clientName){
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($clientName, '') == 0) return [];
            
            try {
                $db = new DbConn;
                $tbl_client = $db->tbl_client;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_client." WHERE user_id = :id and client_name = :cname");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':cname', $clientName);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }
        
        private function getEmployeeByEcode($ecode){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ecode, '') == 0) return [];
            
            try {
                $db = new DbConn;
                $tbl_employee = $db->tbl_employee;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_employee." WHERE user_id = :id and ecode = :ecode");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ecode', $ecode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        }
        
        public function getEmployeesList(){
            
            if(strcmp( $_SESSION['user_id'], "") == 0) return 1;
            
            try {
                $db = new DbConn;
                $tbl_employee = $db->tbl_employee;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_employee." WHERE user_id = :id");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);
            
            return json_encode($result);
        }
        
        public function submitQuote($quoteDets){
            if(!is_array($quoteDets['items']) || strcmp($quoteDets['amount'], "") == 0 ||
                    strcmp($quoteDets['approvedBy1'], "") == 0 || strcmp($quoteDets['approvedBy2'], "") == 0 || 
                    strcmp($quoteDets['addedBy'], "") == 0 || strcmp($quoteDets['approvedBy1'], "Select Approver") == 0 || 
                    strcmp($quoteDets['approvedBy2'], "Select Approver") == 0 || strcmp($quoteDets['addedBy'], "Select Adder") == 0 ||
                    strcmp($quoteDets['dateOfCreation'], "") == 0 || strcmp($quoteDets['delDate'], "") == 0 ||
                    strcmp($quoteDets['estimateNo'], "") == 0 || strcmp($_SESSION['user_id'], "") == 0 || strcmp($quoteDets['ccode'], "") == 0 )
                    return 2;
            
            $datetimeNow = date("Y-m-d H:i:s");

            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
           for($idx = 0; $idx <  count($quoteDets['items']); $idx ++){ 
                $stmt = $db->conn->prepare("INSERT INTO ".$tbl_quote." (ccode, estimateCount, estimateNo, description, ppu, quantity, netValue, reimbursable, tax, totalValue, deliveryDate, creationDate, addedBy, approvedBy1, approvedBy2, added_date, user_id)
                    VALUES (:ccode, :estimateCount, :estimateNo, :description, :ppu, :quantity, :netValue, :reimbursable, :tax, :amount, :delDate, :dateOfCreation, :addedBy, :approvedBy1, :approvedBy2, :datetimenow, :id)");

                $stmt->bindParam(':ccode', $quoteDets['ccode']);
                $stmt->bindParam(':estimateCount', $quoteDets['estimateCount']);
                $stmt->bindParam(':estimateNo', $quoteDets['estimateNo']);
                $stmt->bindParam(':description', $quoteDets['items'][$idx]['description']);
                $stmt->bindParam(':ppu', $quoteDets['items'][$idx]['ppu']);
                $stmt->bindParam(':quantity', $quoteDets['items'][$idx]['quantity']);
                $stmt->bindParam(':netValue', $quoteDets['items'][$idx]['netValue']);
                $stmt->bindParam(':reimbursable', $quoteDets['items'][$idx]['reimbursable']);
                $stmt->bindParam(':tax', $quoteDets['items'][$idx]['tax']);
                $stmt->bindParam(':amount', $quoteDets['amount']);
                $stmt->bindParam(':delDate', date("Y-m-d", strtotime($quoteDets['delDate'])));

                $stmt->bindParam(':dateOfCreation', date("Y-m-d", strtotime($quoteDets['dateOfCreation'])));
                $stmt->bindParam(':addedBy', $quoteDets['addedBy']);
                $stmt->bindParam(':approvedBy1', $quoteDets['approvedBy1']);
                $stmt->bindParam(':approvedBy2', $quoteDets['approvedBy2']);
                $stmt->bindParam(':datetimenow', $datetimeNow);
                $stmt->bindParam(':id', $_SESSION['user_id']);
                $stmt->execute();
            }
            return 0;
        }

        public function getQuotes($ccode){
            
            if(strcmp( $_SESSION['user_id'], "") == 0 || strcmp($ccode, "") == 0) return 2;
            
            try {
                $db = new DbConn;
                $tbl_quote = $db->tbl_quote;
                $err = '';
            } catch (PDOException $e) {
                $err = "Error: " . $e->getMessage();
            }
 
            $stmtSr = $db->conn->prepare("SELECT * FROM ".$tbl_quote." WHERE user_id = :id and ccode = :ccode");
            $stmtSr->bindParam(':id', $_SESSION['user_id']);
            $stmtSr->bindParam(':ccode', $ccode);
            $stmtSr->execute();

            // Gets query result
            $result = $stmtSr->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result)){
                
                $data = array();
                
                for($idx = 0; $idx < count($result); $idx ++){
                    $data[$idx]['estimateNo'] = $result[$idx]['estimateNo'];
                    $data[$idx]['description'] = $result[$idx]['description'];
                    $data[$idx]['ppu'] = $result[$idx]['ppu'];
                    $data[$idx]['quantity'] = $result[$idx]['quantity'];
                    $data[$idx]['netValue'] = $result[$idx]['netValue'];
                    $data[$idx]['reimbursable'] = $result[$idx]['reimbursable'];
                    $data[$idx]['tax'] = $result[$idx]['tax'];
                    $data[$idx]['totalValue'] = $result[$idx]['totalValue'];
                    $data[$idx]['deliveryDate'] = $result[$idx]['deliveryDate'];
                    $data[$idx]['creationDate'] = $result[$idx]['creationDate'];
                    $data[$idx]['added_by'] = $this->getEmployeeByEcode($result[$idx]['addedBy'])['name'];
                    $data[$idx]['approved_by'] = $this->getEmployeeByEcode($result[$idx]['approvedBy1'])['name'].', '.$this->getEmployeeByEcode($result[$idx]['approvedBy2'])['name'];
                }
                
                $max = 0;
                for($i = 0; $i < count($result); $i++){
                    if($max < (int)$result[$i]['estimateCount']){
                        $max = (int)$result[$i]['estimateCount'];
                    }
                }
                
                $data['estimateCount'] = $max;
                
                return json_encode($data);
            }else{
                return 1;
            }
           
        }
    }
    ob_flush();
?>