    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/admin/new" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> New Admin</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-users"></i>
                        </div>
                        <div class="header-title">
                            <h3> Afriexpress Global Administrators</h3>
                            <small>
                                 Administrators List
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
                            
                            <!-- REQUEST AND WEBTOKEN -->
                            <input type="hidden" name="request" id="request" value="1R50cZ7glnrp5f4gC8YXL7kU8re3OtpOzLsny7wGMWY">
                            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                            
                            <div class="col-lg-3">
                                <select class="form-control m-b-xs m-t-xs" name="filter-status" id="filter-status" style="width: 100%">
                                    <option value="" selected="">Filter By</option>
                                    <option value="" selected="">All Status</option>
                                    <option value="ACTIVE">Active</option>
                                    <option value="DEACTIVE">Deactive</option>
                                </select>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-group m-b-xs m-t-xs">
                                    <input type="date" class="form-control" value="" name="filter-start-date" id="filter-start-date" aria-describedby="button-addon2">
                                </div> 
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group m-b-xs m-t-xs">
                                    <input type="date" class="form-control" value="" name="filter-end-date" id="filter-end-date"  aria-describedby="button-addon2">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="input-group m-b-xs m-t-xs">
                                    <input type="search" class="form-control" value="" name="filter-keyword" id="filter-keyword" placeholder="User firstname"  aria-describedby="button-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary filter_search_submit" id="button-addon2"><i class="fa fa-search"></i></button>
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
                            List of all admins
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

