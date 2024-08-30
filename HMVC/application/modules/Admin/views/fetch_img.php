<?php include 'header.php'; ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                   <h4> <?php //echo $this->session->flashdata('message');?></h4>
                    <div class="heading">
                        <h4>Uploads Images</h4>
                    </div>
                    <div class="table-reponsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Document</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $key => $value) { ?>
                                    <tr>
                                        <td><?php echo ++$key ?></td>
                                        <td><?php echo $value['name'] ;?></td>
                                        <td><img src="<?php echo base_url('uploads/') . $value['image'] ;?>" alt="" style="width: 40px;"></td>
                                        <td><a href="<?php echo base_url('admin/Report/deleteimg/'. $value['id']) ;?>">Delete</a></td>
                                    </tr>
                                <?php  } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>