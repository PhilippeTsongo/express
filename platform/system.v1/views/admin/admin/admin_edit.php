<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/admin/list');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);

?>


    
    <!-- Main content-->
    <form action="" id="FILTERFORM" class="row smart-data-info" method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_ )?>">
            <input type="hidden" name="request" id="request" value="1R50cZ7glnrp5f4gC8YXL61PIwzsST3RHQbudKRfYmk">
            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
        </div>
    </form>
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/admin/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> List Admins</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-users"></i>
                        </div>
                        <div class="header-title">
                            <h3> Afriexpress Global Administrators</h3>
                            <small>
                                Register New Admin
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-7">
                    <div class="panel panel-filled">
                        <div class="panel-heading p-3">
                            <!-- <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div> -->
                            Register New Administrator
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form p-3" id="SUBMITUPDATEFORM" method="post" style="margin-bottom: 0px;" >
                                <!-- <div class="form-group row">
                                    <label for="userType" class="col-sm-2 col-form-label">User Type</label>
                                    <select type="text" class="form-control col-sm-10" id="userType" required name="account-type" placeholder="Telephone">
                                        <option value="" disabled selected>Select User Type</option>
                                        <option value="">Admin</option>
                                        
                                    </select>
                                </div> -->
                                <div class="form-group row">
                                    <label for="exampleInputName" class="col-sm-2 col-form-label">First name</label>
                                    <input type="text" class="form-control col-sm-10" id="account-firstname" required name="account-firstname" placeholder="First name">
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputName" class="col-sm-2 col-form-label">Last name</label>
                                    <input type="text" class="form-control col-sm-10" id="account-lastname" required name="account-lastname" placeholder="Last name">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                                    <input type="email" class="form-control col-sm-10" id="account-email" required name="account-email" placeholder="Email">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Telephone</label>
                                    <input type="number" class="form-control col-sm-10" id="account-telephone" required name="account-telephone" placeholder="Telephone">
                                </div>
                               
                                <div class="modal-footer">
                                    <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="1R50cZ7glnrp5f4gC8YXL7K6ztTcB1PVzMq1SgQ4dwM4M4aU9sWGv2mwd5K42kVtL1zA+bLWNyRYBqQbRl9nYQ">
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

