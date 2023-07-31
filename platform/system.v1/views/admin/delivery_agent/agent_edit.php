<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/delevery/agent/edit/0000');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);

?>

    <!-- Main content-->
    <section class="content">
        <form action="" id="FILTERFORM" class="row smart-data-info" method='post'>
            <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_ )?>">
                <input type="hidden" name="request" id="request" value="qFX+tHrEhVFqBqxcyEV1MkexXUqZUC4l7/Yq1Z92hTY">
                <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
            </div>
        </form>
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
                                Edit Delivery Agent
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                
                <div class="col-md-9">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <!-- <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div> -->
                            Edit Delivery Agent
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form p-3" id="SUBMITUPDATEFORM" method="post" style="margin-bottom: 0px;" >
                                
                                <div class="form-group row">
                                    <label for="exampleInputName" class="col-sm-2 col-form-label">Edit First name</label>
                                    <input type="text" class="form-control col-sm-10" id="firstname" required name="delivery-agent-firstname" placeholder="First name">
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputName" class="col-sm-2 col-form-label">Edit Last name</label>
                                    <input type="text" class="form-control col-sm-10" id="lastname" required name="delivery-agent-lastname" placeholder="Last name">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Edit Identity Number</label>
                                    <input type="text" class="form-control col-sm-10" id="identity_number" required name="delivery-agent-identity_number" placeholder="National ID / Passport">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Edit Email</label>
                                    <input type="email" class="form-control col-sm-10" id="email" required name="delivery-agent-email" placeholder="Email">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Edit Telephone</label>
                                    <input type="text" class="form-control col-sm-10" id="telephone" required name="delivery-agent-telephone" placeholder="Telephone">
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Edit Address</label>
                                    <input type="text" class="form-control col-sm-10" id="address" required name="delivery-agent-address" placeholder="Residential Address">
                                </div>
                               
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="qFX+tHrEhVFqBqxcyEV1MsXdSjVmNAVcmn4ct82AuVFNzZk0XZj5rExNdoF5vBnc">
                                    <input type="hidden" name="webToken" id="webToken" value="<?= $HASH->encryptAES(256) ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
           
            
        </div>
    </section>
    <!-- End main content-->

