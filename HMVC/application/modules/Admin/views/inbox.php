<?php include_once 'header.php'; ?>
<div class="main-content app-content mt-0">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-12">
                <div class="header">
                    <h4>Inbox Mail</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User ID</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $key => $value) {
                                extract($value) ?>
                                <tr>
                                    <td><?php echo ++$key ?></td>
                                    <td><?php echo $user_id ?></td>
                                    <td><?php echo $title ?></td>
                                    <td><?php echo $message ?></td>
                                    <?php if ($status == 1) { ?>
                                        <td><span class="badge bg-success badge-sm">Approved</span></td>
                                    <?php  } elseif ($status == 0) { ?>
                                        <td><span class="badge bg-warning badge-sm">pending</span></td>
                                    <?php  } ?>
                                    <?php
                                    if ($status == 0) { ?>
                                        <td><a href="<?php echo base_url('admin/viewbtn/') . $id ?>" target="_blank" class="btn btn-primary">view</a></td>
                                    <?php    }
                                    ?>
                                </tr>
                            <?php   }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>