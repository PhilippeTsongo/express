<!-- Main content-->
<section class="content">
    <div class="container-fluid">


        <div class="row">
            <div class="col-lg-12">
                <div class="view-header">
                    <div class="pull-right text-right" style="line-height: 14px">
                        <small style="font-size: 16px;"><br><br> <span class="c-white"> <a
                                    href="<?= DNADMIN ?>/ship/list" class="text-warning"
                                    style="color: white !important;"> <span class="pe-7s-albums"></span>Ships List</a>
                            </span></small>
                    </div>
                    <div class="header-icon">
                        <i class="pe page-header-icon pe-7s-box2"></i>
                    </div>
                    <div class="header-title">
                        <h3>Create Shipment</h3>
                        <small>
                            This is the page where you have to add new shipment
                        </small>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="row">

            <div class="col-md-10">
                <div class="panel panel-filled">
                    <div class="panel-body">
                        <form class="form-group registration-form" id="SubmitRegisterForm" method="post"
                            style="margin-bottom: 0px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="panel-heading">
                                        From
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName" class="col-form-label">First name</label>
                                        <input type="text" class="form-control" id="admin-firstname" required
                                            name="admin-firstname" placeholder="First name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName" class="col-form-label">Last name</label>
                                        <input type="text" class="form-control" id="admin-lastname" required
                                            name="admin-lastname" placeholder="Last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName" class="col-form-label">Country</label>
                                        <select class="select2_demo_2 form-control" required style="width: 100%">
                                            <option disabled selected>Select country</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="admin-email" required
                                            name="admin-email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address</label>
                                        <input type="text" class="form-control" id="admin-email" required
                                            name="admin-email" placeholder="First physical address">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address2</label>
                                        <input type="text" class="form-control" id="admin-email" name="admin-email"
                                            placeholder="Second physical address">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address 3</label>
                                        <input type="text" class="form-control" id="admin-email" name="admin-email"
                                            placeholder="Third physical address">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="col-form-label">Province</label>
                                            <select class="select2_demo_2 form-control" style="width: 100%">
                                                <option disabled selected>Select Province</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="col-form-label">City</label>
                                            <select class="select2_demo_2 form-control" style="width: 100%">
                                                <option disabled selected>Select City</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Telephone</label>
                                        <input type="number" class="form-control" id="admin-telephone" required
                                            name="admin-telephone" placeholder="Telephone">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="admin-telephone" required
                                            name="admin-telephone" placeholder="Email Address">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="panel-heading">
                                        To
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName" class="col-form-label">First name</label>
                                        <input type="text" class="form-control" id="admin-firstname" required
                                            name="admin-firstname" placeholder="First name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName" class="col-form-label">Last name</label>
                                        <input type="text" class="form-control" id="admin-lastname" required
                                            name="admin-lastname" placeholder="Last name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName" class="col-form-label">Country</label>
                                        <select class="select2_demo_2 form-control" required style="width: 100%">
                                            <option disabled selected>Select country</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="admin-email" required
                                            name="admin-email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address</label>
                                        <input type="text" class="form-control" id="admin-email" required
                                            name="admin-email" placeholder="First physical address">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address2</label>
                                        <input type="text" class="form-control" id="admin-email" name="admin-email"
                                            placeholder="Second physical address">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address 3</label>
                                        <input type="text" class="form-control" id="admin-email" name="admin-email"
                                            placeholder="Third physical address">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="col-form-label">Province</label>
                                            <select class="select2_demo_2 form-control" style="width: 100%">
                                                <option disabled selected>Select Province</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputEmail3" class="col-form-label">City</label>
                                            <select class="select2_demo_2 form-control" style="width: 100%">
                                                <option disabled selected>Select City</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Address 3</label>
                                        <input type="text" class="form-control" id="admin-email" name="admin-email"
                                            placeholder="Third physical address">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Company Name</label>
                                        <input type="text" class="form-control" id="admin-telephone" required
                                            name="admin-telephone" placeholder="Destination Company Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" id="admin-telephone" required
                                            name="admin-telephone" placeholder="Email Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-form-label">Telephone</label>
                                        <input type="number" class="form-control" id="admin-telephone" required
                                            name="admin-telephone" placeholder="Telephone">
                                    </div>

                                </div>

                            </div>




                            <!-- <hr> -->
                            <div class="modal-footer">
                                <input type="hidden" name="request" id="request"
                                    value="<?= $HASH->encryptAES('iccn-admin-new') ?>">
                                <input type="hidden" name="webToken" id="webToken"
                                    value="<?= $HASH->encryptAES(256) ?>">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" id="SubmitRegisterButton" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>


    </div>
</section>
<!-- End main content-->