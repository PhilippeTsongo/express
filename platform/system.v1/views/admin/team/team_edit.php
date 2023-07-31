<?php
if(!Input::checkInput('token', 'get', 1))
Redirect::to(DNADMIN.'/admin/list');

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
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/team/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> List ICCN Team Members</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Team Members</h3>
                            <small>
                                Register New ICCN Team Member
                            </small>
                        </div>
                        <form  id="filterForm" class="row " method='post'>
                                <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                                    <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-team-data')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                </div>
                        </form>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <div class="panel-tools">
                                <!-- <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a> -->
                            </div>
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form-update" id="ActionForm" method="post" style="margin-bottom: 0px;" >
                                
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Full name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="team-name" required name="team-name" placeholder="Full name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Profession</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="team-profession" required name="team-profession" placeholder="Profession">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Profile Image Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="team-image" required name="team-image" placeholder="Profile Image Link">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Social Media</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="team-facebook_link" required name="team-facebook_link" placeholder="Facebook Link">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="team-tweeter_link" required name="team-tweeter_link" placeholder="Tweeter Link">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="team-linkedin_link" required name="team-linkedin_link" placeholder="LinkedIn Link">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                     <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-team-update')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Register New Team Member</button>
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