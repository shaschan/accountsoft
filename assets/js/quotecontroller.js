fmsApp.controller('quoteController', ['$scope', '$http', '$timeout', '$sce', '$compile',
  function ($scope, $http, $timeout ,$sce, $compile) {

//    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    $scope.quote = {
        tendency: true,
        clientName: "Client Name",
        emails: '',
        dateOfCreation: '',
        billingAddress: '',
        ccode: '',
        pan: '',
        gst: '',
        sac: '',
        delDate: '',
        amount: '',
        quoted : false,
        raiseQ: false,
        quote_loader: false,
        message: '',
        edit: false,
        saveorup: "Save",
        addorUpClient: function() {addorUpClient()},
        clearEverything: function() {clearEverything()},
        downloadPDF: function() {downloadPDF()},
        printPDF: function() {printPDF()},
        raiseQuote: function() {raiseQuote()},
        editClient: function() {editClient()},
        fillUp:     function(client, emails, bill_add, pan, gst, sac, ccode) { $scope.quote.clientName = client;
                                                                        $scope.quote.emails = emails;
                                                                        $scope.quote.billingAddress = bill_add;
                                                                        $scope.quote.pan = pan;
                                                                        $scope.quote.ccode = ccode;
                                                                        $scope.quote.gst = gst;
                                                                        $scope.quote.sac = sac;
                                                                      }
    };
    
    $scope.quoted ={
        
    };
    
    function checkIfSingQutItemsIsEmpty(jsArr){//eg pass singlequote.items
        if(jsArr == '') return false;
        
        if(angular.isArray(jsArr)){
            var result = true;
            angular.forEach(jsArr, function(value, key) {
                if(value.description == '' || value.reimbursable == '' || value.ppu == ''
                        || value.quantity == '' || value.netValue == '' || value.tax == '')
                    result = false;
            });
            return result;
        }else{
            return false;
        }
    };
    
    $scope.singlequote = {
        estimateNo: "",
        items : [],
        quote_loader: false,
        message: '',
        employees: [],
        addedBy: 'Select Adder',
        approvedBy1: 'Select Approver',
        approvedBy2: 'Select Approver',
        submitQuote: function() {submitQuote()},
        add : function(){$scope.singlequote.items.push({    description: "",
                                                            reimbursable: "",
                                                            ppu: "",
                                                            quantity: "",
                                                            netValue: "",
                                                            tax: "",
                                                        });
                        },
        del : function(i){$scope.singlequote.items.splice(i,1);}
    };
    
    
    function getEmployeesDetails(){
        //get current date
        var today = new Date();

        //get current month
        var curMonth = today.getMonth();

        var fiscalYr = "";
        if (curMonth > 3) { //
            var nextYr1 = (today.getFullYear() + 1).toString();
            fiscalYr = today.getFullYear().toString() + "-" + nextYr1.charAt(2) + nextYr1.charAt(3);
        } else {
            var nextYr2 = today.getFullYear().toString();
            fiscalYr = (today.getFullYear() - 1).toString() + "-" + nextYr2.charAt(2) + nextYr2.charAt(3);
        }
        
        $scope.singlequote.estimateNo = $scope.quote.clientName.substring(0,3)+"/"+fiscalYr+"/"+($scope.quoted.estimateCount+1);
                
        if($scope.quote.quote_loader === false){
            $scope.quote.quote_loader = true;
            $http({
                method : "GET",
                url : 'includes/quote',
                params : {token: "getEmployees"},
            }).success(function(response) {
                if(response == 1){
                    $scope.quote.message = "Something went wrong! Please try again after some time.";
                }else{
                    $scope.singlequote.employees = angular.copy(response);
                }
                $scope.quote.quote_loader = false;
            }).error(function(data) {
                $scope.quote.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.quote.quote_loader = false;
            });
        }else{
            $scope.quote.message = ("Please wait...");
        }
    };
    
    function submitQuote(){
        if($scope.singlequote.estimateNo !== '' && checkIfSingQutItemsIsEmpty($scope.singlequote.items) && $scope.singlequote.addedBy !== "" && $scope.singlequote.addedBy !== "Select Adder"
                && $scope.singlequote.approvedBy1 !== '' && $scope.singlequote.approvedBy1 !== 'Select Approver' && $scope.singlequote.approvedBy2 !== '' && $scope.singlequote.approvedBy2 !== 'Select Approver' && $scope.singlequote.quote_loader === false){
            
            var moreData = {
                dateOfCreation : $scope.quote.dateOfCreation,
                delDate : $scope.quote.delDate,
                amount : $scope.quote.amount,
                ccode : $scope.quote.ccode,
                estimateCount : ($scope.quoted.estimateCount+1)
            };
            
            moreData = angular.extend(moreData,$scope.singlequote);

            $scope.singlequote.quote_loader = true;
            $scope.singlequote.message = '';
            $http({
                method : "POST",
                url : 'includes/quote',
                data : {quoteData: moreData, token: "submitQuote"},
            }).success(function(response) {
                if(response == 0){
                    $scope.singlequote.message = "Successfully saved!! Reload the page!!";
                    //location.reload();
                    //$scope.singlequote.quote_loader = false;
                }else{
                    $scope.singlequote.message = "Something went wrong. Please try again!";
                    $scope.singlequote.quote_loader = false;
                }
            }).error(function(data) {
                $scope.singlequote.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.singlequote.quote_loader = false;
            });
        }else{
            if($scope.singlequote.quote_loader === true){
                $scope.singlequote.message = ("Please wait...or Reload the page!!");
            }else{
                $scope.singlequote.message = ("One or more fields cannot be left blank.");
            }
        }
    };
    
    function editClient(){
        $scope.quote.raiseQ = false;
        $scope.quote.quote_loader = false;
        $scope.quote.message = '';
        $scope.quote.tendency = false;
        $scope.quote.edit = true;
        $scope.quote.saveorup = "Update";
    };
    
    function raiseQuote(){
        if($scope.quote.clientName !== 'Client Name' && $scope.quote.clientName !== '' && $scope.quote.emails !== '' && $scope.quote.billingAddress !== '' 
                && $scope.quote.pan !== '' && $scope.quote.gst !== '' && $scope.quote.sac !== '' && $scope.quote.ccode !== ''
                && $scope.quote.dateOfCreation !== '' && $scope.quote.delDate !== '' && $scope.quote.amount !== ''){

            $scope.quote.message = "";
            $scope.quote.tendency = true;
            $scope.quote.raiseQ = false;
            $scope.quote.quoted = true;
            
            if($scope.quote.quote_loader === false){
                $scope.quote.quote_loader = true;
                $http({
                    method : "GET",
                    url : 'includes/quote',
                    params : {token: "getQuotes", ccode: $scope.quote.ccode},
                }).success(function(response) {
                    if(response == 1){
                        $scope.quote.message = "Something went wrong! Please try again after some time.";
                    }else{
                        $scope.quoted = angular.copy(response);
                    }
                    $scope.quote.quote_loader = false;
                    getEmployeesDetails();
                }).error(function(data) {
                    $scope.quote.message = ("Something went wrong! Please try again after some time. "+data);
                    $scope.quote.quote_loader = false;
                });
            }else{
                $scope.quote.message = ("Please wait...");
            }
            
        }else{
            $scope.quote.message = ("One or more fields cannot be left blank.");
        }
    };
    
    function addorUpClient(){
        if($scope.quote.clientName !== 'Client Name' && $scope.quote.clientName !== ''  && $scope.quote.emails !== '' && $scope.quote.billingAddress !== '' 
                && $scope.quote.pan !== '' && $scope.quote.gst !== '' && $scope.quote.sac !== '' && $scope.quote.ccode !== ""
                && $scope.quote.quote_loader === false){

            $scope.quote.raiseQ = false;
            $scope.quote.quote_loader = true;
            $scope.quote.message = '';
            var token = ($scope.quote.edit)? 'updateClient' : 'createClient';
            var errMsg = ($scope.quote.edit)? "Update failed, Please try after sometime..": "Save failed, Please try after sometime..";
            var succMsg = ($scope.quote.edit)? "Update Successful!!" : "Client registered successfully. Raise quote now.";
            $http({
                method : "POST",
                url : 'includes/quote',
                data : {client: $scope.quote, token: token},
            }).success(function(response) {
                if(response == 1){
                    $scope.quote.message = (errMsg);
                }else if(response == 0){
                    $scope.quote.message = (succMsg);
                    $scope.quote.raiseQ = true;
                    $scope.quote.tendency = true;
                }else{
                    $scope.quote.message = ("Company with same name/code already exists! Please try again with a different name or <span style='cursor:pointer; color: blue;' ng-click='quote.editClient()'>click here</span> to edit.");
                }
                $scope.quote.quote_loader = false;
            }).error(function(data) {
                $scope.quote.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.quote.quote_loader = false;
            });
        }else{
            if($scope.quote.quote_loader === true){
                $scope.quote.message = ("Please wait...");
            }else{
                $scope.quote.message = ("One or more fields cannot be left blank.");
            }
        }
    };
      
    function clearEverything(){
        $scope.quote.tendency = true;
        $scope.quote.raiseQ = false;
        $scope.quote.edit = false;
        $scope.quote.quoted = false;
        $scope.quote.quote_loader = false;
        $scope.quote.clientName = "Client Name";
        $scope.quote.message = '';
        $scope.quote.emails = '';
        $scope.quote.dateOfCreation = '';
        $scope.quote.billingAddress = '';
        $scope.quote.pan = '';
        $scope.quote.ccode = '';
        $scope.quote.gst = '';
        $scope.quote.sac = '';
        $scope.quote.delDate = '';
        $scope.quote.amount = '';
        $scope.quote.saveorup = "Save";
        $scope.singlequote.estimateNo = "";
        $scope.singlequote.employees = [];
        $scope.singlequote.items = [];
        $scope.singlequote.quote_loader = false;
        $scope.singlequote.message = '';
        $scope.singlequote.addedBy = 'Select Adder';
        $scope.singlequote.approvedBy1 = 'Select Approver';
        $scope.singlequote.approvedBy2 = 'Select Approver';
    };  
    
    function downloadPDF(){
        
    };
    
    function printPDF(){
        
    };
    
    function getClientsList(){
        
        if($scope.quote.quote_loader === false){
            $scope.quote.quote_loader = true;
            $http({
                method : "GET",
                url : 'includes/quote',
                params : {token: "getClients"},
            }).success(function(response) {
                if(response == 1){
                    $scope.quote.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('clientNames');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"quote.fillUp('+"'"+value.client_name+"','"+value.emails+"','"+value.billing_address+"','"+
                                value.PAN+"','"+value.GST+"','"+value.SAC+"','"+value.ccode+"'"+'); quote.tendency = '+"'true'"+'; quote.raiseQ = '+"'true';"+'"'+
                                '>'+value.client_name+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.quote.quote_loader = false;
            }).error(function(data) {
                $scope.quote.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.quote.quote_loader = false;
            });
        }else{
            $scope.quote.message = ("Please wait...");
        }
    };
    
    getClientsList();
    
  }]
);