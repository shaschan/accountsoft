fmsApp.controller('creditNoteController', ['$scope', '$http', '$timeout', '$sce', '$compile',
  function ($scope, $http, $timeout ,$sce, $compile) {

//    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    $scope.singleCN = {
        cnnum: 0,
        items: {
            adOrInOrFin: 'Select One',
            description: '',
            netValue: '',
            tax: '',
            totalValue: '',
            paymentDate: ''
        },
        cn_loader: false,
        message: '',
        employees: [],
        invList: [],
        addedBy: 'Select Adder',
        approvedBy1: 'Select Approver',
        approvedBy2: 'Select Approver',
        submitCN: function() { submitCN() },
        cancelCN: function(invNum, idx){var inv_num = invNum; var indx = idx; cancelCN(inv_num, indx);},
        getCN: function(invNum){var inv_num = invNum; getCN(inv_num);},
        clearInvSegment: function(){     
                                        $scope.singleCN.items = {
                                                                        adOrInOrFin: 'Select One',
                                                                        description: '',
                                                                        netValue: '',
                                                                        tax: '',
                                                                        totalValue: '',
                                                                        paymentDate: ''
                                                                    };
                                        $scope.singleCN.cn_loader = false;
                                        $scope.singleCN.message = '';
                                        $scope.singleCN.addedBy = 'Select Adder';
                                        $scope.singleCN.approvedBy1 = 'Select Approver';
                                        $scope.singleCN.approvedBy2 = 'Select Approver';
                                                                    
        }
        
    };
    
    function getCN(invNum){
        
    };
    
    function cancelCN(invNum, idx){
        
        if(idx !== '' && invNum != '' && invNum != 0){

            $http({
                method : "POST",
                url : 'includes/cn',
                data : {invNum: invNum, token: "cancelCN"},
            }).success(function(response) {
                if(response == 1){
                    $scope.cn.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.cn.message = "Successfully cancelled!!";
                    $scope.singleCN.invList[idx].status = 'cancelled';
                }
            }).error(function(data) {
                $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
            });
        }else{
            $scope.cn.message = ("Something went wrong! Please try again after some time.");
        }
    };
    
    function submitCN(){
        if(     $scope.cn.ccode !== '' && $scope.singleCN.cn_loader === false && $scope.cn.generate === true &&
                $scope.cn.estNos !== '' && $scope.cn.estNos !== 'Estimate Number' &&
                $scope.cn.cpoNums !== '' && $scope.cn.cpoNums !== 'PO Number' &&
                $scope.singleCN.cnnum != 0 && $scope.singleCN.cnnum != '' &&
                $scope.singleCN.addedBy != '' && $scope.singleCN.addedBy != 'Select Adder' &&
                $scope.singleCN.approvedBy1 != '' && $scope.singleCN.approvedBy1 != 'Select Approver' &&
                $scope.singleCN.approvedBy2 != '' && $scope.singleCN.approvedBy2 != 'Select Approver' &&
                $scope.singleCN.items.adOrInOrFin != '' && $scope.singleCN.items.adOrInOrFin != 'Select One' &&
                $scope.singleCN.items.description != '' && $scope.singleCN.items.totalValue != 'Select One' &&
                $scope.singleCN.items.netValue != '' && $scope.singleCN.items.paymentDate != 'Select One' &&
                $scope.singleCN.items.tax != ''
            ){
                
            $http({
                method : "POST",
                url : 'includes/cn',
                data : {cn: $scope.cn, singleCN: $scope.singleCN, token: "submitCN"},
            }).success(function(response) {
                if(response == 1){
                    $scope.singleCN.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.singleCN.message = "Successfully submitted!!";
                }
                $scope.singleCN.cn_loader = false;
            }).error(function(data) {
                $scope.singleCN.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.singleCN.cn_loader = false;
            });
        }else{
            if($scope.singleCN.cn_loader === true){
                $scope.singleCN.message = ("Please wait...");
            }else if($scope.cn.generate === false){
                $scope.singleCN.message = ("CN Number not generated!");
            }else{
                $scope.singleCN.message = ("One or more fields cannot be left blank.");
            }
        }
    };
    
    $scope.cn = {
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
        cn_loader: false,
        message: '',
        estList: [],
        generateAndAssignCNNum:function() {generateAndAssignCNNum()},
        clearEverything:    function() {clearEverything()},
        downloadPDF:        function() {downloadPDF()},
        printPDF:   function() {printPDF()},
        listup:     function(ccode, estno, cponum) {var c_code = ccode; var est_no = estno; var cpo_no = cponum; listup(c_code, est_no, cpo_no);},
        fillUp:     function(clientName, bill_add, pan, gst, sac, ccode) {
                                                                $scope.cn.ccode = ccode;
                                                                alterEstSectionList(ccode);
                                                                $scope.cn.clientName = clientName;
                                                                $scope.cn.billingAddress = bill_add;
                                                                $scope.cn.pan = pan;
                                                                $scope.cn.gst = gst;
                                                                $scope.cn.sac = sac;
                                                            },
        fillupPos: function(ccode, estno){var c_code = ccode; var est_no = estno; alterCPOSectionList(c_code, est_no);}
    };
    
    function alterCPOSectionList(ccode, estNo){
        
        if($scope.cn.cn_loader === false){
            $scope.cn.cn_loader = true;
            $http({
                method : "GET",
                url : 'includes/cn',
                params : {token: "getCpoNums", ccode: ccode, estimateNo: estNo},
            }).success(function(response) {
                if(response == 1){
                    $scope.cn.message = "Something went wrong! Please try again after some time.";
                }else{
                    console.log("CPOS::",response);
                    var clNameDiv = document.getElementById('cpoNums');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"cn.listup('+"'"+ccode+"','"+estNo+"','"+value.cponum+"'"+'); '+'"'+
                                '>'+value.cponum+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.cn.cn_loader = false;
            }).error(function(data) {
                $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cn.cn_loader = false;
            });
        }else{
            $scope.cn.message = ("Please wait...");
        }
    };
    
    function getEmployeesDetails() {
        
        $http({
            method : "GET",
            url : 'includes/cn',
            params : {token: "getEmployees"},
        }).success(function(response) {
            if(response == 1){
                $scope.cn.message = "Something went wrong! Please try again after some time.";
            }else{
                $scope.singleCN.employees = angular.copy(response);
            }
        }).error(function(data) {
            $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
        });
    };
    
    function alterEstSectionList(ccode){
        
        listup(ccode, '', '');
        
        if($scope.cn.cn_loader === false){
            $scope.cn.cn_loader = true;
            $http({
                method : "GET",
                url : 'includes/cn',
                params : {token: "getEstNos", ccode: ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.cn.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('estNos');
                    var invCount = 0;
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"cn.listup('+"'"+ccode+"','"+value.estimateNo+"'"+'); cn.primtendency = true; cn.fillupPos('+"'"+ccode+"','"+value.estimateNo+"'"+"); cn.cpoNums = 'PO Number'; "+'"'+
                                '>'+value.estimateNo+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                        
                        if(value.cnNum != ''){
                            invCount++;
                        }
                    });
                    $scope.singleCN.cnnum = invCount;
                }
                $scope.cn.cn_loader = false;
            }).error(function(data) {
                $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cn.cn_loader = false;
            });
        }else{
            $scope.cn.message = ("Please wait...");
        }
    };
    
    function listup(ccode, estNo = '', cpoNum = ''){
        if(ccode == '') return;

        if(estNo != '')
            $scope.cn.estNos = estNo;
        
        if(estNo != '' && cpoNum != '')
            $scope.cn.cpoNums = cpoNum;
        
        $http({
            method : "GET",
            url : 'includes/cn',
            params : {token: "getAllEstm", ccode: ccode, estimateNo: estNo, cpoNo: cpoNum},
        }).success(function(response) {
            if(response == 1){
                $scope.cn.message = "Something went wrong! Please try again after some time.";
            }else{
                console.log(response)
                $scope.cn.estList = angular.copy(response);
            }
        }).error(function(data) {
            $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
        });
        
    };
    
    function generateAndAssignCNNum(){
        if($scope.cn.ccode !== '' && $scope.cn.cn_loader === false && $scope.cn.generate === false &&
                $scope.cn.estNos !== '' && $scope.cn.estNos !== 'Estimate Number' &&
                $scope.cn.cpoNums !== '' && $scope.cn.cpoNums !== 'PO Number'){

            $scope.cn.cn_loader = true;
            $scope.cn.message = '';
            $scope.cn.generate = true;
            
            $scope.singleCN.cnnum = $scope.cn.clientName.substring(0,3)+(new Date()).getFullYear().toString()+"0"+($scope.singleCN.cnnum+1);
            
            $http({
                method : "GET",
                url : 'includes/cn',
                params : {token: "getCNDetails", ccode : $scope.cn.ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.cn.message = "Something went wrong! Please try again after some time.";
                }else{
                    $scope.singleCN.invList = angular.copy(response)
                }
                $scope.cn.cn_loader = false;
            }).error(function(data) {
                $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cn.cn_loader = false;
            });
        }else{
            if($scope.cn.cn_loader === true){
                $scope.cn.message = ("Please wait...");
            }else if($scope.cn.generate === true){
                $scope.cn.message = ("Already Generated!");
            }else{
                $scope.cn.message = ("One or more fields cannot be left blank.");
            }
        }
    };
      
    function clearEverything(){
        $scope.cn.tendency = false;
        $scope.cn.generate = false;
        $scope.cn.cpoNums = 'PO Number';
        $scope.cn.ccode = '';
        $scope.cn.clientName = "Client Name";
        $scope.cn.message = '';
        $scope.cn.billingAddress = '';
        $scope.cn.pan = '';
        $scope.cn.gst = '';
        $scope.cn.sac = '';
        $scope.cn.estList = [];
        $scope.cn.primtendency = false;
        $scope.cn.estNos = "Estimate Number";
        $scope.cn.cn_loader = false;
        $scope.singleCN.cnnum = 0;
        $scope.singleCN.items = {
                                        adOrInOrFin: 'Select One',
                                        description: '',
                                        netValue: '',
                                        tax: '',
                                        totalValue: '',
                                        paymentDate: ''
                                    };
        $scope.singleCN.cn_loader = false;
        $scope.singleCN.message = '';
        $scope.singleCN.employees = [];
        $scope.singleCN.invList = [];
        $scope.singleCN.addedBy = 'Select Adder';
        $scope.singleCN.approvedBy1 = 'Select Approver';
        $scope.singleCN.approvedBy2 = 'Select Approver';
    };  
    
    function downloadPDF(){
        
    };
    
    function printPDF(){
        
    };
    
    function getClientsList(){
        
        if($scope.cn.cn_loader === false){
            $scope.cn.cn_loader = true;
            $http({
                method : "GET",
                url : 'includes/cn',
                params : {token: "getClients"},
            }).success(function(response) {
                if(response == 1){
                    $scope.cn.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('clientNames');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"cn.fillUp('+"'"+value.client_name+"','"+value.billing_address+"','"+
                                value.PAN+"','"+value.GST+"','"+value.SAC+"','"+value.ccode+"'"+'); cn.primtendency = '+"false;"+' cn.tendency = '+"true;"+' cn.cpoNums = '+"'PO Number';"+' cn.estNos = '+"'Estimate Number';"+'"'+
                                '>'+value.client_name+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                    getEmployeesDetails();
                }
                $scope.cn.cn_loader = false;
            }).error(function(data) {
                $scope.cn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cn.cn_loader = false;
            });
        }else{
            $scope.cn.message = ("Please wait...");
        }
    };
    
    getClientsList();
    
  }]
);