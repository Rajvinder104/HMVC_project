<?php include 'header.php';?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row mt-5">
           <div class="col-12">

           <div class="card">
                    <div class="card-body">
                    <div class="table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User_id</th>
                                            <th>downline_id</th>
                                            <th>level</th>
                                            <th>date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($report_data as $row) { ?>
                                            <tr>
                                                <?php if ($row['status'] == 0) { ?>
                                                    <td><a class="btn btn-danger" href="<?php echo base_url('Admin/Settings/enableAnddisable/' . $row['id']); ?>">Disable</a></td>
                                                <?php } else { ?>
                                                    <td><a class="btn btn-success" href="<?php echo base_url('Admin/Settings/enableAnddisable/' . $row['id']); ?>">Enable</a></td>
                                                <?php } ?>
                                                <!-- Display other columns -->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                    <?php echo form_open_multipart('admin/Addimage',['method' => 'POST']); ?>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your name">
                        <span class="text-danger"><?php echo form_error('name'); ?></span>

                    </div>
                    <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="document" class="form-control">
                            <span class="text-danger"><?php echo form_error('document'); ?></span>
                            <span class="text-danger"><?php if(!empty($err)){ echo $err;} ;?></span>
                            <!-- <input type="file" name="Pimage" class="form-control" /> -->
                            <?php echo "The time is " . date("d-m-y h:i:sa");?>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Update" class="btn btn-info">
                        </div>
                    <?php echo form_close(); ?>

                    </div>
                </div>
           </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php';?>