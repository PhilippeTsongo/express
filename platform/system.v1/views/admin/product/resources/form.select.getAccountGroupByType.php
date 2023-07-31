<label for="">Account Group</label>
<select id="filter_account_group" name="filter_account_group"  class="form-control chosen-select" data-rule="required" data-msg="Please select subtype">
    <option value="">Select</option>
    <option value="">All</option>
   
<?php
$_ACCOUNT_TYPE_ID_ = Hash::decryptToken(Input::get('filter_account_type', 'post'));
$_LIST_ACCOUNT_GROUPS_ = SYSAccountController::getAccountGroups($_ACCOUNT_TYPE_ID_);
if($_LIST_ACCOUNT_GROUPS_):
    foreach($_LIST_ACCOUNT_GROUPS_ As $_list_):
?>
        <option value="<?=Hash::encryptToken($_list_->id)?>"><?=$_list_->description?></option>
<?php
    endforeach;
endif;
?>

</select>