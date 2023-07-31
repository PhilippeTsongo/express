    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/delivery/agent/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> Agents List</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-users"></i>
                        </div>
                        <div class="header-title">
                            <h3> Delivery Agents</h3>
                            <small>
                                Register New Delivery Agent
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
                            Register New Agent
                        </div>
                        <div class="panel-body p-3">
                            <form class="form-group registration-form p-3" id="SUBMITCREATIONFORM" method="post" style="margin-bottom: 0px;" >
                                
                                <div class="form-group row">
                                    <label for="exampleInputName" class="col-sm-2 col-form-label">First name</label>
                                    <input type="text" class="form-control col-sm-10" id="delivery-agent-firstname" required name="delivery-agent-firstname" placeholder="First name">
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputName" class="col-sm-2 col-form-label">Last name</label>
                                    <input type="text" class="form-control col-sm-10" id="delivery-agent-lastname" required name="delivery-agent-lastname" placeholder="Last name">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Identity Number</label>
                                    <input type="text" class="form-control col-sm-10" id="delivery-agent-identity_number" required name="delivery-agent-identity_number" placeholder="National ID / Passport">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <input type="email" class="form-control col-sm-10" id="delivery-agent-email" required name="delivery-agent-email" placeholder="Email">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Telephone</label>
                                    <input type="text" class="form-control col-sm-10" id="delivery-agent-telephone" required name="delivery-agent-telephone" placeholder="Telephone">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Address</label>
                                    <input type="type" class="form-control col-sm-10" id="delivery-agent-address" required name="delivery-agent-address" placeholder="Residential Address">
                                </div>
                                
                                <!-- <hr> -->
                                <div class="modal-footer">
                                <input type="hidden" name="request" id="request" value="qFX+tHrEhVFqBqxcyEV1MipfUm5sKQ/DIK2wNIfrDhwNesntdQCwATepaGhL9n4a">
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

