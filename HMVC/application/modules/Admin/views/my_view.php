<?php require_once('header.php'); ?>
<div class="main-content main_content_new">
    <div class="page-content">
        <div class="container-fluid">
        <h2>Grouped Dates</h2>

<!-- Display each week's dates -->
<?php foreach ($grouped_dates as $week => $dates): ?>
    <h3>Week <?php echo $week; ?></h3>
    <ul>
        <?php foreach ($dates as $date): ?>
            <li><?php echo $date['created_at']; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>

<!-- Add a button to view grouped dates separately -->
<a href="<?php echo base_url('datescontroller/viewgroupeddates'); ?>">View Grouped Dates Separately</a>


        </div>
    </div>
</div>
<?php require_once('footer.php'); ?>
