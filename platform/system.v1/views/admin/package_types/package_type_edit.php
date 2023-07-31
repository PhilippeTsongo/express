<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/package_type/list/0000');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);

?>

    <!-- Main content-->
    <form action="" id="FILTERFORM" class="row smart-data-info" method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_ )?>">
            <input type="hidden" name="request" id="request" value="7nr0EojM+V9sn0MvPty59wLDx3LFn6l3GYmBiUCMAl8">
            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
        </div>
    </form>
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
                            <h3>Package Type</h3>
                            <small>
                                Edit Package Type
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
                            Edit package type
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form" id="SUBMITUPDATEFORM" method="post" style="margin-bottom: 0px;" >
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Package Type Name</label>
                                    <input type="text" class="form-control package-type-name" id="" required name="package-type-name" placeholder="Package type name">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 col-form-label">Description</label>
                                    <textarea class="form-control package-type-description" id="" name="package-type-description" placeholder="Package Type Description"></textarea>
                                </div>
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="7nr0EojM+V9sn0MvPty59xk8Hl4xt2eNgzSy6dZr37E">
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


