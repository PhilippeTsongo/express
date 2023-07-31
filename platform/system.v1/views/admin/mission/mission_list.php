

    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?=DNADMIN?>/mission/new" class="text-warning" style="color: white !important;"> <span class="pe-7s-add-user"></span> Edit ICCN Mission/Vision</a> </span></small>
            
                                <!-- <div class="ibox-content" style="/**padding: 15px 20px 0px 20px;*/"> -->

                                    <!-- <h9>Filter By:</h9> -->
                                    <form action="" id="filterForm" class="row " method='post'>
                                        
                                        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                                            <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('refresh-table-admin')?>">
                                            <input type="hidden" name="request-groups" id="request-groups" value="<?=$HASH->encryptAES('form-select-get-account-groups-by-type')?>">
                                            <input type="hidden" name="request-events" id="request-events" value="<?=$HASH->encryptAES('form-select-get-account-events-by-type')?>">
                                            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                            <!-- <button type="submit" style="border-radius: 0px;"  autocomplete="off" class="btn btn-sm btn-primary "> <i class=" fa fa-filter"></i> Filter </button>
                                            <button type="submit" style="border-radius: 0px;"  autocomplete="off" class="btn btn-sm btn-primary "> <i class=" fa fa-file-excel-o"></i> Excel </button>
                                        <button type="submit" style="border-radius: 0px;"  autocomplete="off" class="btn btn-sm btn-primary "> <i class=" fa fa-file-pdf-o "></i> Pdf </button> -->
                                        </div>
                                    </form>
                                <!-- <hr> -->
                                <!-- </div> -->

                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-albums"></i>
                        </div>
                        <div class="header-title">
                            <h3>ICCN Mission/ Vision</h3>
                            <small>
                                List Mission/ Vision
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
    


