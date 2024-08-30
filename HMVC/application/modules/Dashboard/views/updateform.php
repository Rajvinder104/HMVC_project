<?php include_once 'header.php'; ?>
<style>
    .Approved{
        color: #fff;
        text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;
        text-align: center;
        margin: 10px 0;
    }
</style>
<div class="main-content app-content mt-0">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <?php echo $this->session->flashdata('message'); ?>
                        <?php echo form_open_multipart(base_url('dashboard/uploaddocument/' . $user['id'])); ?>

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
                        <?php
                        if ($user['kyc_status'] == 2) {
                            echo "<h3 class='Approved'>You are Already Aproved By Admin</h3>";
                        } else { ?>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <input type="submit" value="Submit" class="form-control btn btn-danger ">
                                </div>
                            </div>
                        <?php }
                        ?>


                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>