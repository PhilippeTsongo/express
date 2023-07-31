<!-- Main content-->
<section class="content">
    <div class="container-fluid">

        <form action="" id="FILTERFORM" class="row smart-data-info " method='post'>
            <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                <input type="hidden" name="request" id="request" value="fDpnBexzXKc1iCW49vWOQ4oznQ/e/7a0JSAieV2+SD0">
                <input type="hidden" name="webToken" id="webToken" value="<?= $HASH->encryptAES(256) ?>">
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <div class="view-header">
                    <div class="pull-right text-right" style="line-height: 14px">
                        <small><br>Afriexpress Global<br> <span class="c-white">Dashboad</span></small>
                    </div>
                    <div class="header-icon">
                        <i class="pe page-header-icon pe-7s-shield"></i>
                    </div>
                    <div class="header-title">
                        <h3 class="m-b-xs">Afriexpress Global</h3>
                        <small> 
                           
                            Space admin to manage Website
                        </small>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 col-xs-6">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <h2 class="m-b-none total-ship"></h2>
                        <div class="small">Total Shipment</div>
                        <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> 
                            Updated: <span class="c-white"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <h2 class="m-b-none" id="total-customer"></h2>
                        <div class="small">Total Customer</div>
                        <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> 
                            Updated: <span class="c-white"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <h2 class="m-b-none" id="total-partner"></h2>
                        <div class="small">Total Partners</div>
                        <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> 
                            Updated: <span class="c-white"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-xs-6">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <h2 class="m-b-none" id="total-user"></h2>
                        <div class="small">Total Users</div>
                        <div class="slight m-t-sm"><i class="fa fa-clock-o"> </i> 
                            Updated: <span class="c-white"></span>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-xs-12">
                <div class="panel panel-filled" style="position:relative;height: 114px">
                    <div style="position: absolute;bottom: 0;left: 0;right: 0">
                        <span class="sparkline"></span>
                    </div>
                    <div class="panel-body">
                        <div class="m-t-sm">
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-xs">See locations</a>
                            </div>
                            <div class="c-white"><span class="label label-accent">+45</span> New visitor</div>
                            <span class="small c-white">120,312 <i class="fa fa-play fa-rotate-270 text-warning"> </i>
                                -22%</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="row">
                        <div class="col-md-4">

                            <div class="panel-body h-200 list">
                                <div class="stats-title">
                                    <h4><i class="fa fa-bar-chart text-warning" aria-hidden="true"></i> Traffic source
                                    </h4>
                                </div>
                                <div class="small">
                                    Total users from the beginning of activity. See detailed charts for more information
                                    locations and traffic source.
                                </div>

                                <div class="sparkline3"></div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="stat-label">Today</small>
                                        <h4 class="m-t-xs">170,20 <i class="fa fa-level-up text-warning"></i></h4>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="stat-label">Last month %</small>
                                        <h4 class="m-t-xs">%20,20 <i class="fa fa-level-down c-white"></i></h4>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="stat-label">Year</small>
                                        <h4 class="m-t-xs">2180,50 <i class="fa fa-level-up text-warning"></i></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="panel-body">
                                <div class="text-center slight">
                                </div>

                                <div class="flot-chart" style="height: 160px;margin-top: 5px">
                                    <div class="flot-chart-content" id="flot-line-chart"></div>
                                </div>

                                <div class="small text-center">All active users from last month.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
           
            <div class="col-md-8">
                <div class="panel panel-filled">
                    <div class="panel-heading">                        
                        List of 5 latest ship
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive smart-data-table">
                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-b-accent">
                    <div class="panel-body text-center p-m">
                        <div class="flex">
                            <h2 class="font-light total-ship"></h2>
                        <small>Total ships</small>
                        <div>
                            <span id="active_ships"> </span> 
                            Approved ships 
                            <span class="slight"><i class="fa fa-play fa-rotate-270 c-white"> </i> 
                                <span id="pc_approved_ships"> </span> 
                            </span>
                        </div>
                        <div>
                            <span id="pending_ships"> </span> 
                            Initiated ships 
                            <span class="slight"><i class="fa fa-play fa-rotate-270 c-white"> </i> 
                            <span id="pc_initiated_ships"> </span> 

                        </span>
                        </div>

                        
                        <div class="sparkline7 m-t-xs"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
<!-- End main content-->