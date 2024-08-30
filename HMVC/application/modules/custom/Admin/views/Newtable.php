<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Newtable</title>
    <style>
        body {
            background: url('https://img.freepik.com/free-photo/top-view-school-supplies-with-copyspace_23-2148198139.jpg?w=1380&t=st=1705396554~exp=1705397154~hmac=de94f70acb6c2a562050ef8309267b56fbcb9d8301621fc93b2ac642649f88c6');
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        body::before {
            position: fixed;
            content: '';
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #000;
            opacity: 0.6;
        }
        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 120px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <div class="row  mb-4">
                            <div class="co-12">
                                <div class="logo">
                                    <img src="<?php echo base_url('uploads/logo.png') ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-bordered table-hover">
                                <form action="<?php echo base_url('Admin/Newcontroller/fetch_data/') ?>" method="get">
                                 <div class="row">
                                        <div class="col-4">
                                            <input type="date" name="start_date" class="form-control btn btn-sm btn-outline-warning">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <input type="date" name="end_date" class="form-control btn btn-sm btn-outline-danger">
                                        </div>
                                        <div class="col-4">
                                            <input type="submit" class="btn btn-outline-info form-control btn-sm" value="Submit">
                                        </div>
                                    </div>
                                </form>
                                <form action="<?php echo base_url('Admin/Newcontroller/fetch_data/') ?>" method="get">
                                    <div class="row mb-3 mb-3">
                                        <div class="col-4">
                                            <select name="select" id="" class="form-control btn-sm">
                                                <option value="name">name</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" name="searching" class="form-control btn-sm" placeholder="Search here">
                                        </div>
                                        <div class="col-4">
                                            <input type="submit" class="btn btn-outline-info form-control btn-sm" value="Submit">
                                        </div>
                                    </div>

                                </form>
                                <thead class="bg bg-primary text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th colspan="2" class="text-center">opperations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $value['id']; ?></td>
                                            <td><?php echo $value['name']; ?></td>
                                            <td><?php echo $value['email']; ?></td>
                                            <td><?php echo $value['password']; ?></td>
                                            <td class="text-center"><a href="<?php echo base_url('Admin/Newcontroller/update_data/') . $value['id']; ?>" class="btn btn-outline-warning btn-sm">Update</a></td>
                                            <td class="text-center"><a href="<?php echo base_url('Admin/Newcontroller/delete_data/') . $value['id']; ?>" class="btn btn-outline-danger btn-sm">Delete</a></td>

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