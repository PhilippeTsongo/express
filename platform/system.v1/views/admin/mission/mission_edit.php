    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/event/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> List ICCN Events</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-note2"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Events</h3>
                            <small>
                                Edit New ICCN Event
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
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="article-name" required name="article-firstname" placeholder="Article name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article Date</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="article-date" required name="article-lastname" placeholder="Article Date">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="article-time" required name="article-lastname" placeholder="Article Time">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Article Image Link</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" id="article-image_link" required name="article-image_link" placeholder="Article Image Link">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="summernote col-sm-9">Description...<br/>
                                    </div>
                                </div>

                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('admin-new')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Register New Article</button>
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
