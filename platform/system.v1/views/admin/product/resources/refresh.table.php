<?php
$_filter_condition_ = "";
$_LIST_DATA_ = \ProductController::getProducts($_filter_condition_ );

?>
                     <table id="tableExample3" class="table table-striped table-hover table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Product Name</th>
                                        <th>Price</th>
                                        <th>Installation Fees</th>
                                        <th>Down Payments</th>
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
                                        <td><?=$list_->name?></td>
                                        <td><?=$list_->price.' '.$list_->currency?></td>
                                        <td><?=$list_->installation_fees?></td>
                                        <td><?=$list_->number_down_payment?></td>
                                        <td><?=$list_->status?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-xs btn-default dropdown-toggle">More </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item activateModal" data-id="<?=$HASH->encryptAES($list_->id)?>" data-name="<?=$list_->name?>"  data-toggle="modal"  > <i class="fa fa-check"></i> Activate</a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item deactivateModal" data-id="<?=$HASH->encryptAES($list_->id)?>" data-name="<?=$list_->name?>"  data-toggle="modal"  href="#"> <i class="fa fa-remove"></i> Deactivate</a></li>
                                                    <li class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item" href="<?=DNADMIN?>/product/edit/<?=Hash::encryptToken($list_->id)?>"> <i class="fa fa-pencil"></i> Edit </a></li>
                                                    
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
        $('#tableExample3').DataTable({
            dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>tp",
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                // {extend: 'copy', className: 'btn-sm'},
                {extend: 'csv', title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'pdf', title: 'ExampleFile', className: 'btn-sm'},
                {extend: 'print', className: 'btn-sm'}
            ],
            retrieve: true,
            // paging: false
        });

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
