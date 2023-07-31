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
                            <h3>ICCN Article</h3>
                            <small>
                                Register New ICCN Event
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
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Event name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="event-name" required name="event-name" placeholder="Event name">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Event Date Time</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" id="event-date" required name="event-date" placeholder="Event Date">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="time" class="form-control" id="event-time" required name="event-time" placeholder="Event Time">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Event Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="event-address" required name="event-address" placeholder="Event Address">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Event Image Link</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="event-image" required name="event-image" placeholder="Event Image Link">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Event Short Description</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="event-description_short" required name="event-description_short" placeholder="Article Short Description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <textarea class="form-control hidden" id="event-description" name="event-description" placeholder="Event Description"></textarea>
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                                    <div class="summernote col-sm-9">Description...<br/>
                                    </div>
                                </div>

                                <br> <hr> <br>

                                <div class="form-group row">
                                    <textarea class="form-control hidden" id="event-schedule" name="event-schedule" placeholder="Event Description"></textarea>
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Event Schedule</label>
                                    <div class="summernote-schedule col-sm-9">
                                        <h2 class="elementor-heading-title elementor-size-default">Event Schedules and Time</h2>
                                        <br/>
                                        Description...
                                        <br/>  <br/>
                                    </div>
                                </div>

                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-event-new')?>">
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
