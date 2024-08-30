<?php include_once 'header.php'; ?>
<div class="main-content app-content mt-0">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="header" style="background-color: #cc9e45; padding:7px;border-radius:7px;color:#fff;margin:10px 0;">
                        <h4 class="text-center">KYC permission for Admin</h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h6><?php echo $this->session->flashdata('message'); ?></h6>

                            <?php echo form_open_multipart(base_url('admin/uploaddocument/' . $user['id'])); ?>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="">Bank Name</label>
                                    <input type="text" name="bank_name" placeholder="Enter Bank Name" class="form-control" value="<?php echo $user['bank_name'] ?>">
                                    <span class="text-danger"><?php echo form_error('bank_name') ?></span>

                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="">Account Number</label>
                                    <input type="text" name="bank_account_number" placeholder="Enter Account Number" class="form-control" value="<?php echo $user['bank_account_number'] ?>">
                                    <span class="text-danger"><?php echo form_error('bank_account_number') ?></span>

                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="">IFSC Code</label>
                                    <input type="text" name="ifsc_code" placeholder="Enter IFSC Code" class="form-control" value="<?php echo $user['ifsc_code'] ?>">
                                    <span class="text-danger"><?php echo form_error('ifsc_code') ?></span>

                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="">Branch Name</label>
                                    <input type="text" name="branch_name" placeholder="Enter Branch Name" class="form-control" value="<?php echo $user['branch_name'] ?>">
                                    <span class="text-danger"><?php echo form_error('branch_name') ?></span>

                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <label for="">Permissions</label>
                                    <select name="kyc_status" id="" class="form-control">
                                        <option value="2">Approved</option>
                                        <option value="3">Rejected</option>
                                    </select>

                                </div>
                            </div>
                            <?php if ($user['kyc_status'] == 2) {
                                echo 'KYC Approvel is Done!';
                            } else { ?>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <input type="submit" value="Update" class=" btn btn-info ">
                                    </div>
                                </div>
                            <?php  } ?>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>