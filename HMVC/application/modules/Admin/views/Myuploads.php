<?php include 'header.php'; ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                         <h4><?php echo $this->session->flashdata('message'); ?></h4>
                            <?php echo form_open_multipart('admin/uploadimg', ['method' => 'POST']); ?>
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Your Name">
                                <span class="text-danger"><?php echo form_error('name'); ?></span>

                            </div>
                            <div class="form-group">
                                <label for="">Document</label>
                                <input type="file" class="form-control" name="document">
                                <span class="text-danger"><?php echo form_error('document'); ?></span>
                                <span class="text-danger"><?php if (!empty($err)) {
                                                                echo $err;
                                                            }; ?></span>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="upload">
                            </div>

                            <?php echo form_close(); ?>

                            <div class="all-data">
                                <a href="<?php echo base_url('admin/imgdata')?>" class="btn btn-info" target="_blank">View</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>