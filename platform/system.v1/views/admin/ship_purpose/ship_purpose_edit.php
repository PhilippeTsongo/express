<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/prohibited/product/list/0000');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);

?>
    <!-- Main content-->
    <form action="" id="FILTERFORM" class="row smart-data-info" method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_ )?>">
            <input type="hidden" name="request" id="request" value="hWdzbgvdAV5KQpOGLVZSHrdboHE9/4MbM4TH7b+tb+o">
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
                            <h3>Ship Purpose</h3>
                            <small>
                            Edit Ship Purpose 
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
                            Edit Ship Purpose
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form" id="SUBMITUPDATEFORM" method="post" style="margin-bottom: 0px;" >
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Ship Purpose Name</label>
                                    <input type="text" class="form-control col-md-12" id="name" required name="ship-purpose-name" placeholder="Designation">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-12 col-form-label">Description</label>
                                    <textarea class="form-control" id="description" name="ship-purpose-description" placeholder="Ship Purpose Description"></textarea>
                                </div>
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="hWdzbgvdAV5KQpOGLVZSHiGhZIovTGl32qLzObtL2dQ">
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


