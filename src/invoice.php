<?php

?>

<div ng-controller="invoiceController" ng-cloak>
    <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
        Invoice
    </div>
    <div style="text-align: center; margin-top: 16px;">
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{cpo.generate? '-1': 'auto'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{cpo.clientName}}">
                <span class="caret"></span>
            <ul id="clientNames" class="dropdown-menu"></ul>
        </div>
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{cpo.tendency && !cpo.generate? 'auto' : '-1'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{cpo.estNos}}">
                <span class="caret"></span>
            <ul id="estNos" class="dropdown-menu"></ul>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model='cpo.cponum' placeholder="CPO Number" ng-readonly="cpo.primtendency == 'true'? true : false;">
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="cpo.billingAddress" placeholder="Billing Address" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="cpo.pan" placeholder="PAN Number" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="cpo.gst" placeholder="GST Number" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="cpo.sac" placeholder="SAC Code" ng-readonly='true' required>
        </div>
    </div>
    <div ng-custom-if="cpo.message !== ''" class="alert alert-warning" style="text-align: center;  width: 42%; margin-top: 8px; margin-left: 480px;">
            <span bind-html-compile="cpo.message"></span>
    </div>
    <div style="margin: 10px 57%;" ng-show="cpo.cpo_loader">
        <img src="assets/images/loader.gif" style="max-width: 30px;" />
    </div>
    <div class="" style="border-top: 1px solid #e7eceb;"></div>
    <div style="text-align: center;">
        <div ng-custom-if="!cpo.generate" style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Generate and assign project code" ng-click="cpo.generateAndAssignPC();">
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Clear" ng-click="cpo.clearEverything();">
        </div>
    </div>
    
    <div ng-custom-if="cpo.generate">
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
        <div style="margin: 16px; text-align: center;">
            Project Code: <input style="width: 200px; display: inline-block;" type='text' ng-model='cpo.pc' class="form-control" placeholder="Project Code" readonly="true" required>
        </div>
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
    </div>
    <div>
        <div class="table-responsive">          
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;">Estimate No</th>
                        <th style="text-align: center;">Description</th>
                        <th style="text-align: center;">CPO Number</th>
                        <th style="text-align: center;">Project Code</th>
                        <th style="text-align: center;">PPU</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: center;">Net Value</th>
                        <th style="text-align: center;">Reimbursable</th>
                        <th style="text-align: center;">Tax</th>
                        <th style="text-align: center;">Total Value</th>
                        <th style="text-align: center;">Delivery Date</th>
                        <th style="text-align: center;">Creation Date</th>
                        <th style="text-align: center;">Added By</th>
                        <th style="text-align: center;">Approved By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="desc in cpo.estList">
                        <td style="text-align: center;">{{desc.estimateNo}}</td>
                        <td style="text-align: center;">{{desc.description}}</td>
                        <td style="text-align: center;">{{desc.cponum}}</td>
                        <td style="text-align: center;">{{desc.pc}}</td>
                        <td style="text-align: center;">{{desc.ppu}}</td>
                        <td style="text-align: center;">{{desc.quantity}}</td>
                        <td style="text-align: center;">{{desc.netValue}}</td>
                        <td style="text-align: center;">{{desc.reimbursable}}</td>
                        <td style="text-align: center;">{{desc.tax}}</td>
                        <td style="text-align: center;">{{desc.totalValue}}</td>
                        <td style="text-align: center;">{{desc.deliveryDate}}</td>
                        <td style="text-align: center;">{{desc.creationDate}}</td>
                        <td style="text-align: center;">{{desc.added_by}}</td>
                        <td style="text-align: center;">{{desc.approved_by}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>