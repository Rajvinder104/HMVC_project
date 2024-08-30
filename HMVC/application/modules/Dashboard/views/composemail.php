<?php include_once 'header.php'; ?>
<style>
    .card {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }
</style>
<div class="main-content app-content mt-0">
    <div class="container-fluid">
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <div class="panel-heading mb-3">
                    <h4 class="panel-title">Compose Mail</h4>
                </div>
                <h4><?php echo $this->session->flashdata('messages')?></h4>
                <?php echo form_open(base_url('dashboard/Sendmail')); ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="">Title</label>
                                <input type="text" name="title" placeholder="Enter Topic Title" class="form-control">
                                <?php echo form_error('title'); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="">Description</label>
                                <textarea name="message" id="" placeholder="Enter Description" class="form-control"></textarea>
                                <?php echo form_error('message'); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="submit" value="Send" class="btn btn-dark">
                            </div>
                        </div>

                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>