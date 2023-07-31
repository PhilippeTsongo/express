    <!-- Main content-->
    <form action="" id="FILTERFORM" class="row " method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="request" id="request" value="nvIegZX2EEVx1VlVgF9XzqAKnfnFaPlK2xvGXcV4CCE">
            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
        </div>
    </form>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>" class="text-warning" style="color: white !important;"> <span class="pe-7s-home"></span>Dashboard</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>Package </h3>
                            <small>
                                Package List
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
            <div class="col-md-12">
                <div class="panel panel-filled" >
                    <div class="panel-body">
                        <form method="post" id="FILTERFORM">
                            <div class="row">
                                <div class="col-lg-3">
                                    <select class="form-control m-b-xs m-t-xs" name="filter_by" id="filter_by" style="width: 100%">
                                        <option value="" selected="">Filter By</option>
                                        <option value="STATUS-ALL">Status - ALL </option>
                                        <option value="STATUS-COMPLETED">Payments - Completed </option>
                                        <option value="STATUS-FAILED">Payments - Failed </option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select class="form-control m-b-xs m-t-xs" name="filter_date" id="filter_date" style="width: 100%">
                                        <option value="TRANSACTIONDATE">Penalty Date </option>
                                        <option value="PAYPLANDATE">Instruction Date </option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-group m-b-xs m-t-xs">
                                        <input type="date" class="form-control" value="" name="filter_date_from" id="filter_date_from" aria-describedby="button-addon2">
                                    </div> 
                                </div>
                                <div class="col-lg-2">
                                    <div class="input-group m-b-xs m-t-xs">
                                        <input type="date" class="form-control" value="" name="filter_date_to" id="filter_date_to"  aria-describedby="button-addon2">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="input-group m-b-xs m-t-xs">
                                        <input type="text" class="form-control filter_search_keyword" value="" id="filter_search_keyword" name="filter_search_keyword" placeholder="Search by Name.." aria-describedby="button-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary filter_search_submit" type="submit" id="button-addon2"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div> 
                </div> 
            </div>  
        </div>
        <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                           
                            List of all Package 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive smart-data-table">
                            
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>
           
            
        </div>
    </section>
    <?=Functions::smartModalBeta()?>

    <!-- End main content-->


