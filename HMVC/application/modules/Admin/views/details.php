<?php include_once 'header.php'; ?>
<div class="main-content app-content mt-0">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="header">
                        <h4 class="bg bg-warning" style="border-radius: 7px; padding:10px;margin:10px 0 ;color:#fff;"><?php echo $header; ?></h4>
                    </div>
                    <div class="table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User ID</th>
                                    <th>Bank Name</th>
                                    <th>Account Number</th>
                                    <th>IFSC code</th>
                                    <th>Branch Name</th>
                                    <!-- <th>Status</th> -->
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $key => $value) {
                                    extract($value);
                                  
                                    //   $approved = '<button class="btn btn-success apvbtn" data-id="' . $id . '" data-status="2">Approve</button>';
                                    //   $rejected = '<button class="btn btn-danger apvbtn" data-id="' . $id . '" data-status="3">Reject</button>'; 
                                ?>
                                    <tr>
                                        <td><?php echo  $id; ?></td>
                                        <td><?php echo  $user_id; ?></td>
                                        <td><?php echo  $bank_name; ?></td>
                                        <td><?php echo  $bank_account_number; ?></td>
                                        <td><?php echo  $ifsc_code; ?></td>
                                        <td><?php echo  $branch_name; ?></td>
                           
                                        <?php if ($kyc_status == 2) { ?>
                                            <td><a href="" class="btn btn-success disabled">Approved</a></td>

                                        <?php  } elseif ($kyc_status == 3) { ?>
                                            <td><a href="" class="btn btn-danger disabled">Rejected</a></td>

                                        <?php } else { ?>
                                            <td><a href="<?php echo base_url('admin/uploaddocument/'. $value['id']) ?>" target="_blank" class="btn btn-info">View</a></td>

                                        <?php  } ?>
                                    </tr>
                                <?php   } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'footer.php'; ?>