    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>" class="text-warning" style="color: white !important;"> <span class="pe-7s-home"></span> Dashboard</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>Unit New</h3>
                            <small>
                                Unit New
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

                <div class="col-md-7">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <!-- <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div> -->
                            Add new Unit
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form" id="SUBMITCREATIONFORM" method="post" style="margin-bottom: 0px;" >
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Unit Name</label>
                                    <input type="text" class="form-control" id="admin-firstname" required name="ship-unit-name" placeholder="Designation">
                                </div>
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="YPbi1CxzH3jknP9CjeD1Q+HKCUhV3wtbF59Yh72Vspw">
                                    <input type="hidden" name="webToken" id="webToken" value="<?= $HASH->encryptAES(256) ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
           
            
        </div>
    </section>
    <!-- End main content-->


