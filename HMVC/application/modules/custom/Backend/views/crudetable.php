<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>CrudeTable</title>
    <style>
        .brand-img{
            max-width: 50px;
        }
     table,th,td{
        border: 1px solid #000;
        text-align: center;
     }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-responsive">
                            <div class="table table-bordered">
                                <table class="table table-hover ">
                                    <thead>
                                        <tr class="bg-info">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Image</th>
                                            <th colspan="2">Action</th>
                                        </tr>


                                    </thead>
                                    <tbody>
                                        <?php if (!empty($users)) {
                                            foreach ($users as $key => $value) {
                                        ?>
                                                <tr>
                                                    <td><?php echo ++$key ;?></td>
                                                    <td><?php echo $value['name'] ;?></td>
                                                    <td><?php echo $value['email'] ;?></td>
                                                    <td><?php echo $value['password'] ;?></td>
                                                    <td><img src="<?php echo base_url('./uploads/') ?><?php echo $value['image'] ;?>" class="brand-img"></td>
                                                    <td><a href="<?php echo base_url('Backend/Crudecontroller/update_data/'). $value['id'] ;?>" class="btn btn-sm btn-outline-info">Update</a></td>
                                                    <td>Delete</td>
                                                </tr><?php }
                                                } else { ?>
                                            <tr>
                                                <td>No Record Found</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>