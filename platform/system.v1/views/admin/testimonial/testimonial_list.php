    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/testimonial/new" class="text-warning" style="color: white !important;"> <span class="pe-7s-add-user"></span> New ICCN Testimonial</a> </span></small>
            
                                    <form action="" id="filterForm" class="row " method='post'>
                                        
                                        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                                            <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('iccn-testimonial-list')?>">
                                            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                        </div>
                                    </form>

                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-albums"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Testimonials</h3>
                            <small>
                                List Testimonials
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                            </div>
                        </div>
                        <div class="panel-body smart-data-table">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->

    <!-- Action Smart Modal -->
    <?=Functions::smartModal()?>
    <!-- End Action Smart Modal -->