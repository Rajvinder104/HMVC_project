<!-- report_view.php -->
<?php include 'header.php' ?>
<div class="main-content main_content_new">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1>Report</h1>
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
                                                <td><?php echo $row['id']; ?></td>
                                                <td><?php echo $row['user_id']; ?></td>
                                                <td><?php echo $row['downline_id']; ?></td>
                                                <td><?php echo $row['level']; ?></td>
                                                <td><?php echo $row['created_at']; ?></td>
                                                <td> <?php echo ($row['status'] == 0 ? '<a class="btn btn-danger" href="'. base_url('Admin/Report/enableAnddisable/' . $row['id']) .'">Disable</a>' : '<a class="btn btn-success" href="'. base_url('Admin/Report/enableAnddisable/' . $row['id']) .'">Enable</a>'); ?> </td>

                                                <?php if ($row['status'] == 0) { ?>
                                                    <td><a class="btn btn-danger" href="<?php echo base_url('Admin/Report/enableAnddisable/' . $row['id']); ?>">Disable</a></td>
                                                <?php } else { ?>
                                                    <td><a class="btn btn-success" href="<?php echo base_url('Admin/Report/enableAnddisable/' . $row['id']); ?>">Enable</a></td>
                                                <?php } ?>
                                                <!-- Display other columns -->
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>