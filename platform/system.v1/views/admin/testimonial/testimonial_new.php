    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/testimonial/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> List ICCN Testimonial</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Testimonial</h3>
                            <small>
                                Register New ICCN Testimonial
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
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="testimonial-name" required name="testimonial-name" placeholder="Client name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client profession</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="testimonial-profession" required name="testimonial-profession" placeholder="Client profession">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Client Image Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="testimonial-image" required name="testimonial-image" placeholder="Client Image Link">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Testimonial Short Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="testimonial-description" required name="testimonial-description" placeholder="Testimonial Short Description"></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-testimonial-new')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Register New Testimonial</button>
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
