    <!-- Main content-->
    <form action="" id="FILTERFORM" class="row smart-data-info-edit" method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES(1)?>">
            <input type="hidden" name="request" id="request" value="alNMm410CGavGIzUbnlobyZLS+LRY6hkvob/uxnaCLA">
            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
        </div>
    </form>
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/about/view" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> See Company Description</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>Afriexpress About</h3>
                            <small>
                                Discribe the company bellow
                            </small>
                        </div>
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
                            <form class="form-group registration-form" id="SUBMITUPDATEFORM" method="post" style="margin-bottom: 0px;" >

                                <div class="form-group row">

                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company name</label>
                                        <input type="text" required name="company_name" class="form-control company_name">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Email</label>
                                        <input type="email" name="company_email" class="form-control company_email">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Telephone</label>
                                        <input type="text" name="company_telephone" class="form-control company_telephone">
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Address</label>
                                        <input type="text" name="company_address" class="form-control company_address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-lg-3">
                                    <label for="inputEmail3" class="col-form-label">Company Facebook Link</label>
                                        <input type="text" name="facebook_link" class="form-control facebook_link">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Instagram Link</label>
                                        <input type="text" name="instagram_link" class="form-control instagram_link">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Tweeter Link</label>
                                        <input type="text" name="tweeter_link" class="form-control tweeter_link">
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Youtube Link</label>
                                        <input type="text" name="youtube_link" class="form-control youtube_link">
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company About</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control company_about" id="" required name="b2b-info-about" placeholder="company about"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Vision</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control company_vision" id="" required name="b2b-info-vision" placeholder="company vision"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Terms</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control company_terms" id="" required name="b2b-info-terms" placeholder="company terms"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Mission</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control company_mission" id="" required name="b2b-info-mission" placeholder="company mission"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Value</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control company_value" id="" required name="b2b-info-value" placeholder="company value"></textarea>
                                    </div>
                                </div>

                               
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES(1)?>">
                                    <input type="hidden" name="request" id="request" value="alNMm410CGavGIzUbnlob45J+FsoyKXULDXBPDzOrio">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Update Afriexpress About</button>
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
