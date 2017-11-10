fmsApp.controller('dashboardController', ['$scope', '$http', '$timeout', 
  function ($scope, $http, $timeout) {
    $scope.nextToCompanyProfile = false;  
    $scope.showDashboard = false;
    $scope.dashboard = {
        companyName : '',
        dashboard_loader: false,
        dashboard_loader_2: false,
        nextMessage: '',
        saveMessage: '',
        cin: '',
        pan: '',
        gst: '',
        sac: '',
        addr: '',
        saveProfile:function(){
            savecompany();
        },
        company : function(){
            verifycompany();
        }
    };
    
    function verifycompany(){
        if($scope.dashboard.companyName !== '' && $scope.dashboard.dashboard_loader === false){
            $scope.nextToCompanyProfile = false;
            $scope.dashboard.dashboard_loader = true;
            $http({
                method : "GET",
                url : 'includes/dashboard',
                params : {company: angular.toJson($scope.dashboard.companyName), token: "check"},
            }).success(function(response) {
                if(response == 1){
                    $scope.dashboard.nextMessage = "Name already exists! Please try again with a different name.";
                }else{
                    $scope.nextToCompanyProfile = true;
                }
                $scope.dashboard.dashboard_loader = false;
            }).error(function(data) {
                $scope.dashboard.nextMessage = "Something went wrong! Please try again after some time. "+data;
                $scope.dashboard.dashboard_loader = false;
            });
        }else{
            if($scope.dashboard.dashboard_loader === true){
                $scope.dashboard.nextMessage = "Please wait...";
            }else{
                $scope.dashboard.nextMessage = "Name cannot be left blank.";
            }
        }
    };
    
    function savecompany(){
        if($scope.dashboard.addr !== '' && $scope.dashboard.sac !== '' && $scope.dashboard.gst !== '' && $scope.dashboard.pan !== '' && $scope.dashboard.cin !== '' && $scope.dashboard.dashboard_loader_2 === false){
            $scope.dashboard.dashboard_loader_2 = true;
            $scope.showDashboard = false;
            $http({
                method : "GET",
                url : 'includes/dashboard',
                params : {company: $scope.dashboard, token: "save"},
            }).success(function(response) {
                if(response == 0){
                    $scope.showDashboard = true;
                }else{
                    $scope.dashboard.nextMessage = "Something went wrong! Please try again after some time. "+response;
                }
                $scope.dashboard.dashboard_loader_2 = false;
            }).error(function(data) {
                $scope.dashboard.saveMessage = "Something went wrong! Please try again after some time. "+data;
                $scope.dashboard.dashboard_loader_2 = false;
            });
        }else{
            if($scope.dashboard.dashboard_loader_2 === true){
                $scope.dashboard.saveMessage = "Please wait...";
            }else{
                $scope.dashboard.saveMessage = "Value cannot be left blank.";
            }
        }
    };
  }
]);