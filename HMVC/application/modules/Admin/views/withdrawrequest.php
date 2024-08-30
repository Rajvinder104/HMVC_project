<?php include 'header.php' ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <section class="content-header">
                        <span class=""><?php echo $header; ?> </span>
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
                                    <form method="GET" action="<?php echo $path; ?>">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <select class="form-control" name="type">

                                                    <option value="tbl_withdraw.user_id" <?php echo $type == 'tbl_withdraw.user_id' ? 'selected' : ''; ?>>
                                                        User ID</option>
                                                    <option value="tbl_users.name" <?php echo $type == 'tbl_users.name' ? 'selected' : ''; ?>>
                                                        name</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="value" class="form-control float-right" value="<?php echo $value; ?>" placeholder="Search">
                                            </div>

                                            <div class="col-md-4">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <table id="" class="display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User ID</th>
                                            <th>Name ID</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = ($segament) + 1;
                                        foreach ($requests as $key => $request) {

                                        ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>

                                                <td><?php echo $request['user_id']; ?></td>
                                                <td><?php echo $request['name']; ?></td>

                                                <td>
                                                    <?php
                                                    $dataForPaying = json_encode($request, true);
                                                    if ($request['status'] == 0) :
                                                        echo "<button   class='btn btn-warning' data='" . $dataForPaying . "'><i class='fas fa-bolt' aria-hidden='true'> Pending</button>";
                                                    elseif ($request['status'] == 1) :
                                                        echo "<button class='btn btn-success'><i class='fas fa-bolt' aria-hidden='true'> Approved</button>";
                                                    elseif ($request['status'] == 2) :
                                                        echo "<button class='btn btn-danger'><i class='fas fa-bolt' aria-hidden='true'> Rejected</button>";;
                                                    endif;
                                                    ?>
                                                </td>


                                                <td><a href="<?php echo base_url('Admin/Withdraw/request/' . $request['id']); ?>" target="_blank">View</a></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>

                                    </tbody>
                                </table>
                                <?php echo $this->pagination->create_links();
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ?>
