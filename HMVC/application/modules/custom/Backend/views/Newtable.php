<?php defined('BASEPATH') or exit('No direct script access allowed');?>
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
            border: 1px solid #000;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg bg-success text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th colspan="2">Opperations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $key => $value){ ?>
                                    <tr>
                                    <td><?php echo $value['id']?></td>
                                    <td><?php echo $value['name']?></td>
                                    <td><?php echo $value['email']?></td>
                                    <td><?php echo $value['password']?></td>
                                    <td><a href="<?php echo base_url('Backend/Newcontroller/update_data/') . $value['id'];?>" class="btn btn-outline-primary btn-sm">Update</a></td>
                                    <td><a href="<?php echo base_url('Backend/Newcontroller/delete_data/') . $value['id'];?>" class="btn btn-outline-danger btn-sm">Delete</a></td>
                                </tr>
                                   <?php } ?>

                                </tbody>
                            </table>
                            <?php echo $this->pagination->create_links() ;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>