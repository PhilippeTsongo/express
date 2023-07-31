

    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/product/new" data-toggle="modall" data-target="#omyModal1" class="text-warning" style="color: white !important;"> <span class="pe page-header-icon pe-7s-plus"></span> New ICCN Shop Product</a> </span></small>
   
                                <form action="" id="filterForm" class="row " method='post'>
                                    <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                                        <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-shop-product-list')?>">
                                        <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    </div>
                                </form>
          
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-albums"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Shop Products</h3>
                            <small>
                                List Shop Products
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                                <!-- <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a> -->
                            </div>
                            
                        </div>
                        <div class="panel-body smart-data-table">
                            
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- End main content-->

     <!-- Action Smart Modal -->
     <div class="modal fade" id="smartModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title">Activation Account Administrator</h4>
                    <small></small>
                </div>
                <form class="form-group action-form" id="ActionForm" method="post" >
                    <div class="modal-body">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Do you really want to activate this administrator ?</label>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_id_" id="token" value="">
                        <input type="hidden" name="request" id="request" value="">
                        <input type="hidden" name="webToken" id="webToken" value="">
                        <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-action">Action</button>
                    </div>
                </form>
            </div>
        </div>
    </div>  
    <!-- End Action Smart Modal -->