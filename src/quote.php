<?php

?>

<div ng-controller="quoteController" ng-cloak>
    <div style="text-align: center; font-size: 32px; font-weight: 800; background-color: #c2e2ea; color: #aa9b9b;">
        Quote/Estimate
    </div>
    <div style="text-align: center; margin-top: 16px;">
        <div class="dropdown" style="margin: 16px; display: inline-block; z-index: {{quote.edit || quote.quoted? '-1': 'auto'}}">
            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{quote.clientName}}">
                <span class="caret"></span>
            <ul id="clientNames" class="dropdown-menu">
                <li ng-custom-if="quote.tendency" style="cursor: pointer; padding: 8px;" ng-click="quote.tendency = false; quote.clientName= ''; quote.raiseQ = false;">+ Add new</li>
                <li ng-custom-if="!quote.tendency" style="padding: 8px;">
                    <input type="text" class="form-control" ng-model='quote.clientName' placeholder="Enter the client name" required>
                </li>
            </ul>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model='quote.ccode' placeholder="Client Code" ng-readonly='quote.tendency' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model='quote.emails' placeholder="Email Id (separated by commas)" ng-readonly='quote.tendency' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input id='dateOfCreation' type='text' ng-model='quote.dateOfCreation' class='form-control {{!quote.quoted ? "date picker" : ""}}' placeholder="Date of creation" ng-readonly='quote.quoted' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="quote.billingAddress" placeholder="Billing Address" ng-readonly='quote.tendency' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="quote.pan" placeholder="PAN Number" ng-readonly='quote.tendency' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="quote.gst" placeholder="GST Number" ng-readonly='quote.tendency' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="quote.sac" placeholder="SAC Code" ng-readonly='quote.tendency' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input id='deliveryDate' type='text' ng-model="quote.delDate" class='form-control {{!quote.quoted ? "date picker" : ""}}' placeholder="Delivery Date" ng-readonly='quote.quoted' required>
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input type="text" class="form-control" ng-model="quote.amount" placeholder="Amount" ng-readonly='quote.quoted' required>
        </div>
        <div ng-custom-if="!quote.quoted">
            <script type="text/javascript">
                $(function () {
                    $('#dateOfCreation').datepicker();
                });
                $(function () {
                    $('#deliveryDate').datepicker();
                });
            </script>
        </div>
    </div>
    <div ng-custom-if="quote.message !== ''" class="alert alert-warning" style="text-align: center;  width: 42%; margin-top: 8px; margin-left: 480px;">
            <span bind-html-compile="quote.message"></span>
    </div>
    <div style="margin: 10px 57%;" ng-show="quote.quote_loader">
        <img src="assets/images/loader.gif" style="max-width: 30px;" />
    </div>
    <div class="" style="border-top: 1px solid #e7eceb;"></div>
    <div style="text-align: center;">
        <div ng-custom-if="!quote.tendency && !quote.raiseQ" style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="{{quote.saveorup}}" ng-click="quote.addorUpClient();">
        </div>
        <div style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Clear" ng-click="quote.clearEverything();">
        </div>
        <div ng-custom-if="quote.raiseQ" style="margin: 16px; display: inline-block;">
            <input class="btn btn-default" style="font-weight: 900;" type="button" value="Quote" ng-click="quote.raiseQuote();">
        </div>
    </div>
    
    <div ng-custom-if="quote.quoted">
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
        <div style="margin: 16px; text-align: center;">
            <input style="width: 200px; display: inline-block;" type='text' ng-model='singlequote.estimateNo' class="form-control" placeholder="Estimate Number" readonly="true" required>
            <input style="display: inline-block;" ng-click='singlequote.add()' class="btn btn-default" style="font-weight: 900;" type="button" value="+">
        </div>
        <div ng-repeat='item in singlequote.items' style="text-align: center; margin-top: 16px;">
            #{{$index +1}}
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='item.description' class="form-control" placeholder="Description" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='item.ppu' class="form-control" placeholder="Parts per unit" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='item.quantity' class="form-control" placeholder="Quantity" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type='text' ng-model='item.netValue' class="form-control" placeholder="Net Value" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='item.tax' class="form-control" placeholder="Tax" required>
            </div>
            <div style="margin: 16px; display: inline-block;">
                <input type="text" ng-model='item.reimbursable' class="form-control" placeholder="Reimbursable" required>
            </div>
            <input ng-click='singlequote.del($index)' class="btn btn-default" style="font-weight: 900;" type="button" value="X">
        </div>
        <div style="margin: 16px; text-align: center;">
            <input data-toggle="modal" data-target="#submitQuote" class="btn btn-default btn-primary" style="font-weight: 900;" type="button" value="Submit Quote">
        </div>
        <div class="" style="border-top: 1px solid #e7eceb;"></div>
        <div class="table-responsive">          
            <table class="table">
                <thead>
                    <tr>
                        <th style="text-align: center;">Estimate No</th>
                        <th style="text-align: center;">Description</th>
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
                    <tr ng-repeat="desc in quoted">
                        <td style="text-align: center;">{{desc.estimateNo}}</td>
                        <td style="text-align: center;">{{desc.description}}</td>
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
    
        <!-- Submit Quote Modal -->
        <div id="submitQuote" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #0d98bc">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align: center;">Submit Quote</h4>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group" style="color: black; text-align: center;">
                                <label for="addedBy">Created By:</label>
                                <div class="dropdown" style="margin: 16px; display: inline-block;">
                                    <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singlequote.addedBy}}">
                                        <span class="caret"></span>
                                    <ul class="dropdown-menu">
                                        <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singlequote.employees" ng-click="singlequote.addedBy = em.ecode;">
                                            {{em.ecode}}
                                        </li>
                                    </ul>
                                </div>
                                <div style="text-align: center;">
                                    <div style="display: inline-block;">
                                        <label for="approvedBy1">Approver 1:</label>
                                        <div class="dropdown" style="margin: 16px; display: inline-block;">
                                            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singlequote.approvedBy1}}">
                                                <span class="caret"></span>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singlequote.employees" ng-click="singlequote.approvedBy1 = em.ecode;">
                                                    {{em.ecode}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div style="display: inline-block;">
                                        <label for="approvedBy2">Approver 2:</label>
                                        <div class="dropdown" style="margin: 16px; display: inline-block;">
                                            <input class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" value="{{singlequote.approvedBy2}}">
                                                <span class="caret"></span>
                                            <ul class="dropdown-menu">
                                                <li style="cursor: pointer; padding: 8px;" ng-repeat="em in singlequote.employees" ng-click="singlequote.approvedBy2 = em.ecode;">
                                                    {{em.ecode}}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div ng-custom-if="singlequote.message !== ''" class="alert alert-warning" style="text-align: center;  width: 69%; margin-top: 8px; margin-left: 88px;">
                                <span bind-html-compile="singlequote.message"></span>
                            </div>
                            <div style="margin: 10px 50%;" ng-show="singlequote.quote_loader">
                                <img src="assets/images/loader.gif" style="max-width: 30px;" />
                            </div>
                            <div style="float:right">
                                <input class="btn btn-default btn-primary" style="font-weight: 900;" type="button" ng-click="singlequote.submitQuote();" value="Submit Quote">                        
                                <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #0d98bc; border-color: #0d98bc;">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>