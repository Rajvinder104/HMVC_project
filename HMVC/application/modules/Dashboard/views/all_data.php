<?php require_once 'header.php'; ?>
<div class="main-content app-content mt-0 ">
    <div class="container-fluid">
        <div class="row mx-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Id</th>
                        <th>downline_id</th>
                        <th>level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i= $segment + 1;
                    foreach ($users as $key => $rec) { ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $rec['user_id']; ?></td>
                            <td><?php echo $rec['downline_id']; ?></td>
                            <td><?php echo $rec['level']; ?></td>

                        </tr>
                    <?php 
                  $i++ ; 
                  }  ?>

                </tbody>
            </table>
            <?php echo $this->pagination->create_links(); ?>

        </div>
    </div>

</div>
<?php require_once 'footer.php'; ?>