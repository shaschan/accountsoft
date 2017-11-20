fmsApp.controller('cpoController', ['$scope', '$http', '$timeout', '$sce', '$compile',
  function ($scope, $http, $timeout ,$sce, $compile) {

//    $http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    $scope.cpo = {
        tendency: false,
        primtendency : true,
        clientName: "Client Name",
        billingAddress: '',
        pan: '',
        gst: '',
        sac: '',
        cponum: '',
        ccode: '',
        pc: '',
        generate: false,
        cpo_loader: false,
        message: '',
        estNos: 'Estimate Number',
        estList: [],
        generateAndAssignPC:function() {generateAndAssignPC()},
        clearEverything:    function() {clearEverything()},
        downloadPDF:        function() {downloadPDF()},
        printPDF:   function() {printPDF()},
        listup:     function(ccode, estno) {var c_code = ccode; var est_no = estno; listup(c_code, est_no);},
        fillUp:     function(clientName, bill_add, pan, gst, sac, ccode) {
                                                                $scope.cpo.ccode = ccode;
                                                                alterEstSectionList(ccode);
                                                                $scope.cpo.clientName = clientName;
                                                                $scope.cpo.billingAddress = bill_add;
                                                                $scope.cpo.pan = pan;
                                                                $scope.cpo.gst = gst;
                                                                $scope.cpo.sac = sac;
                                                            }
    };
    
    function alterEstSectionList(ccode){
        
        listup(ccode,'');
        
        if($scope.cpo.cpo_loader === false){
            $scope.cpo.cpo_loader = true;
            $http({
                method : "GET",
                url : 'includes/cpo',
                params : {token: "getEstNos", ccode: ccode},
            }).success(function(response) {
                if(response == 1){
                    $scope.cpo.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('estNos');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"cpo.listup('+"'"+ccode+"','"+value.estimateNo+"'"+'); cpo.primtendency = '+"'false';"+'"'+
                                '>'+value.estimateNo+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.cpo.cpo_loader = false;
            }).error(function(data) {
                $scope.cpo.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cpo.cpo_loader = false;
            });
        }else{
            $scope.cpo.message = ("Please wait...");
        }
    };
    
    function listup(ccode, estNo){
        if(ccode == '') return;

        if(estNo != '')
            $scope.cpo.estNos = estNo;
        
        $http({
            method : "GET",
            url : 'includes/cpo',
            params : {token: "getAllEstm", ccode: ccode, estimateNo: estNo},
        }).success(function(response) {
            if(response == 1){
                $scope.cpo.message = "Something went wrong! Please try again after some time.";
            }else{
                console.log(response)
                $scope.cpo.estList = angular.copy(response);
            }
        }).error(function(data) {
            $scope.cpo.message = ("Something went wrong! Please try again after some time. "+data);
        });
        
    };
    
    function generateAndAssignPC(){
        if($scope.cpo.ccode !== '' && $scope.cpo.cpo_loader === false && 
                $scope.cpo.estNos !== '' && $scope.cpo.estNos !== 'Estimate Number' &&
                $scope.cpo.cponum !== ''){

            $scope.cpo.cpo_loader = true;
            
            $scope.cpo.pc = $scope.cpo.clientName.substring(0,3)+'/'+$scope.cpo.cponum.substring(0,5);
            
            $http({
                method : "POST",
                url : 'includes/cpo',
                data : {ccode: $scope.cpo.ccode, estNo: $scope.cpo.estNos, cponum: $scope.cpo.cponum, pc: $scope.cpo.pc, token: "generateAndAssignPC"},
            }).success(function(response) {
                if(response == 1){
                    $scope.cpo.message = "Something went wrong! Please try again after some time";
                }else{
                    $scope.cpo.message = "Successfully generated and assigned!!";
                    $scope.cpo.generate = true;
                    $scope.cpo.primtendency = 'true';
                    $scope.cpo.cpo_loader = false;
                }
                $scope.cpo.quote_loader = false;
            }).error(function(data) {
                $scope.cpo.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cpo.cpo_loader = false;
            });
        }else{
            if($scope.cpo.cpo_loader === true){
                $scope.cpo.message = ("Please wait...");
            }else{
                $scope.cpo.message = ("One or more fields cannot be left blank.");
            }
        }
    };
      
    function clearEverything(){
        $scope.cpo.tendency = false;
        $scope.cpo.generate = false;
        $scope.cpo.cponum = '';
        $scope.cpo.pc = '';
        $scope.cpo.ccode = '';
        $scope.cpo.clientName = "Client Name";
        $scope.cpo.message = '';
        $scope.cpo.billingAddress = '';
        $scope.cpo.pan = '';
        $scope.cpo.gst = '';
        $scope.cpo.sac = '';
        $scope.cpo.estList = [];
        $scope.cpo.primtendency = true;
        $scope.cpo.estNos = "Estimate Number";
        $scope.cpo.cpo_loader = false;
    };  
    
    function downloadPDF(){
        
    };
    
    function printPDF(){
        
    };
    
    function getClientsList(){
        
        if($scope.cpo.cpo_loader === false){
            $scope.cpo.cpo_loader = true;
            $http({
                method : "GET",
                url : 'includes/cpo',
                params : {token: "getClients"},
            }).success(function(response) {
                if(response == 1){
                    $scope.cpo.message = "Something went wrong! Please try again after some time.";
                }else{
                    var clNameDiv = document.getElementById('clientNames');
                    angular.element(clNameDiv).empty();
                    angular.forEach(response, function(value, key) {
                        var html = '<li style="cursor: pointer; padding: 8px;" ng-click='+
                                '"cpo.fillUp('+"'"+value.client_name+"','"+value.billing_address+"','"+
                                value.PAN+"','"+value.GST+"','"+value.SAC+"','"+value.ccode+"'"+'); cpo.primtendency = '+"'true';"+' cpo.tendency = '+"'true';"+' cpo.estNos = '+"'Estimate Number';"+'"'+
                                '>'+value.client_name+'</li>';
                        angular.element(clNameDiv).append( $compile(html)($scope) );
                    });
                }
                $scope.cpo.cpo_loader = false;
            }).error(function(data) {
                $scope.cpo.message = ("Something went wrong! Please try again after some time. "+data);
                $scope.cpo.cpo_loader = false;
            });
        }else{
            $scope.cpo.message = ("Please wait...");
        }
    };
    
    getClientsList();
    
  }]
);