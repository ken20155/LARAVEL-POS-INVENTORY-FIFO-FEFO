<div class="row pb-10">
    <div class="col-md-4 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?=number_format($total_user)?></div>
                    <div class="font-14 text-secondary weight-500">
                        <?= $user_role == 1 ? 'Total Consignor' : 'Total Products'?>
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf">
                        <i class="icon-copy bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark"><?=number_format($total_product_sold)?></div>
                    <div class="font-14 text-secondary weight-500">
                        Total Product Sold
                    </div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b">
                        <i class="icon-copy ti-stats-up"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">₱<?=number_format($total_earnings,2)?></div>
                    <div class="font-14 text-secondary weight-500">Total Earnings</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#09cc06">
                        <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row pb-10">
    <div class="col-md-12 mb-20">
        <div class="card-box height-100-p pd-20">
            <div
                class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3"
            >
                <div class="h5 mb-md-0">Monthly Earnings</div>
                <div class="form-group mb-md-0">
                    <select class="form-control form-control-sm selectpicker data-filter" id="selectYearFilter" name="year">
                        <option value="2024" >2024</option>
                        <option value="2025" selected>2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                    </select>
                </div>
            </div>
            <div id="activities-chart-monthly"></div>
        </div>
    </div>
</div>
