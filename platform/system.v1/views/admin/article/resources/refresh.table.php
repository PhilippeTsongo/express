<?php

// $_FILTER_ACCOUNT_TYPE_ = (Input::checkInput('filter_account_type', 'post', 1))?Input::get('filter_account_type', 'post'):'';
// $_FILTER_ACCOUNT_GROUP_ = (Input::checkInput('filter_account_group', 'post', 1))?Input::get('filter_account_group', 'post'):'';
// $_FILTER_ACCOUNT_EVENT_ = (Input::checkInput('filter_account_event', 'post', 1))?Input::get('filter_account_event', 'post'):'';
// $_FILTER_ACCOUNT_STATUS_ = (Input::checkInput('filter_status', 'post', 1))?Input::get('filter_status', 'post'):'';
// $_FILTER_ACCOUNT_SESSION_ = (Input::checkInput('filter_account_session', 'post', 1))?Input::get('filter_account_session', 'post'):'';
// $_FILTER_DATE_FROM_ = (Input::checkInput('filter_date_from', 'post', 1))?Input::get('filter_date_from', 'post'):'';
// $_FILTER_DATE_TO_ = (Input::checkInput('filter_date_to', 'post', 1))?Input::get('filter_date_to', 'post'):'';

$_filter_condition_ = "";
// if($_FILTER_ACCOUNT_TYPE_ != ''):
//     $_FILTER_ACCOUNT_TYPE_ = Hash::decryptToken($_FILTER_ACCOUNT_TYPE_);
//     $_filter_condition_ .= " AND app_users.account_type_id = {$_FILTER_ACCOUNT_TYPE_} ";
// endif;

// if($_FILTER_ACCOUNT_GROUP_ != ''):
//     $_FILTER_ACCOUNT_GROUP_ = Hash::decryptToken($_FILTER_ACCOUNT_GROUP_);
//     $_filter_condition_ .= " AND app_users.account_group_id = {$_FILTER_ACCOUNT_GROUP_} ";
// endif;

// if($_FILTER_ACCOUNT_STATUS_ != ''):
//     $_filter_condition_ .= " AND app_users.status = '{$_FILTER_ACCOUNT_STATUS_}' ";
// endif;

// if($_FILTER_ACCOUNT_SESSION_ != ''):
//     $_FILTER_ACCOUNT_SESSION_ = Hash::decryptToken($_FILTER_ACCOUNT_SESSION_);
//     $_filter_condition_ .= " AND app_users.account_session = {$_FILTER_ACCOUNT_SESSION_} ";
// endif;

// $_DATETIME_1_ = $_FILTER_DATE_FROM_ == ''?0:strtotime($_FILTER_DATE_FROM_);
// $_DATETIME_2_ = $_FILTER_DATE_TO_ == ''?0:strtotime($_FILTER_DATE_TO_.' 11:59 pm');

// if($_FILTER_DATE_FROM_ != '' OR $_FILTER_DATE_TO_ != ''):
//     if($_FILTER_DATE_FROM_ != '' AND $_FILTER_DATE_TO_ != ''):
//         $_filter_condition_    .= " AND app_users.creation_datetime BETWEEN $_DATETIME_1_ AND  $_DATETIME_2_ ";

//     elseif($_FILTER_DATE_FROM_ != '' AND $_FILTER_DATE_TO_ == ''):
//         $_filter_condition_    .= " AND app_users.creation_datetime >=  $_DATETIME_1_ ";
    
//     elseif($_FILTER_DATE_FROM_ == '' AND $_FILTER_DATE_TO_ != ''):
//         $_filter_condition_    .= " AND app_users.creation_datetime <=  $_DATETIME_2_ ";
//     endif;
// endif;

$_LIST_DATA_ = \AccountController::getAccounts($_filter_condition_ );

?>
                            <table id="tableExample3" class="table table-bordered table-striped table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Names</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
<?php
if($_LIST_DATA_): $count_ = 0;
    foreach($_LIST_DATA_ As $list_): $count_++;
?>
                                    <tr>
                                        <td><?=$count_?></td>
                                        <td><?=$list_->firstname.' '.$list_->lastname?></td>
                                        <td><?=$list_->email?></td>
                                        <td><?=$list_->telephone?></td>
                                        <td><?=$list_->status?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item activateModal" data-id="<?=$HASH->encryptAES($list_->id)?>" data-name="<?=$list_->firstname.' '.$list_->lastname?>"  data-toggle="modal"  > <i class="fa fa-check"></i> Activate</a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item deactivateModal" data-id="<?=$HASH->encryptAES($list_->id)?>" data-name="<?=$list_->firstname.' '.$list_->lastname?>"  data-toggle="modal"  href="#"> <i class="fa fa-remove"></i> Deactivate</a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item" href="<?=DNADMIN?>/admin/edit/<?=Hash::encryptToken($list_->id)?>"> <i class="fa fa-pencil"></i> Edit </a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item resetPasswordModal" data-id="<?=$HASH->encryptAES($list_->id)?>" data-name="<?=$list_->firstname.' '.$list_->lastname?>"  data-toggle="modal" > <i class="fa fa-unlock"></i> Reset Password </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
<?php
    endforeach;
endif;
?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="<?=DNADMIN?>/build/vendor/datatables/datatables.min.js"></script>
<script src="<?=DNADMIN?>/build/vendor/datatables/dataTables.bootstrap4.min.js"></script>


<script>
    // $(document).ready(function () {

        $('#tableExample3').DataTable({

            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
            // retrieve: true,
            // paging: false
        });

        

    // });


    $('.activateModal').on('click', function(){
        var paramID   = $(this).attr('data-id');
        var paramName = $(this).attr('data-name');
        smartModalPopUp('activateModal', paramID, paramName);
    });

    $('.deactivateModal').on('click', function(){
        var paramID   = $(this).attr('data-id');
        var paramName = $(this).attr('data-name');
        smartModalPopUp('deactivateModal', paramID, paramName);
    });

    $('.resetPasswordModal').on('click', function(){
        var paramID   = $(this).attr('data-id');
        var paramName = $(this).attr('data-name');
        smartModalPopUp('resetPasswordModal', paramID, paramName);
    });


</script>
