var fmsApp = angular.module('fmsApp',[]);
 
fmsApp.controller('mainController', ['$scope', '$http', '$timeout', 
  function ($scope, $http, $timeout) {
    
      
    $scope.companyName = "shaschan";
    
    $scope.panels = {
        dashboard: "dashboard",
        accountRec: {
            quote : "quote",
            cpo : "cpo",
            invoice: "invoice",
            debitNote : "debitnote",
            creditNote : "creditnote",
            bankDepositVoucher : "bankdepositvoucher",
            paymentReceiptNote : "paymentreceiptnote"
        },
        accountPay: {
            purchaseOrder: "purchaseorder",
            paymentOrder: "paymentorder",
            paymentAdvice: "paymentadvice",
            cwdVoucher: "cwdvoucher",
            cashPaymentVoucher : "cashpaymentvoucher"
        },
        employee: {
            database: "database",
            timesheet: "timesheet",
            payroll : "payroll",
            advance : "advance",
            expense: "expense"
        }
    };
    
    
    $scope.activePanel = {//by default
        name : $scope.panels.dashboard,
        url : $scope.panels.dashboard
    };
    
    $scope.activatePanel = function(data){
        
        $scope.activePanel = {
            name : data,
            url: data
        };
    };
}]);