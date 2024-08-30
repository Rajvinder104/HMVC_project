<?php require_once 'header.php'; ?>
<div class="main-content app-content mt-0 ">
    <div class="container-fluid">
        <div class="row mx-5">
            <div class="col-12">
                <div class="header bg bg-danger">
                    <h4 class="mb-0">Group BY Level</h4>
                </div>
            </div>
            <div class="col-12">
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
          

                            <?php $i= $segment+1;
                             foreach ($allrecords as $key => $rec) { ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $rec['level']; ?></td>
                                    <td><a href="<?php echo base_url('dashboard/records/' . $rec['level']) ?>">View</a></td>
                                </tr>
                            <?php
                             $i++ ; 
                        } 
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php echo $this->pagination->create_links(); ?>

            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>