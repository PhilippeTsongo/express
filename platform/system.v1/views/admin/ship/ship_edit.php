<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/ship/list/0000');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);

echo $_ID_;

?>    
    
    <!-- Main content-->
    
    <!-- shipement data form -->
    <form action="" id="FILTERFORM" class="row smart-data-info-edit" method='post'>
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
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>/ship/list" class="text-warning" style="color: white !important;"> <span class="pe-7s-albums"></span> Ship List</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-edit"></i>
                        </div>
                        <div class="header-title">
                            <h3>Edit Shipment</h3>
                            <small>
                                Edit this Shipment bellow
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 all-wrapper">
                    <div class="panel panel-filled">
                        <!-- <div class="panel-heading"> -->
                        <!-- <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div> -->
                        <!-- Edit Shipment
                        </div> -->


                        <form class="form-group registration-form p-3" id="SUBMITUPDATEFORM" method="post" style="margin-bottom: 0px;">

                            <div class="steps-w">
                                <div class="step-triggers">
                                    <a class="step-trigger active" href="#stepContent1">Source Information</a>
                                    <a class="step-trigger" href="#stepContent2">Destination Information</a>
                                    <a class="step-trigger" href="#stepContent3">Shipment Information</a>
                                    <a class="step-trigger" href="#stepContent4">Shipment Items</a>
                                </div>
                                <div class="step-contents">
                                    <div class="panel-body p-8 step-content active" id="stepContent1">
                                        <div class="form-group row px-5">
                                            <label for="exampleInputName" class="col-sm-3 col-form-label">First name</label>
                                            <input type="text" class="form-control col-sm-7 source_firstname" id="source_firstname" required name="source_firstname" placeholder="">
                                        </div>
                                        <div class="form-group row px-5">
                                            <label for="exampleInputName" class="col-sm-3 col-form-label">Last name</label>
                                            <input type="text" class="form-control col-sm-7 source_lastname" id="source_lastname" required name="source_lastname" placeholder="">
                                        </div>
                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                            <input type="email" class="form-control col-sm-7 source_email" id="source_email" required name="source_email" placeholder="">
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Source Country</label>
                                            <select type="text" class="form-control col-sm-7 source_country" id="source_country" required name="source_country">
                                                <option value="" disabled selected>Select the source country</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Source Province</label>
                                            <select type="text" class="form-control col-sm-7 source_province" id="source_province" required name="source_province">
                                                <option value="" disabled selected>Select the source province</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Source City</label>
                                            <select type="text" class="form-control col-sm-7 source_city" id="source_city" required name="source_city">
                                                <option value="" disabled selected>Select the source City</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Address</label>
                                            <input type="type" class="form-control col-sm-7 source_address_1" id="source_address_1" required name="source_address_1" placeholder="">
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Address 2</label>
                                            <input type="type" class="form-control col-sm-7 source_address_2" id="source_address_2" required name="source_address_2" placeholder="">
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Telephone</label>
                                            <input type="text" class="form-control col-sm-7 source_telephone" id="source_telephone" required name="source_telephone" placeholder="">
                                        </div>
                                        <div class="modal-footer row px-5">
                                            <a type="" class="btn btn-default step-trigger-btn" href="#stepContent2">Next</a>
                                        </div>
                                    </div>

                                    <div class="panel-body p-8 step-content" id="stepContent2">
                                        <div class="form-group row px-5">
                                            <label for="exampleInputName" class="col-sm-3 col-form-label">First name</label>
                                            <input type="text" class="form-control col-sm-7 destination_firstname" id="destination_firstname" required name="destination_firstname" placeholder="">
                                        </div>
                                        <div class="form-group row px-5">
                                            <label for="exampleInputName" class="col-sm-3 col-form-label">Last name</label>
                                            <input type="text" class="form-control col-sm-7 destination_lastname" id="destination_lastname" required name="destination_lastname" placeholder="">
                                        </div>
                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                                            <input type="email" class="form-control col-sm-7 destination_email" id="destination_email" required name="destination_email" placeholder="">
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Destination Country</label>
                                            <select type="text" class="form-control col-sm-7 destination_country" id="destination_country" required name="destination_country">
                                                <option value="" disabled selected>Select the destination country</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Destination Province</label>
                                            <select type="text" class="form-control col-sm-7 destination_province" id="destination_province" required name="destination_province">
                                                <option value="" disabled selected>Select the destination province</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Destination City</label>
                                            <select type="text" class="form-control col-sm-7 destination_city" id="destination_city" required name="destination_city">
                                                <option value="" disabled selected>Select the destination City</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Address</label>
                                            <input type="type" class="form-control col-sm-7 destination_address_1" id="destination_address_1" required name="destination_address_1" placeholder="">
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Address 2</label>
                                            <input type="type" class="form-control col-sm-7 destination_address_2" id="destination_address_2" required name="destination_address_2" placeholder="">
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Telephone</label>
                                            <input type="text" class="form-control col-sm-7 destination_telephone" id="destination_telephone" required name="destination_telephone" placeholder="">
                                        </div>
                                        <div class="modal-footer px-5">
                                            <a type="" class="btn btn-default step-trigger-btn" href="#stepContent1">Previous</a>
                                            <a type="" class="btn btn-default step-trigger-btn" href="#stepContent3">Next</a>
                                        </div>
                                    </div>


                                    <div class="panel-body p-8 step-content" id="stepContent3">
                                        <div class="px-5">
                                            <h5>What are you shipping?</h5>
                                            <div class="form-group row"> 
                                                <div class="col-lg-6">
                                                    <input type="radio" name="ship_item_type" id="ship_item_type" value="DOCUMENT" checked>
                                                    <label for="defaultradio">Documents</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="radio" name="ship_item_type" id="ship_item_type" value="PACKAGE">
                                                    <label for="radio1">Packages</label>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>


                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Shipment purpose</label>
                                            <select type="text" class="form-control col-sm-7 ship_purpose" id="ship_purpose" required name="ship_purpose">
                                                <option value="" disabled selected>Select the shipment purpose</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Shipment label</label>
                                            <input type="text" class="form-control col-sm-7 ship_label" name="ship_label" id="ship_label">

                                        </div>


                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Source Pickup type</label>
                                            <select type="text" class="form-control col-sm-7 source_pickup_type" id="source_pickup_type" required name="source_pickup_type">
                                                <option value="" disabled selected>Select the source pickup type</option>

                                            </select>
                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Source Pickup Location</label>
                                            <input type="text" class="form-control col-sm-7 source_pickup_location" name="source_pickup_location" id="source_pickup_location">

                                        </div>

                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Destination Pickup type</label>
                                            <select type="text" class="form-control col-sm-7 source_pickup_type" id="destination_pickup_type" required name="destination_pickup_type">
                                                <option value="" disabled selected>Select the destination pickup type</option>

                                            </select>
                                        </div>

                                        
                                        <div class="form-group row px-5">
                                            <label for="inputEmail3" class="col-sm-3 col-form-label">Destination Pickup Location</label>
                                            <input type="text" class="form-control col-sm-7 destination_pickup_location" name="destination_pickup_location" id="destination_pickup_location">
                                        </div>

                                        <div class="modal-footer px-5">
                                            <a type="" class="btn btn-default step-trigger-btn" href="#stepContent2">Previous</a>
                                            <a type="" class="btn btn-default step-trigger-btn" href="#stepContent4">Next</a>
                                        </div>

                                    </div>

                                    <div class="panel-body p-2 step-content" id="stepContent4">
                                       
                                        <h5>Describe each unique item in your shipment separately</h5>

                                        <div class="smart-data-table-items">

                                        </div>
                                        <!-- <table class="table table-hover table-bordered table-responsive-sm" id="smartTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Item Name</th>
                                                    <th>Qunatity</th>
                                                    <th>Item Unit</th>
                                                    <th>Item Value</th>
                                                    <th>Currency</th>
                                                    <th>Item Weight(kg)</th>
                                                    <th>Item Dimension(ex: 50cm x 10cm)</th>
                                                    <th>Item Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="item-check-box">
                                                        <input class="itemRow" type="checkbox">
                                                    </td>
                                                    <td><input type="text" id="item_name" class="form-control" id="iship-item-name-1" name="ship-item-name"></td>
                                                    <td><input type="text" id="item_quantity" class="form-control" id="ship-item-quantity-1" name="ship-item-quantity"></td>
                                                    <td>
                                                        <select type="text" class="form-control" required id="hip-item-unit-1" name="hip-item-unit">
                                                            <option value="" disabled selected>Select item unit</option>

                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control" id="ship-item-price-1" name="ship-item-price" ></td>

                                                    <td>
                                                        <select type="text" class="form-control" required id="ship-item-currency-1" name="ship-item-currency">
                                                            <option value="" disabled selected>Select currency</option>

                                                        </select>
                                                    </td>

                                                    <td><input type="text" class="form-control" id="ship-item-weight-1" name="ship-item-weight" ></td>

                                                    <td><input type="text" class="form-control" id="ship-item-dimension-1" name="ship-item-dimension" ></td>

                                                    <td><input type="text" class="form-control" id="item_description" name="item_description" ></td>
                                                </tr>
                                            </tbody>
                                        </table> -->
                                       
                                        <div class="row">
                                            <div class="col-lg-12">
                                            <button class="btn btn-danger delete btn-sm" id="removeRows" type="button">-
                                                Delete</button>
                                            <button class="btn btn-primary btn-sm" id="addRows" type="button">+ Add Item</button>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="modal-footer px-5">
                                            <input type="hidden" name="_id_" id="token" value="<?=$HASH->encryptAES($_ID_)?>">
                                            <input type="hidden" name="request" id="request" value="hWdzbgvdAV5KQpOGLVZSHnm/aeH6nX2N2TjxXGqOUZ4">
                                            <input type="hidden" name="webToken" id="webToken" value="<?= $HASH->encryptAES(256) ?>">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                    </div> 


                                </div>
                            </div>



                        </form>


                    </div>

                </div>
            </div>


        </div>
    </section>
    <!-- End main content-->