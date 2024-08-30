<?php require_once('header.php'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="form-popup-bg">
                <div class="form-container">
                    <button id="btnCloseForm" class="close-button">X</button>
                    <h1>Withdraw Request</h1>
                    <p></p>
                    <?php echo form_open(base_url('Admin/Withdraw/request2')); ?>

                    <div class="form-group">
                        <label for="user_id">User ID</label>
                        <input class="form-control" name="user_id" id="user_id" type="text" />

                    </div>
                    <div class="form-group">
                        <label for="">Remark</label>
                        <textarea class="form-control" name="remark" id="" cols="3" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Status</label>
                        <select class="form-control" name="status" id="">
                            <option value="1">Approved</option>
                            <option value="2">Rejected</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn_success">Submit</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
