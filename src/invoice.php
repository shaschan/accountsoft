<?php

?>

<div ng-controller="invoiceController" ng-cloak>
    <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
        Invoice
    </div>
    <div style="text-align: center; margin-top: 16px;">
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{invoice.generate? '-1': 'auto'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{invoice.clientName}}">
                <span class="caret"></span>
            <ul id="clientNames" class="dropdown-menu"></ul>
        </div>
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{invoice.tendency && !invoice.generate? 'auto' : '-1'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{invoice.estNos}}">
                <span class="caret"></span>
            <ul id="estNos" class="dropdown-menu"></ul>
        </div>
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{invoice.primtendency && !invoice.generate? 'auto' : '-1'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{invoice.cpoNums}}">
                <span class="caret"></span>
            <ul id="cpoNums" class="dropdown-menu"></ul>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="invoice.billingAddress" placeholder="Billing Address" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="invoice.pan" placeholder="PAN Number" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="invoice.gst" placeholder="GST Number" ng-readonly='true' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="invoice.sac" placeholder="SAC Code" ng-readonly='true' required>
        </div>
    </div>
    <div ng-custom-if="invoice.message !== ''" class="alert alert-warning" style="text-align: center;  width: 42%; margin-top: 8px; margin-left: 480px;">
            <span bind-html-compile="invoice.message"></span>
    </div>
    <div style="margin: 10px 57%;" ng-show="invoice.invoice_loader">
        <img src="assets/images/loader.gif" style="max-width: 30px;" />
    </div>
    <div class="" style="border-top: 1px solid #e7eceb;"></div>
    <div style="text-align: center;">
        <div ng-custom-if="!invoice.generate" style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Generate and Assign Invoice Number" ng-click="invoice.generateAndAssignInvoiceNum();">
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Clear" ng-click="invoice.clearEverything();">
        </div>
    </div>
    
    <div ng-custom-if="invoice.generate">
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
        <div style="margin: 16px; text-align: center;">
            Invoice number: <input style="width: 200px; display: inline-block;" type='text' ng-model='singleInvoice.invoicenum' class="form-control" placeholder="Project Code" readonly="true" required>
        </div>
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
        
        <div style="text-align: center; margin-top: 16px;">
            <div class="dropdown" style="margin: 16px; display: inline-block;">
                <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleInvoice.items.adOrInOrFin}}">
                    <span class="caret"></span>
                    <ul class="dropdown-menu">
                        <li style="cursor: pointer; padding: 8px;" ng-click="singleInvoice.items.adOrInOrFin = 'advance';">Advance</li>
                        <li style="cursor: pointer; padding: 8px;" ng-click="singleInvoice.items.adOrInOrFin = 'interium';">Interium</li>
                        <li style="cursor: pointer; padding: 8px;" ng-click="singleInvoice.items.adOrInOrFin = 'final';">Final</li>
                    </ul>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='singleInvoice.items.description' class="form-control" placeholder="Description" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='singleInvoice.items.netValue' class="form-control" placeholder="Net Value" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type='text' ng-model='singleInvoice.items.tax' class="form-control" placeholder="Tax" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='singleInvoice.items.totalValue' class="form-control" placeholder="Total Value" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input id="paymentDate" type="text" ng-model='singleInvoice.items.paymentDate' class="form-control date picker" placeholder="Payment date" required>
            </div>
            <input ng-click='singleInvoice.clearInvSegment()' class="btn btn-default" style="font-weight: 900;" type="button" value="X">
        </div>
        <div style="margin: 16px; text-align: center;">
            <input data-toggle="modal" data-target="#submitInvoice" class="btn btn-default btn-primary" style="font-weight: 900;" type="button" value="Submit Invoice">
        </div>
    </div>
    <div>
        <div ng-custom-if="!invoice.generate" class="table-responsive">          
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
                    <tr ng-repeat="desc in invoice.estList">
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
        
        <div ng-custom-if="invoice.generate" class="table-responsive">          
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;">Invoice No</th>
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
                    <tr ng-repeat="desc in singleInvoice.invList">
                        <td style="text-align: center;">{{desc.invoiceNum}}</td>
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
                            <input ng-click='singleInvoice.getInvoice(desc.invoiceNum)' class="btn btn-default" style="font-weight: 900; height: 32px; background: #e2d0d0;" type="button" value="Invoice">
                            <input ng-custom-if="desc.status != 'cancelled'" ng-click='singleInvoice.cancelInvoice(desc.invoiceNum, $index)' class="btn btn-default" style="font-weight: 900; height: 32px; margin-top: 8px; color: red;" type="button" value="Cancel">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Submit Invoice Modal -->
        <div id="submitInvoice" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0d98bc">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">Submit Invoice</h4>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group" style="color: black; text-align: center;">
                                <label for="addedBy">Created By:</label>
                                <div class="dropdown" style="margin: 16px; display: inline-block;">
                                    <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleInvoice.addedBy}}">
                                        <span class="caret"></span>
                                    <ul class="dropdown-menu">
                                        <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singleInvoice.employees" ng-click="singleInvoice.addedBy = em.ecode;">
                                            {{em.ecode}}
                                        </li>
                                    </ul>
                                </div>
                                <div style="text-align: center;">
                                    <div style="display: inline-block;">
                                        <label for="approvedBy1">Approver 1:</label>
                                        <div class="dropdown" style="margin: 16px; display: inline-block;">
                                            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleInvoice.approvedBy1}}">
                                                <span class="caret"></span>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singleInvoice.employees" ng-click="singleInvoice.approvedBy1 = em.ecode;">
                                                    {{em.ecode}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div style="display: inline-block;">
                                        <label for="approvedBy2">Approver 2:</label>
                                        <div class="dropdown" style="margin: 16px; display: inline-block;">
                                            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singleInvoice.approvedBy2}}">
                                                <span class="caret"></span>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singleInvoice.employees" ng-click="singleInvoice.approvedBy2 = em.ecode;">
                                                    {{em.ecode}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div ng-custom-if="singleInvoice.message !== ''" class="alert alert-warning" style="text-align: center;  width: 69%; margin-top: 8px; margin-left: 88px;">
                                <span bind-html-compile="singleInvoice.message"></span>
                            </div>
                            <div style="margin: 10px 50%;" ng-show="singleInvoice.invoice_loader">
                                <img src="assets/images/loader.gif" style="max-width: 30px;" />
                            </div>
                            <div style="float:right">
                                <input class="btn btn-default btn-primary" style="font-weight: 900;" type="button" ng-click="singleInvoice.submitInvoice();" value="Submit Invoice">                        
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