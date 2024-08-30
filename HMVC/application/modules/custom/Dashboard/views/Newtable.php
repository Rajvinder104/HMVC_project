<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Newtable</title>
    <style>
        table,
        th,
        td {
            text-align: center;
        }

        .pagination {
            justify-content: end;
        }
    </style>
</head>

<body>
    <?php // print_r($users) ; 
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-hover ">
                                <form action="<?php echo base_url('Dashboard/Homecontroller/fetch_data/') ?>" method="get">
                                    <div class="row d-flex justify-content-end">
                                        <div class="col-sm-4 ">
                                            <select name="type" id="" class="form-control btn-sm">
                                                <option value="name">name</option>
                                            </select>
                                        </div>
                                       
                                        <div class="col-sm-4 mt-3 mt-sm-0 "> <input type="text" name="value" class="form-control btn-sm mb-3" placeholder="Search Here..."></div>
                                        <div class="col-4"><input type="date" class="form-control" value="start-date" name="start_date"></div>
                                        <div class="col-4"><input type="date" class="form-control" value="end-date" name="end_date"></div>
                                        <div class="col-sm-4"><input type="submit" value="search" class="btn btn-outline-primary btn-sm form-control mb-3"></div>

                                    </div>
                                </form>
                                <thead class="bg-info text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th colspan="2">opprations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $value['id']; ?></td>
                                            <td><?php echo $value['name']; ?></td>
                                            <td><?php echo $value['email']; ?></td>
                                            <td><?php echo $value['password']; ?></td>
                                            <td><a href="<?php echo base_url('Dashboard/Homecontroller/update_data/') . $value['id']; ?>" class="btn btn-outline-info btn-sm">update</a></td>
                                            <td><a href="<?php echo base_url('Dashboard/Homecontroller/delete_data/') . $value['id']; ?>" class="btn btn-outline-danger btn-sm">Delete</a></td>
                                        </tr>
                                    <?php   } ?>

                                </tbody>
                            </table>
                            <?php echo $this->pagination->create_links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>