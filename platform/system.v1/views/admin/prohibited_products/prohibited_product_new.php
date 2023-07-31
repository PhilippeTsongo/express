    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small style="font-size: 16px;"><br><br> <span class="c-white"> <a href="<?= DNADMIN ?>" class="text-warning" style="color: white !important;"> <span class="pe-7s-home"></span> Dashboard</a> </span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-shield"></i>
                        </div>
                        <div class="header-title">
                            <h3>Prohibited Products</h3>
                            <small>
                                This is the page where you need to specify all prohibited products
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            
                <div class="col-md-7">
                    <div class="panel panel-filled">
                        <div class="panel-heading">
                            <!-- <div class="panel-tools">
                                <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                                <a class="panel-close"><i class="fa fa-times"></i></a>
                            </div> -->
                            Add new prohibited product
                        </div>
                        <div class="panel-body">
                            <form class="form-group registration-form" id="SUBMITCREATIONFORM" method="post" style="margin-bottom: 0px;" >
                                <div class="form-group">
                                    <label for="exampleInputName" class="col-form-label">Product Name</label>
                                    <input type="text" class="form-control" id="admin-firstname" required name="product-prohibited-name" placeholder="Product name">
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-form-label">Product Short Description</label>
                                    <textarea class="form-control" id="article-description_short" required name="product-prohibited-short_description" placeholder="Product Short Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-form-label">Description</label>
                                    <textarea class="form-control" id="article-description" name="product-prohibited-description" placeholder="Product Description"></textarea>
                                </div>
                                <!-- <hr> -->
                                <div class="modal-footer">
                                    <input type="hidden" name="request" id="request" value="L7tFiyQzEOUgB+m2lotqUHNSJmYHicC9UUZyqrZx5pMJOfopDRl4KN6PogBbVlNR">
                                    <input type="hidden" name="webToken" id="webToken" value="<?= $HASH->encryptAES(256) ?>">
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


