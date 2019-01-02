<?php

?>

<div ng-controller="debitNoteController" ng-cloak>
    <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
        Debit Note
    </div>
    <div style="text-align: center; margin-top: 16px;">
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{dn.generate? '-1': 'auto'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{dn.clientName}}">
                <span class="caret"></span>
            <ul id="clientNames" class="dropdown-menu"></ul>
        </div>
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{dn.tendency && !dn.generate? 'auto' : '-1'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{dn.cpoNums}}">
                <span class="caret"></span>
            <ul id="cpoNums" class="dropdown-menu"></ul>
        </div>
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{dn.primtendency && !dn.generate? 'auto' : '-1'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{dn.invNums}}">
                <span class="caret"></span>
            <ul id="invNums" class="dropdown-menu"></ul>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="dn.billingAddress" placeholder="Billing Address" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="dn.pan" placeholder="PAN Number" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="dn.gst" placeholder="GST Number" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="dn.sac" placeholder="SAC Code" ng-readonly='true' required>
        </div>
    </div>
    <div ng-custom-if="dn.message !== ''" class="alert alert-warning" style="text-align: center;  width: 42%; margin-top: 8px; margin-left: 480px;">
            <span bind-html-compile="dn.message"></span>
    </div>
    <div style="margin: 10px 57%;" ng-show="dn.dn_loader">
        <img src="assets/images/loader.gif" style="max-width: 30px;" />
    </div>
    <div class="" style="border-top: 1px solid #e7eceb;"></div>
    <div style="text-align: center;">
        <div ng-custom-if="!dn.generate" style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Generate and Assign Debite Note Number" ng-click="dn.generateAndAssignDNNum();">
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Clear" ng-click="dn.clearEverything();">
        </div>
    </div>

    <div ng-custom-if="dn.generate">
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
        <div style="margin: 16px; text-align: center;">
            DN number: <input style="width: 200px; display: inline-block;" type='text' ng-model='singleDN.dnnum' class="form-control" placeholder="Project Code" readonly="true" required>
        </div>
        <div class="" style="border-top: 1px solid #e7eceb;"></div>

        <div style="text-align: center; margin-top: 16px;">
            <div class="dropdown" style="margin: 16px; display: inline-block;">
                <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleDN.items.adOrInOrFin}}">
                    <span class="caret"></span>
                    <ul class="dropdown-menu">
                        <li style="cursor: pointer; padding: 8px;" ng-click="singleDN.items.adOrInOrFin = 'advance';">Advance</li>
                        <li style="cursor: pointer; padding: 8px;" ng-click="singleDN.items.adOrInOrFin = 'interium';">Interium</li>
                        <li style="cursor: pointer; padding: 8px;" ng-click="singleDN.items.adOrInOrFin = 'final';">Final</li>
                    </ul>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='singleDN.items.description' class="form-control" placeholder="Description" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='singleDN.items.netValue' class="form-control" placeholder="Net Value" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type='text' ng-model='singleDN.items.tax' class="form-control" placeholder="Tax" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='singleDN.items.totalValue' class="form-control" placeholder="Total Value" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input id="paymentDate" type="text" ng-model='singleDN.items.paymentDate' class="form-control date picker" placeholder="Payment date" required>
            </div>
            <input ng-click='singleDN.clearInvSegment()' class="btn btn-default" style="font-weight: 900;" type="button" value="X">
        </div>
        <div style="margin: 16px; text-align: center;">
            <input data-toggle="modal" data-target="#submitDN" class="btn btn-default btn-primary" style="font-weight: 900;" type="button" value="Submit Debit Note">
        </div>
    </div>
    <div>
        <div ng-custom-if="!dn.generate" class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;">Invoice Number</th>
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
                    <tr ng-repeat="desc in dn.estList">
                        <td style="text-align: center;">{{desc.invoiceNum}}</td>
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

        <div ng-custom-if="dn.generate" class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;">DN No</th>
                        <th style="text-align: center;">Advance/Interium/Final</th>
                        <th style="text-align: center;">Description</th>
                        <th style="text-align: center;">Net Value</th>
                        <th style="text-align: center;">Tax</th>
                        <th style="text-align: center;">Total Value</th>
                        <th style="text-align: center;">Payment Date</th>
                        <th style="text-align: center;">Creation Date</th>
                        <th style="text-align: center;">Added By</th>
                        <th style="text-align: center;">Approved By</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="desc in singleDN.invList">
                        <td style="text-align: center;">{{desc.dnNum}}</td>
                        <td style="text-align: center;">{{desc.adOrInOrFin}}</td>
                        <td style="text-align: center;">{{desc.description}}</td>
                        <td style="text-align: center;">{{desc.netValue}}</td>
                        <td style="text-align: center;">{{desc.tax}}</td>
                        <td style="text-align: center;">{{desc.totalValue}}</td>
                        <td style="text-align: center;">{{desc.paymentDate}}</td>
                        <td style="text-align: center;">{{desc.added_on}}</td>
                        <td style="text-align: center;">{{desc.added_by}}</td>
                        <td style="text-align: center;">{{desc.approved_by}}</td>
                        <td style="text-align: center;">{{desc.status}}</td>
                        <td style="text-align: center;">
                            <input ng-click='singleDN.getDN(desc.dnNum)' class="btn btn-default" style="font-weight: 900; height: 32px; background: #e2d0d0;" type="button" value="Debit Note">
                            <input ng-custom-if="desc.status != 'cancelled'" ng-click='singleDN.cancelDN(desc.dnNum, $index)' class="btn btn-default" style="font-weight: 900; height: 32px; margin-top: 8px; color: red;" type="button" value="Cancel">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Submit DN Modal -->
        <div id="submitDN" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0d98bc">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">Submit Debit Note</h4>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group" style="color: black; text-align: center;">
                                <label for="addedBy">Created By:</label>
                                <div class="dropdown" style="margin: 16px; display: inline-block;">
                                    <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleDN.addedBy}}">
                                        <span class="caret"></span>
                                    <ul class="dropdown-menu">
                                        <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singleDN.employees" ng-click="singleDN.addedBy = em.ecode;">
                                            {{em.ecode}}
                                        </li>
                                    </ul>
                                </div>
                                <div style="text-align: center;">
                                    <div style="display: inline-block;">
                                        <label for="approvedBy1">Approver 1:</label>
                                        <div class="dropdown" style="margin: 16px; display: inline-block;">
                                            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleDN.approvedBy1}}">
                                                <span class="caret"></span>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singleDN.employees" ng-click="singleDN.approvedBy1 = em.ecode;">
                                                    {{em.ecode}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div style="display: inline-block;">
                                        <label for="approvedBy2">Approver 2:</label>
                                        <div class="dropdown" style="margin: 16px; display: inline-block;">
                                            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleDN.approvedBy2}}">
                                                <span class="caret"></span>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singleDN.employees" ng-click="singleDN.approvedBy2 = em.ecode;">
                                                    {{em.ecode}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div ng-custom-if="singleDN.message !== ''" class="alert alert-warning" style="text-align: center;  width: 69%; margin-top: 8px; margin-left: 88px;">
                                <span bind-html-compile="singleDN.message"></span>
                            </div>
                            <div style="margin: 10px 50%;" ng-show="singleDN.dn_loader">
                                <img src="assets/images/loader.gif" style="max-width: 30px;" />
                            </div>
                            <div style="float:right">
                                <input class="btn btn-default btn-primary" style="font-weight: 900;" type="button" ng-click="singleDN.submitDN();" value="Submit DN">
                                <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #0d98bc; border-color: #0d98bc;">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('body').on('focus',"#paymentDate", function(){
            $(this).datepicker({
                inline: true,
                dateFormat: "yy-mm-dd"
            });
        });
    });
</script>
