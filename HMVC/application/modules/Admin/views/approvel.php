<?php include_once 'header.php'; ?>
<style>
    .card {
        box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgba(0, 0, 0, 0.3) 0px 18px 36px -18px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row d-flex justify-content-center">
                <div class="col-12">
                    <div class="panel-heading mb-3">
                        <h4 class="panel-title">Approvel Mail</h4>
                    </div>
                    <h4><?php echo $this->session->flashdata('message') ?></h4>
                    <?php echo form_open(base_url('admin/viewbtn/'. $user['id'])); ?>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Title</label>
                                        <input type="text" name="title" placeholder="Enter Topic Title" class="form-control" value="<?php echo $user['title'] ;?>">
                                        <?php echo form_error('title'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Description</label>
                                        <textarea name="message" id="" placeholder="Enter Description" class="form-control" value="<?php echo $user['message'];?>"></textarea>
                                        <?php echo form_error('message'); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-12">
                            <label for="">status</label>
                                <select name="status" id="" class="form-control">
                                    <option value="0">pending</option>
                                    <option value="1">Resolved</option>
                                    <option value="2">Unresolved</option>
                                </select>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Remark</label>
                                        <textarea name="remark" id="" placeholder="Enter Remark" class="form-control"></textarea>
                                        <?php echo form_error('remark'); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="submit" value="update" class="btn btn-warning">
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>