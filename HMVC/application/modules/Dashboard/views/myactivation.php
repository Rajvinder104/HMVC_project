<?php include_once 'header.php'; ?>
<style>
    .table-head-box {
        background: #29327f;
        text-align: center;
        padding: 7px 0 6px;
        color: #fff;
    }

    .table-head-box h4 {
        margin: 0px;
    }
</style>
<div class="main-content app-content mt-0">
    <div class="container-fluid">
        <div class="">
            <div class="panel-heading">
                <h4 class="panel-title"><?php echo 'MY Activate Account'; ?></h4>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card cstm-card">
                        <div class="card-body">
                            <p>Wallet Balacne: <?php echo $wallet['wallet_balance']; ?></p>
                            <div class="wizard-content tab-content p-0">
                                <div class="tab-pane active show" id="tabFundRequestForm">
                                    <div>
                                        <?php if ($this->session->flashdata('message')) {
                                            echo '<p>' . $this->session->flashdata('message') . '</p>';
                                        } ?>
                                        <div class="col-md-12 p-0">
                                            <?php echo form_open(base_url('dashboard/myactivate'), array('method' => 'POST')); ?>
                                            <div class="form-group">
                                                <label>User ID</label>
                                                <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $this->session->userdata['user_id']; ?>" placeholder="User ID" />
                                                <span class="text-danger"><?php echo form_error('user_id') ?></span>
                                                <span class="text-danger" id="userName"></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Enter Amount in <?php echo currency; ?></label>
                                                <input type="text" class="form-control" name="amount" value="<?php echo set_value('amount'); ?>" placeholder="Enter Amount" id="amount">
                                                <span class="text-danger"><?php echo form_error('amount') ?></span>
                                            </div>
                                            <div class="form-group" id="SaveBtn">
                                                <button type="submit" name="save" class="btn btn-info"><?php echo 'Activate'; ?></button>
                                            </div>
                                            <?php echo form_close(); ?>
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

<?php include_once 'footer.php'; ?>



<!----------------------->
