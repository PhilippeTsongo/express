<!-- Navigation-->
<aside class="navigation">
    <nav>
        <ul class="nav luna-nav">
            <li class="nav-category font-weight-bolder">
                MENU
            </li>
            <li class="<?= Functions::active_li_menu('request', '', 'dashboard') ? 'active' : '' ?>">
                <a href="<?= DNADMIN ?>/dashboard">Dashboard</a>
            </li>
            <li class="nav-category font-weight-bolder">
                ACCOUNTS
            </li>
            <li class="<?= Functions::active_li_menu('request', 'list_admin', 'new_admin') ? 'active' : '' ?>">
                <a href="#m001" data-toggle="collapse" aria-expanded="<?= Functions::active_li_menu('request', 'list_admin', 'new_admin') ? 'true' : 'false' ?>" class>
                    Accounts<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="m001"
                    class="nav nav-second collapse <?= Functions::active_li_menu('request', 'list_admin', 'new_admin') ? 'show' : '' ?>">
                    <li class="<?= Functions::active_li_menu('request', 'new_admin') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/admin/new">New User</a>
                    </li>
                    <li class="<?= Functions::active_li_menu('request', 'list_admin') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/admin/list">Users</a>
                    </li>
                </ul>
            </li>

        
            <li class="<?= Functions::active_li_menu('request', 'agent_list') ? 'active' : '' ?>">
                <a href="<?= DNADMIN ?>/delivery/agent/list">Agents</a>
            </li>
               
            <li class="<?= Functions::active_li_menu('request', 'new_partner','partners') ? 'active' : '' ?>">
                <a href="#m006" data-toggle="collapse" aria-expanded="<?= Functions::active_li_menu('request', 'new_partner','partners') ? 'true' : 'false' ?>" class>
                    Partners<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="m006" class="nav nav-second collapse <?= Functions::active_li_menu('request', 'new_partner','partners') ? 'show' : '' ?>">
                    <li class="<?= Functions::active_li_menu('request', 'new_partner') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/delivery/agent/new">New Agent</a>
                    </li>
                    <li class="<?= Functions::active_li_menu('request', 'partners') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/delivery/agent/list">List Agents</a>
                    </li>
                </ul>
            </li>

            <li class="<?= Functions::active_li_menu('request', 'new_partner','partners') ? 'active' : '' ?>">
                <a href="#m006" data-toggle="collapse" aria-expanded="<?= Functions::active_li_menu('request', 'new_partner','partners') ? 'true' : 'false' ?>" class>
                    Partners<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="m006" class="nav nav-second collapse <?= Functions::active_li_menu('request', 'new_partner','partners') ? 'show' : '' ?>">
                    <!-- <li class="<?= Functions::active_li_menu('request', 'new_partner') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/partners/new">New Partner</a>
                    </li> -->
                    <li class="<?= Functions::active_li_menu('request', 'partners') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/partners/list">Partners</a>
                    </li>
                </ul>
            </li>

            <li class="<?= Functions::active_li_menu('request', 'customers') ? 'active' : '' ?>">
                <a href="<?= DNADMIN ?>/customers">Customers</a>
            </li>

            <li class="nav-category font-weight-bolder">
                 SHIPMENT
            </li>
            <li class="<?= Functions::active_li_menu('request', 'ship_list','ship_purpose','ship_cost','ship_cost_item','ship_item', 'package') ? 'active' : '' ?>">
                <a href="#m003" data-toggle="collapse" aria-expanded="<?= Functions::active_li_menu('request', 'ship_new','ship_purpose','ship_cost','ship_cost_item','ship_item', 'package') ? 'true' : 'false' ?>" class>
                     Ship<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="m003" class="nav nav-second collapse <?= Functions::active_li_menu('request', 'ship_list','ship_purpose','ship_cost','ship_cost_item','ship_item', 'package') ? 'show' : '' ?>">
                    <li class="<?= Functions::active_li_menu('request','ship_list') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/ship/list">Ship List</a>
                    </li>
               
                    <!-- <li class="<?= Functions::active_li_menu('request','ship_item') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/ship/item">Ship Items</a>
                    </li> -->
                    
                </ul>
            </li>


            <li class="<?= Functions::active_li_menu('request', 'ship_purpose_new','ship_purpose_list') ? 'active' : '' ?>">
                <!-- <a href="#m007" data-toggle="collapse" aria-expanded="<?= Functions::active_li_menu('request', 'ship_purpose_new','ship_purpose_list') ? 'true' : 'false' ?>" class>
                     Ship Purpose<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a> -->
                <li class="<?= Functions::active_li_menu('request','ship_purpose_list') ? 'active' : '' ?>">
                    <a href="<?= DNADMIN ?>/ship/purpose/list">Ship Purpose </a>
                </li>
                <!-- <ul id="m007" class="nav nav-second collapse <?= Functions::active_li_menu('request', 'ship_purpose_new','ship_purpose_list') ? 'show' : '' ?>">
                    <li class="<?= Functions::active_li_menu('request','ship_purpose_new') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/ship/purpose/new">New Ship Purpose</a>
                    </li>
                </ul> -->
            </li>

            <li class="nav-category font-weight-bolder">
                 CONFIGURATIONS
            </li>
            <li class="<?= Functions::active_li_menu('request', 'prohibited_prod_list', 'item_type_list', 'package_type_list','new_about', 'ship_unit_list', 'source_country', 'destination_country') ? 'active' : '' ?>">
                <a href="#m002" data-toggle="collapse" aria-expanded="<?= Functions::active_li_menu('request', 'prohibited_prod_list', 'item_type_list', 'package_type_list','new_about', 'ship_unit_list') ? 'true' : 'false' ?>" class>
                     Settings<span class="sub-nav-icon"> <i class="stroke-arrow"></i> </span>
                </a>
                <ul id="m002" class="nav nav-second collapse <?= Functions::active_li_menu('request', 'prohibited_prod_list', 'item_type_list', 'package_type_list','new_about', 'ship_unit_list', 'source_country', 'destination_country') ? 'show' : '' ?>">
                    <li class="<?= Functions::active_li_menu('request', 'new_about') ? 'active' : '' ?>">
                        <a href="<?=DNADMIN?>/about/view" >About Company</a>
                    </li>
                   
                    <li class="<?= Functions::active_li_menu('request', 'prohibited_prod_list') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/prohibited/product/list">Prohibited Product </a>
                    </li>
                    
                    <li class="<?= Functions::active_li_menu('request', 'item_type_list') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/item/type/list">Item Type</a>
                    </li>
                   
                    <li class="<?= Functions::active_li_menu('request', 'ship_unit_list') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/ship/unit/list">Ship Units</a>
                    </li>

                    <li class="<?= Functions::active_li_menu('request', 'source_country') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/source/country/list">Source Countries</a>
                    </li>

                    <li class="<?= Functions::active_li_menu('request', 'destination_country') ? 'active' : '' ?>">
                        <a href="<?= DNADMIN ?>/destination/country/list">Destination Countries</a>
                    </li>
                </ul>
                
            </li>
            <li class="<?= Functions::active_li_menu('request', 'logout') ? 'active' : '' ?>">
                <a href="<?= DNADMIN ?>/logout"> <span class="sub-nav-icon"> <i class="stroke-power"></i></span> Logout</a>
            </li>

        </ul>
    </nav>
</aside>
<!-- End navigation-->