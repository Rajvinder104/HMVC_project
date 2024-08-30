<?php require_once 'header.php' ;?>
<style>
    .tableheading{
        padding: 10px;
        box-shadow: 0 2px 3px rgba(0,0,0,0.4);
        border-radius: 7px;
        color: #fff;
        margin: 40px 0;
    }
</style>
<div class="main-content main_content_new">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="table table-responsive">
                        <div class="tableheading bg bg-warning">
                            <h4 class="mb-0">Package History</h4>
                        </div>
                       <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User Id</th>
                                <th>Acitvater</th>
                                <th>Package</th>
                                <th>Topup Date</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                             $i = $segment + 1 ;
                            foreach($records as $key => $value){ ?>
                                <tr>
                                <td><?php echo $i ;?></td>
                                <td><?php echo $value['user_id'] ;?></td>
                                <td><?php echo $value['activater'] ;?></td>
                                <td><?php echo $value['package'] ;?></td>
                                <td><?php echo $value['topup_date'] ;?></td>
                                <td><?php echo $value['created_at'] ;?></td>
                               </tr>
                            <?php ++$i ; }  ?>
                          
                        </tbody>
                       </table>
                    </div>
                    <?php echo $this->pagination->create_links() ;?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php' ;?>
