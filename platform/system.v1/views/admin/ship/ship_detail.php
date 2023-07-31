    <!-- Main content-->
<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/ship/list/0000');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);



?>



    <form action="" id="FILTERFORM" class="row smart-data-info" method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_ )?>">
            <input type="hidden" name="request" id="request" value="hWdzbgvdAV5KQpOGLVZSHtorfet+ICL3GPrxTqkpjCM">
            <input type="hidden" name="webToken" id="webToken" value="<?=$HASH->encryptAES(256)?>">
        </div>
    </form>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/ship/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-home"></span>List</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-users"></i>
                        </div>
                        <div class="header-title">
                            <h3> Shipment Details </h3>
                            <small>
                                 Shipments Details
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

        <div class="row">
          
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div>
                                    <h2 class="m-t-xs m-b-none code">
                                        
                                    </h2>
                                    Ship description: 
                                    <small class="ship_description">
                                       
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <table class="table small m-t-sm">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <strong class="c-white">ship label: </strong> <span class="ship_label"> </span>
                                            </td>
                                            <td>
                                                <strong class="c-white">Ship purpose: </strong> <span id="ship_purpose"> </span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <strong class="c-white">date: </strong> <span class="creation_date"> </span>
                                            </td>
                                            <td>
                                                <strong class="c-white">ship items type: </strong> <span class="ship_item_type"></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-2 m-t-sm">
                                <span class="c-white">
                                    Ship additional detail
                                </span>
                                <br>
                                <small class="ship_additional_detail">
                                   
                                </small>
                                <br>
                                <div class="btn-group m-t-sm">
                                        <div class="btn-group">
                                           Status:  <button data-toggle="dropdown" class="btn btn-xs ml-2 btn-default ship_status"> </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-filled">
                    <div class="panel-body">

                    <div class="panel">
                            <div class="panel-body">
                                <h4> Ship Status Progress</h4>

                                <div class="v-timeline vertical-container ship_status_history">
                                    
                                
                                    <!-- <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div class="vertical-timeline-content">
                                            <div class="p-sm">
                                                <span class="vertical-date pull-right"> <small>1 day ago</small> </span>

                                                <h2>Update profile</h2>

                                                <p>Change profile name and set new profile description</p>
                                            </div>
                                        </div>
                                    </div> -->
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-filled">
                    <div class="panel-heading" style="padding-left: 30px;">
                        <div class="panel-tools">
                        </div>
                    </div>
                    <div class="panel-body ">
                        <div class="row">
                            
                            <div class="col-md-12">
                                <table class="table table-hovered smart-item-table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Source Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>First name</th>
                                            <th class="source_firstname"></td>
                                        </tr>
                                        <tr>
                                            <td>Last name </th>
                                            <th class="source_lastname"></td>
                                        </tr>
                                        <tr>
                                            <td>Telephone</th>
                                            <th class="source_telephone"></td>
                                        </tr>
                                        <tr>
                                            <td>Email</th>
                                            <th class="source_email"></td>
                                        </tr>
                                        <tr>
                                            <td>Country</th>
                                            <th class="source_country"></td>
                                        </tr>
                                        <tr>
                                            <td>Province</th>
                                            <th class="source_province"></td>
                                        </tr>
                                        <tr>
                                            <td>City</th>
                                            <th class="source_city"></td>
                                        </tr>
                                        <tr>
                                            <td>Address 1</th>
                                            <th class="source_address_1"></td>
                                        </tr>
                                        <tr>
                                            <td>Address 2</th>
                                            <th class="source_address_2"></td>
                                        </tr>
                                        <tr>
                                            <td>Company name</th>
                                            <th class="source_company_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Pickup type</th>
                                            <th class="source_pickup_type"></td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Location</th>
                                            <th class="source_pickup_location"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-4">
                <div class="panel panel-filled">
                    <div class="panel-heading" style="padding-left: 30px;">
                        <div class="panel-tools">
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                          
                            <div class="col-md-12">
                                <table class="table table-hovered smart-item-table">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Destination Information</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>First name</th>
                                            <th class="destination_firstname"></td>
                                        </tr>
                                        <tr>
                                            <td>Last name </th>
                                            <th class="destination_lastname"></td>
                                        </tr>
                                        <tr>
                                            <td>Telephone</th>
                                            <th class="destination_telephone"></td>
                                        </tr>
                                        <tr>
                                            <td>Email</th>
                                            <th class="destination_email"></td>
                                        </tr>
                                        <tr>
                                            <td>Country</th>
                                            <th class="destination_country"></td>
                                        </tr>
                                        <tr>
                                            <td>Province</th>
                                            <th class="destination_province"></td>
                                        </tr>
                                        <tr>
                                            <td>City</th>
                                            <th class="destination_city"></td>
                                        </tr>
                                        <tr>
                                            <td>Address 1</th>
                                            <th class="destination_address_1"></td>
                                        </tr>
                                        <tr>
                                            <td>Address 2</th>
                                            <th class="destination_address_2"></td>
                                        </tr>

                                        <tr>
                                            <td>Company name</th>
                                            <th class="destination_company_name"></td>
                                        </tr>
                                        <tr>
                                            <td>Pickup type</th>
                                            <th class="destination_pickup_type"></td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Location</th>
                                            <th class="destination_pickup_location"></td>
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
    <?=Functions::smartModalBeta()?>

    <!-- End main content-->

