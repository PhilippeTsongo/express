<style>
table tbody tr td {
    width: 16.8%;
}




</style>
   <!-- Main content-->
   <form action="" id="FILTERFORM" class="row smart-data-info" method='post'>
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
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> 
                                <a href="<?=DNADMIN?>/about/edit/<?=Hash::encryptToken(1)?>" class="text-warning" style="color: white !important;"> <span class="pe page-header-icon pe-7s-note2"></span> Update Company About</a>
                                <!-- <a href="<?=DNADMIN?>/about/new/<?=Hash::encryptToken(1)?>" class="text-warning" style="color: white !important;"> <span class="pe page-header-icon pe-7s-note2 ml-5"></span> New Company About</a> </span></small> -->
            
                            <form action="" id="filterForm" class="row " method='post'>
                                <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
                                    <input type="hidden" name="request" id="request" value="<?=$HASH->encryptAES('refresh-table-iccn-about')?>">
                                    <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
                                </div>
                            </form>

                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-albums"></i>
                        </div>
                        <div class="header-title">
                            <h3>Afriexpress About</h3>
                            <small>
                                This is the company about page
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
                        <div class="panel-body smart-data-tablee">
                            <div class="row">
                                <div class="col-md-2 company-image">
                                    <i class="pe pe-7s-user c-accent fa-4x"></i>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-hovered smart-item-table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Afriexpress  Information</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            
                                            <tr>
                                                <td>Company Name</th>
                                                <th class="company_name"></td>
                                            </tr>
                                            <tr>
                                                <td>Company Email</th>
                                                <th class="company_email"></td>
                                            </tr>
                                            <tr>
                                                <td>Company Telephone</th>
                                                <th class="company_telephone"></td>
                                            </tr>
                                            <tr>
                                                <td>Company Address</th>
                                                <th class="company_address"></td>
                                            </tr>

                                            <tr>
                                                <td>Link Facebook</th>
                                                <th class="facebook_link"></td>
                                            </tr>
                                            <tr>
                                                <td>Link Instagram</th>
                                                <th class="instagram_link"></td>
                                            </tr>
                                            <tr>
                                                <td>Link Tweeter</th>
                                                <th class="tweeter_link"></td>
                                            </tr>
                                            <tr>
                                                <td>Link Youtube</th>
                                                <th class="youtube_link"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                            </div>
                        </div>
                        <div class="panel-body smart-data-tablee">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hovered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Company About</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td> Description</td>
                                                <th class="company_about"></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                            </div>
                        </div>
                        <div class="panel-body smart-data-tablee">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hovered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Afriexpress  Mission</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Mission</td>
                                                <th class="company_mission"></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                            </div>
                        </div>
                        <div class="panel-body smart-data-tablee">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hovered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Afriexpress  Vision</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Vision</td>
                                                <th class="company_vision"></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                            </div>
                        </div>
                        <div class="panel-body smart-data-tablee">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hovered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Afriexpress  Value</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Value</th>
                                                <th class="company_value"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-filled">
                        <div class="panel-heading" style="padding-left: 30px;">
                            <div class="panel-tools">
                            </div>
                        </div>
                        <div class="panel-body smart-data-tablee">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hovered ">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Afriexpress  Terms</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td>Terms</td>
                                                <th class="company_terms"></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
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
