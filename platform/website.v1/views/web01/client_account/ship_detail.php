<?php
if(!Input::checkInput('token', 'get', 1))
    Redirect::to(DNADMIN.'/my_account/0000');

$_TOKEN_ = Input::get('token', 'get');
$_ID_    = Hash::decryptToken($_TOKEN_);


?>
<style>
    .btContentHolder figure, .btContentHolder img, .btContentHolder select, .btContentHolder embed, .btContentHolder iframe {
        max-width: auto !important;
        height: auto !important;
    }
    .shipqrcode{
        width: 100px !important;
        height: 100px !important;
    }

</style>


<!-- /.mainHeader -->
<form action="" id="FILTERFORM" class="row" method='post'>
        <div class="col-md-6 action-btn hidden" style="padding-top: 0px;">
            <input type="hidden" name="_id_" id="_id_" value="<?=$HASH->encryptAES($_ID_ )?>">
        </div>
</form>

<div class="btContentWrap btClear">
    <div class="btContentHolder">
        <div class="btContent">
            <div class="bt_rc_container">
                <section id="slider" class="boldSection btDarkSkin inherit">
                    <div class="port">
                        <div class="boldCell">
                            <div class="boldCellInner">
                                <div class="boldRow ">
                                    <div class="rowItem col-md-12 col-ms-12  btTextLeft inherit">
                                        <div class="rowItemContent">
                                            <div class="slided autoSliderHeight">
                                                <div class="slidedItem firstItem" data-thumb="https://cargo.bold-themes.com/transport-company/wp-content/uploads/sites/2/2015/10/plane_contrasted_light-320x138.jpg">
                                                    <div class="btSliderPort wBackground cover" style="background-image: url('<?= $__IMAGESPATH__ ?>/wp-content/uploads/sites/2/2015/10/plane_contrasted_light.jpg')">
                                                        <div class="btSliderCell" data-slick="yes">
                                                            <div class="btSlideGutter">
                                                                <div class="btSlidePane">
                                                                    <div class="btClear btSeparator topSpaced noBorder">
                                                                        <hr>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>



                <section id="bt_section64091b9179984" data-parallax="0.1" data-parallax-offset="0" class="boldSection topSmallSpaced bottomSmallSpaced btDarkSkin gutter" style="background-color:white; background-image:url('<?=$__IMAGESPATH__?>/wp-content/uploads/sites/2/2015/09/Transparent-background-with-dots.pn');">
                    <div class="port">
                        <div class="boldCell">
                            <div class="boldCellInner">
                                <div class="boldRow ">
                                    
                                    <div class="rowItem btLeftBorder col-md-3 col-sm-12 col-ms-12 btTextLeft btMiddleVertical">
                                        <div class="rowItemContent">
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                            <div class="servicesItem  mediumIcon borderlessIconType ">
                                                <div class="sIcon">
                                                    <div class="btIco medium  borderless">
                                                        <a href="#" data-ico-cs="&#xe610;" class="btIcoHolder"></a>
                                                    </div>
                                                </div>
                                                <div class="sTxt">
                                                    <header class="header btClear extrasmall">
                                                        <div class="dash">
                                                            <h4><span class="headline" style="color: black">Ship Label</span></h4>
                                                            
                                                        </div>
                                                    </header>
                                                    <span style="color: black" class="ship_label"> 
                                                    </span>
                                                    <br>
                                                    <span style="color: black" class="code">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="rowItem btLeftBorder col-md-3 col-sm-12 col-ms-12 btTextLeft btMiddleVertical">
                                        <div class="rowItemContent">
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                            <div class="servicesItem  mediumIcon borderlessIconType ">
                                                <div class="sIcon">
                                                    <div class="btIco medium  borderless">
                                                        <a href="#" data-ico-cs="&#xe610;" class="btIcoHolder"></a>
                                                    </div>
                                                </div>
                                                <div class="sTxt">
                                                    <header class="header btClear extrasmall">
                                                        <div class="dash">
                                                            <h4><span class="headline" style="color: black">Ship Purpose</span></h4>
                                                        </div>
                                                    </header>
                                                    <p style="color: black" class="ship_purpose">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="rowItem btLeftBorder col-md-3 col-sm-12 col-ms-12 btTextLeft btMiddleVertical">
                                        <div class="rowItemContent">
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                            <div class="servicesItem  mediumIcon borderlessIconType ">
                                                <div class="sIcon">
                                                    <div class="btIco medium  borderless">
                                                        <a href="#" data-ico-cs="&#xe610;" class="btIcoHolder"></a>
                                                    </div>
                                                </div>
                                                <div class="sTxt">
                                                    <header class="header btClear extrasmall">
                                                        <div class="dash">
                                                            <h4><span class="headline" style="color: black">Sender</span></h4>
                                                        </div>
                                                    </header>
                                                    <p style="color: black" class="source_firstname_lastname">
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rowItem btLeftBorder col-md-3 col-sm-12 col-ms-12 btTextLeft btMiddleVertical">
                                        <div class="rowItemContent">
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                            <div class="servicesItem  mediumIcon borderlessIconType ">
                                                <div class="sIcon">
                                                    <div class="btIco medium  borderless">
                                                        <a href="#" data-ico-cs="&#xe610;" class="btIcoHolder"></a>
                                                    </div>
                                                </div>
                                                <div class="sTxt">
                                                    <header class="header btClear extrasmall">
                                                        <div class="dash">
                                                            <h4><span class="headline" style="color: black">Print</span></h4>
                                                        </div>
                                                    </header>
                                                    <a target="blank" href="<?=DNADMIN?>/ship/docs/<?=$_TOKEN_?>" class="btn btn-primary text-white">Print</a>
                                                </div>
                                            </div>
                                            <div class="btClear btSeparator topExtraSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="rowItem col-md-12 col-sm-12 col-ms-12 " style="z-index: 10;">
                                        <div class="rowItemContent">
                                            <div class="btClear btSeparator topSmallSpaced noBorder">
                                                <hr>
                                            </div>
                                            <!-- qr code  -->
                                            <div class="servicesItem  mediumIcon colorless borderlessIconType shipqrcode" id="shipqrcode"></div>
                                            <div class="btClear btSeparator topSmallSpaced noBorder">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="bt_section64091b9179ffc" data-parallax="0.1" data-parallax-offset="0" class="boldSection topSpaced bottomSpaced gutter inherit btParallax wBackground cover" style="background-image:url('<?= DNADMIN ?>/build/web01/assets/wp-content/uploads/sites/2/2015/10/Gray-background-with-dots4.png');">
                    <div class="port">
                        <div class="boldCell">
                            <div class="boldCellInner">
                                <div class="boldRow ">
                                    <div class="rowItem col-sm-4 col-ms-12 animate animate-fadein inherit btDoublePadding">
                                        <div class="rowItemContent">

                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="page-header" style="padding: -10px; margin: 0px; margin-left: 10px">
                                            <!-- <h2 id="timeline">Shipment Status</h2> -->
                                        </div>
                                        <ul class="timeline" id="ship_status_timeline">
                                            <!-- <li>
                                                <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title status"> </h4>
                                                        <p><small class="text-muted"><i class="glyphicon glyphicon-calendar"></i> 18-04-2023 16:56</small></p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                                                    </div>
                                                </div>
                                            </li> -->
                                            <!-- <li class="timeline-inverted">
                                                <div class="timeline-badge success"><i class="glyphicon glyphicon-check"></i></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title">Aproved</h4>
                                                        <p><small class="text-muted"><i class="glyphicon glyphicon-calendar"></i> 18-04-2023 16:56</small></p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p>Mussum ipsum cacilds, vidis litro abertis. Consetis adipiscings elitis. Pra lá , depois divoltis porris, paradis. Paisis, filhis, espiritis santis. Mé faiz elementum girarzis, nisi eros vermeio, in elementis mé pra quem é amistosis quis leo. Manduma pindureta quium dia nois paga. Sapien in monti palavris qui num significa nadis i pareci latim. Interessantiss quisso pudia ce receita de bolis, mais bolis eu num gostis.</p>
                                                        <p>Suco de cevadiss, é um leite divinis, qui tem lupuliz, matis, aguis e fermentis. Interagi no mé, cursus quis, vehicula ac nisi. Aenean vel dui dui. Nullam leo erat, aliquet quis tempus a, posuere ut mi. Ut scelerisque neque et turpis posuere pulvinar pellentesque nibh ullamcorper. Pharetra in mattis molestie, volutpat elementum justo. Aenean ut ante turpis. Pellentesque laoreet mé vel lectus scelerisque interdum cursus velit auctor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ac mauris lectus, non scelerisque augue. Aenean justo massa.</p>
                                                    </div>
                                                </div>
                                            </li> -->
                                            
                                        </ul>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="panel panel-default">
                                            <!-- Table -->
                                            <table class="table table-responsive table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Shipment From</th>
                                                        <th>Shipment To</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="source_firstname"> </td>
                                                        <td class="destination_firstname" > </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="source_lastname"></td>
                                                        <td class="destination_lastname"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="source_telephone"></td>
                                                        <td class="destination_telephone"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="source_email"></td>
                                                        <td class="destination_email"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="source_country"></td>
                                                        <td class="destination_country"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="source_province"></td>
                                                        <td class="destination_province"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="source_city"></td>
                                                        <td class="destination_city"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="source_address_1"></td>
                                                        <td class="destination_address_1"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="source_address_2"></td>
                                                        <td class="destination_address_2"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="source_company_status"></td>
                                                        <td class="destination_company_status"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="source_company_name"></td>
                                                        <td class="destination_company_name"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="source_pickup_type"></td>
                                                        <td class="destination_pickup_type"></td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td class="source_pickup_instruction"></td>
                                                        <td class="destination_pickup_instruction"></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="source_pickup_location"></td>
                                                        <td class="destination_pickup_location"></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="panel panel-default">

                                            <table class="table table-responsive table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Shipment Details</th>
                                                        <th>Shipment Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="">Sip Label:</td>
                                                        <td class="ship_label"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Ship Purpose:</td>
                                                        <td class="ship_purpose"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Ship Item Type:</td>
                                                        <td class="ship_item_type"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Ship Status:</td>
                                                        <td class="ship_status"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Ship Cost:</td>
                                                        <td class="ship_cost"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Ship Description:</td>
                                                        <td class="ship_description"></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="">Ship Date:</td>
                                                        <td class="creation_datetime"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <h3 class="panel-heading text-center">Ship Items</h3>


                                    <div class="col-md-12">
                                        <div class="panel panel-default" id="ship-item-data-table">

                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
            </div>
        </div>
    </div>
</div>
<!-- /bt_content -->

<style>
    .timeline {
        list-style: none;
        padding: 20px 0 20px;
        position: relative;
    }

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #ffffff;
        left: 50%;
        margin-left: -1.5px;
    }

    .timeline>li {
        margin-bottom: 20px;
        position: relative;
    }

    .timeline>li:before,
    .timeline>li:after {
        content: " ";
        display: table;
    }

    .timeline>li:after {
        clear: both;
    }

    .timeline>li:before,
    .timeline>li:after {
        content: " ";
        display: table;
    }

    .timeline>li:after {
        clear: both;
    }

    .timeline>li>.timeline-panel {
        width: 46%;
        float: left;
        border: 1px solid #d4d4d4;
        border-radius: 2px;
        padding: 20px;
        position: relative;
        background-color: #fff;
        -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
    }

    .timeline>li>.timeline-panel:before {
        position: absolute;
        top: 26px;
        right: -15px;
        display: inline-block;
        border-top: 15px solid transparent;
        border-left: 15px solid #ccc;
        border-right: 0 solid #ccc;
        border-bottom: 15px solid transparent;
        content: " ";
    }

    .timeline>li>.timeline-panel:after {
        position: absolute;
        top: 27px;
        right: -14px;
        display: inline-block;
        border-top: 14px solid transparent;
        border-left: 14px solid #fff;
        border-right: 0 solid #fff;
        border-bottom: 14px solid transparent;
        content: " ";
    }

    .timeline>li>.timeline-badge {
        color: #fff;
        width: 50px;
        height: 50px;
        line-height: 50px;
        font-size: 1.4em;
        text-align: center;
        position: absolute;
        top: 16px;
        left: 50%;
        margin-left: -25px;
        background-color: #999999;
        z-index: 100;
        border-top-right-radius: 50%;
        border-top-left-radius: 50%;
        border-bottom-right-radius: 50%;
        border-bottom-left-radius: 50%;
    }

    .timeline>li.timeline-inverted>.timeline-panel {
        float: right;
    }

    .timeline>li.timeline-inverted>.timeline-panel:before {
        border-left-width: 0;
        border-right-width: 15px;
        left: -15px;
        right: auto;
    }

    .timeline>li.timeline-inverted>.timeline-panel:after {
        border-left-width: 0;
        border-right-width: 14px;
        left: -14px;
        right: auto;
    }

    .timeline-badge.primary {
        background-color: #2e6da4 !important;
    }

    .timeline-badge.success {
        background-color: #3f903f !important;
    }

    .timeline-badge.warning {
        background-color: #f0ad4e !important;
    }

    .timeline-badge.danger {
        background-color: #d9534f !important;
    }

    .timeline-badge.info {
        background-color: #5bc0de !important;
    }

    .timeline-title {
        margin-top: 0;
        color: inherit;
    }

    .timeline-body>p,
    .timeline-body>ul {
        margin-bottom: 0;
    }

    .timeline-body>p+p {
        margin-top: 5px;
    }

    @media (max-width: 767px) {
        ul.timeline:before {
            left: 40px;
        }

        ul.timeline>li>.timeline-panel {
            width: calc(100% - 90px);
            width: -moz-calc(100% - 90px);
            width: -webkit-calc(100% - 90px);
        }

        ul.timeline>li>.timeline-badge {
            left: 15px;
            margin-left: 0;
            top: 16px;
        }

        ul.timeline>li>.timeline-panel {
            float: right;
        }

        ul.timeline>li>.timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }

        ul.timeline>li>.timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
    }
</style>