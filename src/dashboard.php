<?php

?>
<div ng-controller="dashboardController" ng-cloak>
    <div ng-custom-if="!nextToCompanyProfile && !showDashboard">
        <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
            Company Name
        </div>

        <div style="padding-top: 99px; padding-left: 50%; background-color: white;">
            <div style="padding-bottom: 48px; font-size: 14px;">
                What is your registered company name?
            </div>
            <input type="text" placeholder="text input" style="padding: 8px; margin-left: 24px;" ng-model="dashboard.companyName" ng-pattern="/^[a-zA-Z0-9\.]*$/">
            <button ng-click="dashboard.company()" type="button" class="btn btn-default" style="background-color: #0d98bc; color: white;">Next</button>
            <div style="margin-left: 32px; padding-top: 8px; font-size: 11px;">
                <a href="javascript:void(0)" ng-click="showDashboard=true;">go to dashboard</a>
            </div>
            <div ng-custom-if="dashboard.nextMessage !== ''" class="alert alert-warning" style="text-align: center;  width: 42%; margin-top: 8px;">
                {{dashboard.nextMessage}}
            </div>
            <div style="margin: 10px 19%;" ng-show="dashboard.dashboard_loader">
                <img src="assets/images/loader.gif" style="max-width: 30px;" />
            </div>
        </div>
    </div>
    <div ng-custom-if="nextToCompanyProfile  && !showDashboard" >
        <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
            Companay Profile
        </div>

        <div style="padding-top: 32px; padding-left: 50%; background-color: white;">
            <div style="padding-bottom: 8px; font-size: 14px;">
                Enter your CIN Number
            </div>
            <input type="text" placeholder="text input" style="padding: 8px; margin-bottom: 16px" ng-model="dashboard.cin" ng-pattern="/^[a-zA-Z0-9\.]*$/">
            <div style="padding-bottom: 8px; font-size: 14px;">
                Enter your PAN Number
            </div>
            <input type="text" placeholder="text input" style="padding: 8px; margin-bottom: 16px;" ng-model="dashboard.pan" ng-pattern="/^[a-zA-Z0-9\.]*$/">
            <div style="padding-bottom: 8px; font-size: 14px;">
                Enter your GST Number
            </div>
            <input type="text" placeholder="text input" style="padding: 8px; margin-bottom: 16px;" ng-model="dashboard.gst" ng-pattern="/^[a-zA-Z0-9\.]*$/">
            <div style="padding-bottom: 8px; font-size: 14px;">
                Enter your SAC Code
            </div>
            <input type="text" placeholder="text input" style="padding: 8px; margin-bottom: 16px;" ng-model="dashboard.sac" ng-pattern="/^[a-zA-Z0-9\.]*$/">
            <div style="padding-bottom: 8px; font-size: 14px;">
                Enter your Billing Address
            </div>
            <input type="text" placeholder="text input" style="padding: 8px; margin-bottom: 16px;" ng-model="dashboard.addr">
            <div>
                <button ng-click="dashboard.saveProfile()" type="button" class="btn btn-default" style="background-color: #0d98bc; color: white; margin-left: 64px;">Next</button>
            </div>
            <div style="margin-left: 48px; padding-top: 8px; font-size: 11px;">
                <a href="javascript:void(0)" ng-click="showDashboard=true;">go to dashboard</a>
            </div>
            <div ng-custom-if="dashboard.saveMessage !== ''" class="alert alert-warning" style="text-align: center;  width: 42%; margin-top: 8px;">
                {{dashboard.saveMessage}}
            </div>
            <div style="margin: 10px 19%;" ng-show="dashboard.dashboard_loader_2">
                <img src="assets/images/loader.gif" style="max-width: 30px;" />
            </div>
        </div>
    </div>
    <div ng-custom-if="showDashboard" >
        <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
            Dashboard
        </div>
    </div>
</div>
