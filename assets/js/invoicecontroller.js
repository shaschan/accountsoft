fmsApp.controller('invoiceController', ['$scope', '$http', '$timeout', '$sce', '$compile',
  function ($scope, $http, $timeout ,$sce, $compile) {

//    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    $scope.singleInvoice = {
        invoicenum: 0,
        items: {
            adOrInOrFin: 'Select One',
            description: '',
            netValue: '',
            tax: '',
            totalValue: '',
            paymentDate: ''
        },
        invoice_loader: false,
        message: '',
        employees: [],
        invList: [],
        addedBy: 'Select Adder',
        approvedBy1: 'Select Approver',
        approvedBy2: 'Select Approver',
        submitInvoice: function() { submitInvoice() },
        cancelInvoice: function(invNum, idx){var inv_num = invNum; var indx = idx; cancelInvoice(inv_num, indx);},
        getInvoice: function(invNum){var inv_num = invNum; getInvoice(inv_num);},
        clearInvSegment: function(){     
                                        $scope.singleInvoice.items = {
                                                                        adOrInOrFin: 'Select One',
                                                                        description: '',
                                                                        netValue: '',
                                                                        tax: '',
                                                                        totalValue: '',
                                                                        paymentDate: ''
                                                                    };
                                        $scope.singleInvoice.invoice_loader = false;
                                        $scope.singleInvoice.message = '';
                                        $scope.singleInvoice.addedBy = 'Select Adder';
                                        $scope.singleInvoice.approvedBy1 = 'Select Approver';
                                        $scope.singleInvoice.approvedBy2 = 'Select Approver';
                                                                    
        }
        
    };
    
    function getInvoice(invNum){
        
    };
    
    function cancelInvoice(invNum, idx){
        
        if(idx !== '' && invNum != '' && invNum != 0){

            $http({
                method : "POST",
                url : 'includes/invoice',
                data : {invNum: invNum, token: "cancelInvoice"},
            }).success(function(response) {
                if(response == 1){
                    $scope.invoice.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.invoice.message = "Successfully cancelled!!";
                    $scope.singleInvoice.invList[idx].status = 'cancelled';
                }
            }).error(function(data) {
                $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
            });
        }else{
            $scope.invoice.message = ("Something went wrong! Please try again after some time.");
        }
    };
    
    function submitInvoice(){
        if(     $scope.invoice.ccode !== '' && $scope.singleInvoice.invoice_loader === false && $scope.invoice.generate === true &&
                $scope.invoice.estNos !== '' && $scope.invoice.estNos !== 'Estimate Number' &&
                $scope.invoice.cpoNums !== '' && $scope.invoice.cpoNums !== 'PO Number' &&
                $scope.singleInvoice.invoicenum != 0 && $scope.singleInvoice.invoicenum != '' &&
                $scope.singleInvoice.addedBy != '' && $scope.singleInvoice.addedBy != 'Select Adder' &&
                $scope.singleInvoice.approvedBy1 != '' && $scope.singleInvoice.approvedBy1 != 'Select Approver' &&
                $scope.singleInvoice.approvedBy2 != '' && $scope.singleInvoice.approvedBy2 != 'Select Approver' &&
                $scope.singleInvoice.items.adOrInOrFin != '' && $scope.singleInvoice.items.adOrInOrFin != 'Select One' &&
                $scope.singleInvoice.items.description != '' && $scope.singleInvoice.items.totalValue != 'Select One' &&
                $scope.singleInvoice.items.netValue != '' && $scope.singleInvoice.items.paymentDate != 'Select One' &&
                $scope.singleInvoice.items.tax != ''
            ){
                
            $http({
                method : "POST",
                url : 'includes/invoice',
                data : {invoice: $scope.invoice, singleInvoice: $scope.singleInvoice, token: "submitInvoice"},
            }).success(function(response) {
                if(response == 1){
                    $scope.singleInvoice.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.singleInvoice.message = "Successfully submitted!!";
                }
                $scope.singleInvoice.invoice_loader = false;
            }).error(function(data) {
                $scope.singleInvoice.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.singleInvoice.invoice_loader = false;
            });
        }else{
            if($scope.singleInvoice.invoice_loader === true){
                $scope.singleInvoice.message = ("Please wait...");
            }else if($scope.invoice.generate === false){
                $scope.singleInvoice.message = ("Invoice Number not generated!");
            }else{
                $scope.singleInvoice.message = ("One or more fields cannot be left blank.");
            }
        }
    };
    
    $scope.invoice = {
        tendency: false,
        primtendency : false,
        clientName: "Client Name",
        estNos: 'Estimate Number',
        cpoNums: 'PO Number',
        billingAddress: '',
        pan: '',
        gst: '',
        sac: '',
        ccode: '',
        generate: false,
        invoice_loader: false,
        message: '',
        estList: [],
        generateAndAssignInvoiceNum:function() {generateAndAssignInvoiceNum()},
        clearEverything:    function() {clearEverything()},
        downloadPDF:        function() {downloadPDF()},
        printPDF:   function() {printPDF()},
        listup:     function(ccode, estno, cponum) {var c_code = ccode; var est_no = estno; var cpo_no = cponum; listup(c_code, est_no, cpo_no);},
        fillUp:     function(clientName, bill_add, pan, gst, sac, ccode) {
                                                                $scope.invoice.ccode = ccode;
                                                                alterEstSectionList(ccode);
                                                                $scope.invoice.clientName = clientName;
                                                                $scope.invoice.billingAddress = bill_add;
                                                                $scope.invoice.pan = pan;
                                                                $scope.invoice.gst = gst;
                                                                $scope.invoice.sac = sac;
                                                            },
        fillupPos: function(ccode, estno){var c_code = ccode; var est_no = estno; alterCPOSectionList(c_code, est_no);}
    };
    
    function alterCPOSectionList(ccode, estNo){
        
        if($scope.invoice.invoice_loader === false){
            $scope.invoice.invoice_loader = true;
            $http({
                method : "GET",
                url : 'includes/invoice',
                params : {token: "getCpoNums", ccode: ccode, estimateNo: estNo},
            }).success(function(response) {
                if(response == 1){
                    $scope.invoice.message = "Something went wrong! Please try again after some time.";
                }else{
                    console.log("CPOS::",response);
                    var clNameDiv = document.getElementById('cpoNums');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"invoice.listup('+"'"+ccode+"','"+estNo+"','"+value.cponum+"'"+'); '+'"'+
                                '>'+value.cponum+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.invoice.invoice_loader = false;
            }).error(function(data) {
                $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.invoice.invoice_loader = false;
            });
        }else{
            $scope.invoice.message = ("Please wait...");
        }
    };
    
    function getEmployeesDetails() {
        
        $http({
            method : "GET",
            url : 'includes/invoice',
            params : {token: "getEmployees"},
        }).success(function(response) {
            if(response == 1){
                $scope.invoice.message = "Something went wrong! Please try again after some time.";
            }else{
                $scope.singleInvoice.employees = angular.copy(response);
            }
        }).error(function(data) {
            $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
        });
    };
    
    function alterEstSectionList(ccode){
        
        listup(ccode, '', '');
        
        if($scope.invoice.invoice_loader === false){
            $scope.invoice.invoice_loader = true;
            $http({
                method : "GET",
                url : 'includes/invoice',
                params : {token: "getEstNos", ccode: ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.invoice.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('estNos');
                    var invCount = 0;
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"invoice.listup('+"'"+ccode+"','"+value.estimateNo+"'"+'); invoice.primtendency = true; invoice.fillupPos('+"'"+ccode+"','"+value.estimateNo+"'"+"); invoice.cpoNums = 'PO Number'; "+'"'+
                                '>'+value.estimateNo+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                        
                        if(value.invoiceNum != ''){
                            invCount++;
                        }
                    });
                    $scope.singleInvoice.invoicenum = invCount;
                }
                $scope.invoice.invoice_loader = false;
            }).error(function(data) {
                $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.invoice.invoice_loader = false;
            });
        }else{
            $scope.invoice.message = ("Please wait...");
        }
    };
    
    function listup(ccode, estNo = '', cpoNum = ''){
        if(ccode == '') return;

        if(estNo != '')
            $scope.invoice.estNos = estNo;
        
        if(estNo != '' && cpoNum != '')
            $scope.invoice.cpoNums = cpoNum;
        
        $http({
            method : "GET",
            url : 'includes/invoice',
            params : {token: "getAllEstm", ccode: ccode, estimateNo: estNo, cpoNo: cpoNum},
        }).success(function(response) {
            if(response == 1){
                $scope.invoice.message = "Something went wrong! Please try again after some time.";
            }else{
                console.log(response)
                $scope.invoice.estList = angular.copy(response);
            }
        }).error(function(data) {
            $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
        });
        
    };
    
    function generateAndAssignInvoiceNum(){
        if($scope.invoice.ccode !== '' && $scope.invoice.invoice_loader === false && $scope.invoice.generate === false &&
                $scope.invoice.estNos !== '' && $scope.invoice.estNos !== 'Estimate Number' &&
                $scope.invoice.cpoNums !== '' && $scope.invoice.cpoNums !== 'PO Number'){

            $scope.invoice.invoice_loader = true;
            $scope.invoice.message = '';
            $scope.invoice.generate = true;
            
            $scope.singleInvoice.invoicenum = $scope.invoice.clientName.substring(0,3)+(new Date()).getFullYear().toString()+"0"+($scope.singleInvoice.invoicenum+1);
            
            $http({
                method : "GET",
                url : 'includes/invoice',
                params : {token: "getInvoiceDetails", ccode : $scope.invoice.ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.invoice.message = "Something went wrong! Please try again after some time.";
                }else{
                    $scope.singleInvoice.invList = angular.copy(response)
                }
                $scope.invoice.invoice_loader = false;
            }).error(function(data) {
                $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.invoice.invoice_loader = false;
            });
        }else{
            if($scope.invoice.invoice_loader === true){
                $scope.invoice.message = ("Please wait...");
            }else if($scope.invoice.generate === true){
                $scope.invoice.message = ("Already Generated!");
            }else{
                $scope.invoice.message = ("One or more fields cannot be left blank.");
            }
        }
    };
      
    function clearEverything(){
        $scope.invoice.tendency = false;
        $scope.invoice.generate = false;
        $scope.invoice.cpoNums = 'PO Number';
        $scope.invoice.ccode = '';
        $scope.invoice.clientName = "Client Name";
        $scope.invoice.message = '';
        $scope.invoice.billingAddress = '';
        $scope.invoice.pan = '';
        $scope.invoice.gst = '';
        $scope.invoice.sac = '';
        $scope.invoice.estList = [];
        $scope.invoice.primtendency = false;
        $scope.invoice.estNos = "Estimate Number";
        $scope.invoice.invoice_loader = false;
        $scope.singleInvoice.invoicenum = 0;
        $scope.singleInvoice.items = {
                                        adOrInOrFin: 'Select One',
                                        description: '',
                                        netValue: '',
                                        tax: '',
                                        totalValue: '',
                                        paymentDate: ''
                                    };
        $scope.singleInvoice.invoice_loader = false;
        $scope.singleInvoice.message = '';
        $scope.singleInvoice.employees = [];
        $scope.singleInvoice.invList = [];
        $scope.singleInvoice.addedBy = 'Select Adder';
        $scope.singleInvoice.approvedBy1 = 'Select Approver';
        $scope.singleInvoice.approvedBy2 = 'Select Approver';
    };  
    
    function downloadPDF(){
        
    };
    
    function printPDF(){
        
    };
    
    function getClientsList(){
        
        if($scope.invoice.invoice_loader === false){
            $scope.invoice.invoice_loader = true;
            $http({
                method : "GET",
                url : 'includes/invoice',
                params : {token: "getClients"},
            }).success(function(response) {
                if(response == 1){
                    $scope.invoice.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('clientNames');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"invoice.fillUp('+"'"+value.client_name+"','"+value.billing_address+"','"+
                                value.PAN+"','"+value.GST+"','"+value.SAC+"','"+value.ccode+"'"+'); invoice.primtendency = '+"false;"+' invoice.tendency = '+"true;"+' invoice.cpoNums = '+"'PO Number';"+' invoice.estNos = '+"'Estimate Number';"+'"'+
                                '>'+value.client_name+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                    getEmployeesDetails();
                }
                $scope.invoice.invoice_loader = false;
            }).error(function(data) {
                $scope.invoice.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.invoice.invoice_loader = false;
            });
        }else{
            $scope.invoice.message = ("Please wait...");
        }
    };
    
    getClientsList();
    
  }]
);