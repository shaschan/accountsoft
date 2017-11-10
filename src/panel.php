<?php

?>
<div ng-controller="mainController" ng-cloak>
    <div id="test" style=" background: #0d98bc; max-width: 240px; width: 100%; padding-top: 24px; float: left;" >
        <div class="user" style="text-align: center;">
            <img src="<?php echo $conf->assetsFolderURL?>/images/shaschan.png" alt="Esempio" class="img-thumbnail">
            <div><a href="http://wrapchick.in" target="_blank" class="navbar-link" style="color: white;">{{companyName}}</a></div>
        </div>

        <div class="list-group">

            <a href="javascript:void(0)" ng-click="activatePanel(panels.dashboard);" class="list-group-item" style="background: aliceblue; color: black; font-weight: 600; text-align: center;">Dashboard</a>
            
            <a href="#acc_rec" class="list-group-item" data-toggle="collapse" style="background: aliceblue; color: black; font-weight: 600;">Account Receivables</a>

            <div class="list-group collapse" id="acc_rec">
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.quote);" class="list-group-item" style="font-size: 10px;">Quote/Estimate</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.cpo);" class="list-group-item" style="font-size: 10px;">CPO & Project Code</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.invoice);" class="list-group-item" style="font-size: 10px;">Invoice</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.debitNote);" class="list-group-item" style="font-size: 10px;">Debit Note</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.creditNote);" class="list-group-item" style="font-size: 10px;">Credit Note</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.bankDepositVoucher);" class="list-group-item" style="font-size: 10px;">Bank Deposit Voucher</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountRec.paymentReceiptNote);" class="list-group-item" style="font-size: 10px;">Payment Receipt Note</a>
            </div>

            <a href="#acc_pay" class="list-group-item" data-toggle="collapse" style="background: aliceblue; color: black; font-weight: 600">Account Payable</a>

            <div class="list-group collapse" id="acc_pay">
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountPay.purchaseOrder);" class="list-group-item" style="font-size: 10px;">Purchase Order</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountPay.paymentOrder);" class="list-group-item" style="font-size: 10px;">Payment Voucher</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountPay.paymentAdvice);" class="list-group-item" style="font-size: 10px;">Payment Advice</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountPay.cwdVoucher);" class="list-group-item" style="font-size: 10px;">CWD Voucher</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.accountPay.cashPaymentVoucher);" class="list-group-item" style="font-size: 10px;">Cash Payment Voucher</a>
            </div>
            
            <a href="#emp" class="list-group-item" data-toggle="collapse" style="background: aliceblue; color: black; font-weight: 600">Employee</a>

            <div class="list-group collapse" id="emp">
                <a href="javascript:void(0)" ng-click="activatePanel(panels.employee.database);" class="list-group-item" style="font-size: 10px;">Database</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.employee.timesheet);" class="list-group-item" style="font-size: 10px;">Timesheet</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.employee.payroll);" class="list-group-item" style="font-size: 10px;">Payroll</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.employee.advance);" class="list-group-item" style="font-size: 10px;">Advance/Imprest</a>
                <a href="javascript:void(0)" ng-click="activatePanel(panels.employee.expense);" class="list-group-item" style="font-size: 10px;">Expense</a>
            </div>
<!--        <a href="#item-3" class="list-group-item" data-toggle="collapse">Item 3</a>

            <div class="list-group collapse" id="item-3">
                <a href="#" class="list-group-item">Item 1 di 3</a>
                <a href="#" class="list-group-item">Item 2 di 3</a>
                <a href="#item-3-1" class="list-group-item" data-toggle="collapse">Item 3 di 3</a>

                <div class="list-group collapse" id="item-3-1">
                    <a href="#" class="list-group-item">Item 1 di 3.3</a>
                    <a href="#" class="list-group-item">Item 2 di 3.3</a>
                    <a href="#" class="list-group-item">Item 3 di 3.3</a>
                </div>

            </div>-->
        </div>
        
        <div style="text-align: center; color: whitesmoke; padding-top: 120px; font-size: 10px;">
            &COPY;2017 Megalution Service Pvt Ltd
        </div>
    </div>
    
    <div ng-include="'<?php echo $conf->srcFolderURL?>'+activePanel.url"></div>
    
</div>
    
    <script>
//    $(document).ready(function () {
//        $('#test').BootSideMenu({
//            side: "left",
//            width: "16%"
//        });
//    });
    </script>

</div>