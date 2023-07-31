    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <!-- <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>" class="text-warning" style="color: white !important;"> <span class="pe-7s-home"></span> Dashboard</a> </span></small> -->
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>New Partners</h3>
                            <small>
                                Add New Partner
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <!-- <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div> -->
                            Add new partner
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form" id="SUBMITCREATIONFORM" method="post" style="margin-bottom: 0px;" >
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Partner Name</label>
                                    <input type="text" class="form-control" id="admin-firstname" required name="partner-name" placeholder="Designation">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Website</label>
                                    <input type="text" class="form-control" id="admin-firstname" required name="partner-website" placeholder="https://example.com">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Phone Number</label>
                                    <input type="number" class="form-control" id="admin-firstname" required name="partner-telephone" placeholder="Telephone Number">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Email</label>
                                    <input type="text" class="form-control" id="admin-firstname" required name="partner-email" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Address</label>
                                    <input type="text" class="form-control" id="admin-firstname" required name="partner-address" placeholder="Physical Address">
                                </div>
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="rwkf0YFC31FVSrOAwy7d+lVYdVuMeegDaJ8AFlMpd/Q">
                                    <input type="hidden" name="webToken" id="webToken" value="<?= $HASH->encryptAES(256) ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
           
            
        </div>
    </section>
    <!-- End main content-->


