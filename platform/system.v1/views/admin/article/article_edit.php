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
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/article/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> List ICCN Articles</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Article</h3>
                            <small>
                                Edit New ICCN Article
                            </small>
                        </div>
                        <form  id="filterForm" class="row " method='post'>
                                <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                                    <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-article-data')?>">
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
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="article-name" required name="article-name" placeholder="Article name">
                                    </div>
                                </div>
                                <div class="form-group row"  style="display: none;">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article Url Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="article-url_title"  name="article-url_title" placeholder="Article Url Title">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article Date</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="article-date" required name="article-date" placeholder="Article Date">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="time" class="form-control" id="article-time" required name="article-time" placeholder="Article Time">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article Image Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="article-image" required name="article-image" placeholder="Article Image Link">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article Short Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="article-description_short" required name="article-description_short" placeholder="Article Short Description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <textarea class="form-control hidden" id="article-description" name="article-description" placeholder="Article Description"></textarea>
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="summernote col-sm-9">Description...<br/>
                                    </div>
                                </div>

                                <!-- <hr> -->
                                <div class="modal-footer">
                                     <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-article-update')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Update Article</button>
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
