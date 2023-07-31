    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/about/view" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> See Company Description</a> </span></small>
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
                            <form class="form-group registration-form" id="SUBMITCREATIONFORM" method="post" style="margin-bottom: 0px;" >

                                <div class="form-group row">

                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company name</label>
                                        <input type="text" required name="company_name" class="form-control">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Email</label>
                                        <input type="email" name="company_email" class="form-control">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Telephone</label>
                                        <input type="text" name="company_telephone" class="form-control">
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Address</label>
                                        <input type="text" name="company_address" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-lg-3">
                                    <label for="inputEmail3" class="col-form-label">Company Facebook Link</label>
                                        <input type="text" name="facebook_link" class="form-control">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Instagram Link</label>
                                        <input type="text" name="instagram_link" class="form-control">
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Tweeter Link</label>
                                        <input type="text" name="tweeter_link" class="form-control">
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="inputEmail3" class="col-form-label">Company Youtube Link</label>
                                        <input type="text" name="youtube_link" class="form-control">
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company About</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="" required name="b2b-info-about" placeholder="Company About"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Vision</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="" required name="b2b-info-vision" placeholder="Company Vision"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Terms</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="" required name="b2b-info-terms" placeholder="Company Tearms"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Mission</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="" required name="b2b-info-mission" placeholder="Company Mission"></textarea>
                                    </div>
                                </div>

                                <label for="inputEmail3" class="col-form-label">Company Value</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <textarea class="form-control" id="" required name="b2b-info-value" placeholder="Company Value"></textarea>
                                    </div>
                                </div>

                               
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="alNMm410CGavGIzUbnlob+LIIdLSBww+Hd4YsuHmhwY">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Register Afriexpress About</button>
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
