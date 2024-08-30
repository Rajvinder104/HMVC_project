<?php
include 'header.php';
(empty($export)) ? $export = false : $export = $export;

if (empty($export)) {
    $export = false;
} else {
    $export = $export;
}
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php if ($export == true) : ?>
                        <div class="col-12">
                            <div class="main__center card-header-column-main">
                                <h4 class="mb-0"> </h4>
                                <div class="export-table">
                                    <a href="<?php echo $path . '?export=xls'; ?>" class="export-btn btn-primary "><img src="<?php echo base_url('NewDashboard/'); ?>assets/images/xls.png">Export to xls</a>
                                    <a href="<?php echo $path . '?export=csv'; ?>" class="export-btn btn-success "><img src="<?php echo base_url('NewDashboard/'); ?>assets/images/csv.png">Export to csv</a>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="header">
                        <h2>Available Income</h2>
                    </div>
                    <div class="table table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User ID</th>
                                    <th>Amount</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = $segment + 1;
                                foreach ($users as $key => $value) {
                                    extract($value);
                                ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $user_id; ?></td>
                                        <td><?php echo $balance; ?></td>
                                    </tr>
                                <?php ++$i;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php' ?>