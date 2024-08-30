<?php require_once('header.php'); ?>
<div class="main-content main_content_new">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">


                    <h2>Grouped Dates Separately</h2>

                    <!-- Display grouped dates separately -->
                    <?php foreach ($grouped_dates as $week => $dates) : ?>
                        <h3>Week <?php echo $week; ?></h3>
                        <ul>
                            <?php foreach ($dates as $date) : ?>
                                <li><?php echo $date['created_at']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endforeach; ?>

                    <!-- Add a link to go back to the grouped dates view -->
                    <a href="<?php echo base_url('datescontroller'); ?>">Back to Grouped Dates</a>

                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
