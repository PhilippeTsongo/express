<?php
if(!Input::checkInput('token', 'get', 1))
Redirect::to(DNADMIN.'/gallery/list');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);
?>     
        <!-- Main content-->
        <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/gallery/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> List ICCN Gallery</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Gallery</h3>
                            <small>
                                Update ICCN Gallery
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">

                <div class="col-md-10">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <!-- <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a> -->
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form" id="SubmitRegisterForm" method="post" style="margin-bottom: 0px;" >
                                
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label"> Image Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="gallery-image" required name="gallery-image" placeholder="Image Link">
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-gallery-update')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Update Gallery</button>
                                </div>
                            </form>
                        </div>
                    </div>
                  
                </div>
            </div>
           
            
        </div>
    </section>
    <!-- End main content-->


<script>
    $(document).ready(function () {
        $(".select2_demo_1").select2();
        $(".select2_demo_2").select2({
            placeholder: "Select a state",
            allowClear: true
        });
        $(".select2_demo_3").select2();
    })
</script>
