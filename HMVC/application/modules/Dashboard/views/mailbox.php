<?php include 'header.php'; ?>
<div class="main-content app-content">
    <div class="">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="panel-heading mb-3">
                            <h4 class="panel-title">Inbox Mail</h4>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User ID</th>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $key => $value) {
                                        extract($value) ?>
                                        <tr>
                                            <td><?php echo ++$key; ?></td>
                                            <td><?php echo $user_id; ?></td>
                                            <td><?php echo $title; ?></td>
                                            <td><?php echo $message; ?></td>
                                            <td><?php echo $remark; ?></td>
                                            <td><?php echo $created_at; ?></td>
                                        </tr>
                                    <?php     } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>