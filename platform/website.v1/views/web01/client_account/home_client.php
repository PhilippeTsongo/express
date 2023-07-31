<!-- /.mainHeader -->
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

                                                                    <div class="btClear btSeparator topSmallSpaced noBorder">
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
                

                <section id="bt_section6440e53c49016" class="boldSection topSpaced bottomSpaced gutter inherit">
                    <div class="port">
                        <div class="boldCell">
                            <div class="boldCellInner">
                                <div class="boldRow ">
                                    <div class="rowItem col-md-12 col-ms-12  btTextLeft">
                                        <div class="rowItemContent">
                                            <div class="rowItem col-md-3 col-sm-6 col-ms-12 btTextLeft btTextIndent btHighlight inherit">
                                                <div class="rowItemContent">
                                                    <div class="bpgPhoto">
                                                        <img src="<?= $__IMAGESPATH__ ?>/wp-content/uploads/sites/2/2015/10/avatar-1.png" alt="Three-trucks-on-blue-background-320x200.jpg" width="130" height="130" style="margin-left: 80px;">
                                                    </div>

                                                    <div class="btClear btSeparator topSmallSpaced noBorder">
                                                        <hr>
                                                    </div>
                                                    <div class="btTextCenter">
                                                        <?php
                                                        if ($session_user->isLoggedIn()) :
                                                        ?>
                                                            <h8> <?= substr($_CNS_USER_->firstname . ' ' . $_CNS_USER_->lastname, 0, 30) ?> </h8>
                                                            <span> <?= substr($_CNS_USER_->email, 0, 30) ?> </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <hr>
                                                    <header class="header btClear small  btAccentDash btRegularTitle">
                                                        <div class="dash">
                                                            <h4>
                                                                <span class="headline">MENU</span>
                                                            </h4>
                                                        </div>
                                                    </header>
                                                    <div class="btCustomMenu ">
                                                        <div class="menu-calculator-menu-container">
                                                            <ul id="menu-calculator-menu" class="menu">
                                                                <li id="menu-item-1182" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-1078 current_page_item menu-item-1182">
                                                                    <a href="<?= DNADMIN ?>/my_account" aria-current="page">My shipments</a>
                                                                </li>

                                                                <li id="menu-item-1182" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-1078 current_page_item menu-item-1182">
                                                                    <a href="<?=DNADMIN?>/logout" id="oauthlogout">Log out</a>
                                                                </li>


                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="btClear btSeparator topSemiSpaced noBorder">
                                                        <hr>
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            <div class="rowItem col-md-9 col-sm-6 col-ms-12 btTextRight btTextIndent btHighlight inherit" id="ship-data-table">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- /bt_content -->
    </div>
    <!-- /contentHolder -->
</div>
<!-- /contentWrap -->
<section class="boldSection gutter btSiteFooterCurve ">
    <div class="port">
        <div class="btCurveLeftHolder">
            <svg version="1.1" id="Layer_3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="14px" viewBox="0 0 50 14" enable-background="new 0 0 50 14" xml:space="preserve">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M 0 14 C 27 15 20 0 51 0 c 0 13 0 15 0 15 L 0 15 Z" class="btCurveLeft" />
            </svg>
        </div>
        <div class="btCurveRightHolder">
            <svg version="1.1" id="Layer_4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="14px" viewBox="0 0 50 14" enable-background="new 0 0 50 14" xml:space="preserve">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M 50 14 c -27 0 -20 -14 -50 -14 c 0 13 0 14 0 145 L 50 14 Z" class="btCurveRight" />
            </svg>
        </div>
        <div class="btSiteFooterCurveSleeve"></div>
    </div>
</section>