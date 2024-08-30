<?php include 'header.php' ?>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <section class="content-header">
            <span class="">M Point Withdraw Request </span>
          </section>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active"> Withdraw Request</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
              <div class="col-12">
                  <form method="GET" action="<?php echo base_url('Admin/Withdraw/withdrawtype/'.$type);?>">
                      <div class="row">
                          <div class="col-md-4">
                              <select class="form-control" name="type">
                                 
                                  <option value="user_id" <?php echo $type == 'user_id' ? 'selected' : '';?>>
                                      User ID</option>
                                  
                              </select>
                          </div>
                          <div class="col-md-4">
                              <input type="text" name="value" class="form-control float-right"
                                  value="<?php echo $value;?>" placeholder="Search">
                          </div>

                          <div class="col-md-4">
                              <div class="input-group-append">
                                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                        
                      </div>
                  </form>
                  </div>
                <?php echo form_open(base_url('Admin/Withdraw/approveAdminWithdrawBY'), array('id' => ''));  ?>

                <table id="" class="display" style="width:100%">
              
                  <thead>
                    <tr>
                      <?php if ($status == 0) { ?>
                        <th></th>

                      <?php } ?>
                      <th>#</th>
                      <th>User ID</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Amount</th>
                      <th>Admin Charges</th>
                      <th>TDS</th>
                      <th>Wellness Charges</th>

                      <th>Total Deduction</th>
                      <th>Payable Amount</th>
                      <!-- <th>COIN</th> -->
                      <!-- <th>Type</th> -->
                      <!-- <th>Wallet Address </th> -->
                      <th>Status</th>
                      <!-- <th>Credit Type</th> -->
                      <th>Bank Name</th>
                      <th>Bank Account Number</th>
                      <th>Account Holder Name</th>
                      <th>Ifsc Code</th>
                      <th>Pan No</th>
                      <th>Request Date</th>
                      <!-- <th>Credit IN</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = ($segament) + 1;
                    foreach ($requests as $key => $request) {
                      //                        pr($request);
                    ?>
                      <tr>
                      <td><?php echo $i; ?></td>
                        <?php
                        if ($request['status'] == 0) {
                        ?>
                          <td><input name="data[]" type="checkbox" value="<?php echo $request['id']; ?>" /></td>
                        <?php
                        } else {
                          // echo '<td></td>';
                        }
                        ?>
                        
                        <td><?php echo $request['user_id']; ?></td>
                        <td><?php echo $request['user']['name']; ?></td>
                        <td><?php echo $request['user']['phone']; ?></td>
                        <td><?php echo $request['amount']; ?></td>
                        <td><?php echo $request['admin_charges']; ?></td>
                        <td><?php echo $request['tds']; ?></td>
                        <td><?php echo $request['amount'] * 6.67 / 100; ?></td>

                        <td><?php echo $request['amount'] - $request['payable_amount']; ?></td>
                        <td><?php echo $request['payable_amount']; ?></td>

                        <!-- <td><?php //echo $request['coin']; 
                                  ?></td> -->
                        <!-- <td><?php echo ucwords(str_replace('_', ' ', $request['type'])); ?></td> -->
                        <!-- <td><?php //echo $request['zil_address']; 
                                  ?></td> -->
                        <td>
                          <?php
                          $dataForPaying = json_encode($request, true);
                          if ($request['status'] == 0) :
                            echo "<button   class='btn btn-danger' data='" . $dataForPaying . "'><i class='fas fa-bolt' aria-hidden='true'> Pending</button>";
                          elseif ($request['status'] == 1) :
                            echo "<button class='btn btn-success'><i class='fas fa-bolt' aria-hidden='true'> Approved</button>";
                          elseif ($request['status'] == 2) :
                            echo 'Rejected';
                          endif;
                          ?>
                        </td>
                        <!-- <td> -->
                        <?php
                        //echo $request['bank']['bank_name'];
                        // if($request['credit_type'] == 'Bank'){
                        //   echo 'Bank Name :'. $request['bank']['bank_name'].'<br>';
                        //   echo 'Bank Account Number :'. $request['bank']['bank_account_number'].'<br>';
                        //   echo 'Account Holder Name :'. $request['bank']['account_holder_name'].'<br>';
                        //   echo 'Ifsc Code :'. $request['bank']['ifsc_code'].'<br>';
                        // } else {
                        //   echo $request['zil_address'];
                        // } 
                        ?>
                        <!-- </td> -->
                        <td><?php echo $request['bank']['bank_name']; ?></td>
                        <td><?php echo $request['bank']['bank_account_number']; ?></td>
                        <td><?php echo $request['bank']['account_holder_name']; ?></td>
                        <td><?php echo $request['bank']['ifsc_code']; ?></td>
                        <td><?php echo $request['bank']['pan']; ?></td>
                        <!-- <td><?php echo $request['credit_type']; ?></td> -->
                        <td><?php echo $request['created_at']; ?></td>
                        <!-- <td><?php echo $request['credit_type']; ?></td> -->
                        <td><a href="<?php echo base_url('Admin/Withdraw/request/' . $request['id']); ?>" target="_blank">View</a></td>
                      </tr>
                    <?php
                      $i++;
                    }
                    ?>

                  </tbody>
                </table>

              </div>
           
              <!-- /.card-body -->
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-5">
                <div class="dataTables_info" id="tableView_info" role="status" aria-live="polite">
                  Showing <?php echo ($segament + 1) . ' to  ' . ($i - 1); ?> of
                  <?php echo $total_records; ?> entries</div>
              </div>
              <div class="col-sm-12 col-md-7">
                <div class="dataTables_paginate paging_simple_numbers" id="tableView_paginate">
                  <?php
                  echo $this->pagination->create_links();
                  ?>
                </div>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'footer1.php' ?>