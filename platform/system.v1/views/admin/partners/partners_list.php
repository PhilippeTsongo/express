    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/partners/new" class="text-warning" style="color: white !important;"> <span class="pe-7s-home"></span> New</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>Partners</h3>
                            <small>
                                List of all partners
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
                        <form action="" id="FILTERFORM" class="row " method='post'>

                            <input type="hidden" name="request" id="request" value="rwkf0YFC31FVSrOAwy7d+oSnOwUpwH+0cyfIP1aQDV8">
                            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                
                            <div class="col-lg-4">
                                <div class="input-group m-b-xs m-t-xs">
                                    <input type="date" class="form-control" value="" name="filter-start-date" id="filter-start-date" aria-describedby="button-addon2">
                                </div> 
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group m-b-xs m-t-xs">
                                    <input type="date" class="form-control" value="" name="filter-end-date" id="filter-end-date"  aria-describedby="button-addon2">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group m-b-xs m-t-xs">
                                    <input type="text" class="form-control filter-keyword" value="" id="filter-keyword" name="filter-keyword" placeholder="Search by Name.." aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary filter_search_submit" type="" id="button-addon2"><i class="fa fa-search"></i></button>
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
                        <!-- <div class="panel-tools">
                            <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                            <a class="panel-close"><i class="fa fa-times"></i></a>
                        </div> -->
                        List of all Partners
                    </div>
                    <div class="panel-body">
                        
                        <div class="table-responsive smart-data-table">
                        
                        </div>

                    </div>
                </div>
            </div>                  
        </div>
    </div>
           
            
        </div>
    </section>
    <?=Functions::smartModalBeta()?>

    <!-- End main content-->


