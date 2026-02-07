


<div class="card">
<div class="card-header">
    <h4 class="card-title">
    </h4>
</div>
<div class="card-body">
    <div class="table-responsive">
        <div class="row pb-10" id="blockreportui">
            <div class="col-md-12 mb-20">
                <label for="exampleFormControlSelect2">Select Report</label>



                {{-- <div class="input-group mb-3"> --}}
                    <div class="row">
                        <div class="col-3">
                            <select class="form-control form-control-sm selectpicker data-filter" id="select-reports" name="reports_name">
                        
                                <?php 
                                if ($user_role == 1) {
                                    ?>
                                        {{-- CONSIGNEE REPORTS --}}
                                        <option value="fn=inventoryReport,title=INVENTORY" selected>INVENTORY</option>
                                        <option value="fn=saleReport,title=SALES/TRANSACTION REPORT">SALES/TRANSACTION REPORT</option>
                                        <option value="fn=receivedReport,title=RECEIVED PRODUCTS REPORTS">RECEIVED PRODUCTS REPORTS</option>
                                        <option value="fn=consPayoutReport,title=CONSIGNOR PAYOUT REPORT">CONSIGNOR PAYOUT REPORT</option>

                                    <?php
                                }
                                if ($user_role == 2) {
                                    ?>
                                    {{-- CONSIGNOR REPORTS --}}
                                        <option value="fn=productSaleTracking,title=PRODUCT SALE TRACKING" selected>PRODUCT SALE TRACKING</option>
                                        {{-- <option value="fn=paymentTrackingConsignor,title=PAYMENT TRACKING">PAYMENT TRACKING</option> --}}

                                    <?php
                                }
                                ?>

                            
                            </select>
                        </div>
                        <div class="col-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Date</span>
                                </div>
                                <input type="date" aria-label="First name" class="form-control data-filter date-filter" name="start_date">
                                <input type="date" aria-label="Last name" class="form-control data-filter date-filter" name="end_date">
                            </div>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" name="" id="myInputSearch" placeholder="Search for product name.." title="Type in a name">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control data-filter" name="consignor_name" id="myInputSearchConsignor" placeholder="Search for consignor name.." title="Type in a name">
                        </div>
                    </div>

                    <button class="btn btn-outline-danger btn-sm" type="button" id="button-reset">Reset Filter</button>
                    <button class="btn btn-outline-success btn-sm" type="button" id="button-print">Print Report</button>
          
                {{-- </div> --}}

            </div>
            <div class="col-md-12" id="displayReport">
                            <h5 class="mb-20 text-center">GENERATE REPORT</h5>
            </div>
        </div>
    </div>
</div>
</div>