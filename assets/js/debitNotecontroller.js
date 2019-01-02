fmsApp.controller('debitNoteController', ['$scope', '$http', '$timeout', '$sce', '$compile',
  function ($scope, $http, $timeout ,$sce, $compile) {

//    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    $scope.singleDN = {
        dnnum: 0,
        items: {
            adOrInOrFin: 'Select One',
            description: '',
            netValue: '',
            tax: '',
            totalValue: '',
            paymentDate: ''
        },
        dn_loader: false,
        message: '',
        employees: [],
        invList: [],
        addedBy: 'Select Adder',
        approvedBy1: 'Select Approver',
        approvedBy2: 'Select Approver',
        submitDN: function() { submitDN() },
        cancelDN: function(invNum, idx){var inv_num = invNum; var indx = idx; cancelDN(inv_num, indx);},
        getDN: function(invNum){var inv_num = invNum; getDN(inv_num);},
        clearInvSegment: function(){
                                        $scope.singleDN.items = {
                                                                        adOrInOrFin: 'Select One',
                                                                        description: '',
                                                                        netValue: '',
                                                                        tax: '',
                                                                        totalValue: '',
                                                                        paymentDate: ''
                                                                    };
                                        $scope.singleDN.dn_loader = false;
                                        $scope.singleDN.message = '';
                                        $scope.singleDN.addedBy = 'Select Adder';
                                        $scope.singleDN.approvedBy1 = 'Select Approver';
                                        $scope.singleDN.approvedBy2 = 'Select Approver';

        }

    };

    function getDN(invNum){

    };

    function cancelDN(invNum, idx){

        if(idx !== '' && invNum != '' && invNum != 0){

            $http({
                method : "POST",
                url : 'includes/debitNote',
                data : {invNum: invNum, token: "cancelDN"},
            }).success(function(response) {
                if(response == 1){
                    $scope.dn.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.dn.message = "Successfully cancelled!!";
                    $scope.singleDN.invList[idx].status = 'cancelled';
                }
            }).error(function(data) {
                $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
            });
        }else{
            $scope.dn.message = ("Something went wrong! Please try again after some time.");
        }
    };

    function submitDN(){
        if(     $scope.dn.ccode !== '' && $scope.singleDN.dn_loader === false && $scope.dn.generate === true &&
                $scope.dn.estNos !== '' && $scope.dn.estNos !== 'Estimate Number' &&
                $scope.dn.cpoNums !== '' && $scope.dn.cpoNums !== 'PO Number' &&
                $scope.singleDN.dnnum != 0 && $scope.singleDN.dnnum != '' &&
                $scope.singleDN.addedBy != '' && $scope.singleDN.addedBy != 'Select Adder' &&
                $scope.singleDN.approvedBy1 != '' && $scope.singleDN.approvedBy1 != 'Select Approver' &&
                $scope.singleDN.approvedBy2 != '' && $scope.singleDN.approvedBy2 != 'Select Approver' &&
                $scope.singleDN.items.adOrInOrFin != '' && $scope.singleDN.items.adOrInOrFin != 'Select One' &&
                $scope.singleDN.items.description != '' && $scope.singleDN.items.totalValue != 'Select One' &&
                $scope.singleDN.items.netValue != '' && $scope.singleDN.items.paymentDate != 'Select One' &&
                $scope.singleDN.items.tax != ''
            ){

            $http({
                method : "POST",
                url : 'includes/debitNote',
                data : {dn: $scope.dn, singleDN: $scope.singleDN, token: "submitDN"},
            }).success(function(response) {
                if(response == 1){
                    $scope.singleDN.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.singleDN.message = "Successfully submitted!!";
                }
                $scope.singleDN.dn_loader = false;
            }).error(function(data) {
                $scope.singleDN.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.singleDN.dn_loader = false;
            });
        }else{
            if($scope.singleDN.dn_loader === true){
                $scope.singleDN.message = ("Please wait...");
            }else if($scope.dn.generate === false){
                $scope.singleDN.message = ("DN Number not generated!");
            }else{
                $scope.singleDN.message = ("One or more fields cannot be left blank.");
            }
        }
    };

    $scope.dn = {
        tendency: false,
        primtendency : false,
        clientName: "Client Name",
        invNums: 'Invoice Number',
        cpoNums: 'PO Number',
        billingAddress: '',
        pan: '',
        gst: '',
        sac: '',
        ccode: '',
        estList : [],
        generate: false,
        dn_loader: false,
        message: '',
        generateAndAssignDNNum:function() {generateAndAssignDNNum()},
        clearEverything:    function() {clearEverything()},
        downloadPDF:        function() {downloadPDF()},
        printPDF:   function() {printPDF()},
        listup:     function(ccode, estno, cponum) {var c_code = ccode; var est_no = estno; var cpo_no = cponum; listup(c_code, est_no, cpo_no);},
        fillUp:     function(clientName, bill_add, pan, gst, sac, ccode) {
                                                                $scope.dn.ccode = ccode;
                                                                alterCPOSectionList(ccode);
                                                                $scope.dn.clientName = clientName;
                                                                $scope.dn.billingAddress = bill_add;
                                                                $scope.dn.pan = pan;
                                                                $scope.dn.gst = gst;
                                                                $scope.dn.sac = sac;
                                                            },
        fillupPos: function(ccode, cpono){var c_code = ccode; var cpo_no = cpono; alterInvSectionList(c_code, cpo_no);}
    };

    function alterInvSectionList(ccode, cpoNo){

        if($scope.dn.dn_loader === false){
            $scope.dn.dn_loader = true;
            $http({
                method : "GET",
                url : 'includes/debitNote',
                params : {token: "getInvNums", ccode: ccode, cponum: cpoNo},
            }).success(function(response) {
                if(response == 1){
                    $scope.dn.message = "Something went wrong! Please try again after some time.";
                }else{
                    console.log("INVS::",response);
                    var clNameDiv = document.getElementById('invNums');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"dn.listup('+"'"+ccode+"','"+cpoNo+"','"+value.invoiceNum+"'"+'); '+'"'+
                                '>'+value.invoiceNum+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.dn.dn_loader = false;
            }).error(function(data) {
                $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.dn.dn_loader = false;
            });
        }else{
            $scope.dn.message = ("Please wait...");
        }
    };

    function getEmployeesDetails() {

        $http({
            method : "GET",
            url : 'includes/debitNote',
            params : {token: "getEmployees"},
        }).success(function(response) {
            if(response == 1){
                $scope.dn.message = "Something went wrong! Please try again after some time.";
            }else{
                $scope.singleDN.employees = angular.copy(response);
            }
        }).error(function(data) {
            $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
        });
    };

    function alterCPOSectionList(ccode){

        listup(ccode, '', '');

        if($scope.dn.dn_loader === false){
            $scope.dn.dn_loader = true;
            $http({
                method : "GET",
                url : 'includes/debitNote',
                params : {token: "getCpoNums", ccode: ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.dn.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('cpoNums');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"dn.listup('+"'"+ccode+"','"+value.cponum+"'"+'); dn.primtendency = true; dn.fillupPos('+"'"+ccode+"','"+value.cponum+"'"+"); dn.invNums = 'Invoice Number'; "+'"'+
                                '>'+value.cponum+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.dn.dn_loader = false;
            }).error(function(data) {
                $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.dn.dn_loader = false;
            });
        }else{
            $scope.dn.message = ("Please wait...");
        }
    };

    function listup(ccode, cpoNum = '', invNum = ''){
        if(ccode == '') return;

        if(cpoNum != '')
            $scope.dn.cpoNums = cpoNum;

        if(invNum != '' && cpoNum != '')
            $scope.dn.invNums = invNum;

        $http({
            method : "GET",
            url : 'includes/debitNote',
            params : {token: "getAllInvs", ccode: ccode, invoiceNum: invNum, cpoNo: cpoNum},
        }).success(function(response) {
            if(response == 1){
                $scope.dn.message = "Something went wrong! Please try again after some time.";
            }else{
                console.log(response)
                $scope.dn.estList = angular.copy(response);
            }
        }).error(function(data) {
            $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
        });

    };

    function generateAndAssignDNNum(){
        if($scope.dn.ccode !== '' && $scope.dn.dn_loader === false && $scope.dn.generate === false &&
                $scope.dn.estNos !== '' && $scope.dn.estNos !== 'Estimate Number' &&
                $scope.dn.cpoNums !== '' && $scope.dn.cpoNums !== 'PO Number'){

            $scope.dn.dn_loader = true;
            $scope.dn.message = '';
            $scope.dn.generate = true;

            $scope.singleDN.dnnum = $scope.dn.clientName.substring(0,3)+(new Date()).getFullYear().toString()+"0"+($scope.singleDN.dnnum+1);

            $http({
                method : "GET",
                url : 'includes/debitNote',
                params : {token: "getDNDetails", ccode : $scope.dn.ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.dn.message = "Something went wrong! Please try again after some time.";
                }else{
                    $scope.singleDN.invList = angular.copy(response)
                }
                $scope.dn.dn_loader = false;
            }).error(function(data) {
                $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.dn.dn_loader = false;
            });
        }else{
            if($scope.dn.dn_loader === true){
                $scope.dn.message = ("Please wait...");
            }else if($scope.dn.generate === true){
                $scope.dn.message = ("Already Generated!");
            }else{
                $scope.dn.message = ("One or more fields cannot be left blank.");
            }
        }
    };

    function clearEverything(){
        $scope.dn.tendency = false;
        $scope.dn.generate = false;
        $scope.dn.cpoNums = 'PO Number';
        $scope.dn.ccode = '';
        $scope.dn.clientName = "Client Name";
        $scope.dn.message = '';
        $scope.dn.billingAddress = '';
        $scope.dn.pan = '';
        $scope.dn.gst = '';
        $scope.dn.sac = '';
        $scope.dn.estList = [];
        $scope.dn.primtendency = false;
        $scope.dn.estNos = "Estimate Number";
        $scope.dn.dn_loader = false;
        $scope.singleDN.dnnum = 0;
        $scope.singleDN.items = {
                                        adOrInOrFin: 'Select One',
                                        description: '',
                                        netValue: '',
                                        tax: '',
                                        totalValue: '',
                                        paymentDate: ''
                                    };
        $scope.singleDN.dn_loader = false;
        $scope.singleDN.message = '';
        $scope.singleDN.employees = [];
        $scope.singleDN.invList = [];
        $scope.singleDN.addedBy = 'Select Adder';
        $scope.singleDN.approvedBy1 = 'Select Approver';
        $scope.singleDN.approvedBy2 = 'Select Approver';
    };

    function downloadPDF(){

    };

    function printPDF(){

    };

    function getClientsList(){

        if($scope.dn.dn_loader === false){
            $scope.dn.dn_loader = true;
            $http({
                method : "GET",
                url : 'includes/debitNote',
                params : {token: "getClients"},
            }).success(function(response) {
                if(response == 1){
                    $scope.dn.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('clientNames');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"dn.fillUp('+"'"+value.client_name+"','"+value.billing_address+"','"+
                                value.PAN+"','"+value.GST+"','"+value.SAC+"','"+value.ccode+"'"+'); dn.primtendency = '+"false;"+' dn.tendency = '+"true;"+' dn.cpoNums = '+"'PO Number';"+' dn.invNums = '+"'Invoice Number';"+'"'+
                                '>'+value.client_name+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                    getEmployeesDetails();
                }
                $scope.dn.dn_loader = false;
            }).error(function(data) {
                $scope.dn.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.dn.dn_loader = false;
            });
        }else{
            $scope.dn.message = ("Please wait...");
        }
    };

    getClientsList();

  }]
);
