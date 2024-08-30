<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Usertable</title>
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
                            <div class="row">
                                <div class="col-12">
                                    <form action="<?php echo base_url('Backend/Usercontroller/fetch_data/') ?>" method="get">
                                        <div class="row mb-3">
                                            <div class="col-6 mb-3">
                                                <input type="date" name="start_date" class="form-control btn-sm">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <input type="date" name="end_date" class="form-control btn-sm">
                                            </div>
                                            <div class="col-4">
                                                <select name="select" id="" class="form-control btn-sm">
                                                    <option value="name">name</option>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="searching" placeholder="Search here..." class="form-control btn-sm">
                                            </div>
                                            <div class="col-4">
                                                <input type="submit" value="submit" class="form-control btn-outline-info btn-sm">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <table class="table table-bordered table-hover">
                                    <thead class="bg bg-primary text-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th colspan="2">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $key => $value) {

                                        ?>
                                            <tr>
                                                <td><?php echo ++$key; ?></td>
                                                <td><?php echo $value['name']; ?></td>
                                                <td><?php echo $value['email']; ?></td>
                                                <td><?php echo $value['password']; ?></td>
                                                <td><a href="<?php echo base_url('Backend/Usercontroller/update_data/') . $value['id']; ?>" class="btn btn-outline-info btn-sm">Update</a></td>
                                                <td><a href="<?php echo base_url('Backend/Usercontroller/delete_data/') . $value['id']; ?>" class="btn btn-outline-danger btn-sm">Delete</a></td>
                                            </tr><?php } ?>

                                    </tbody>

                                </table>

                                <?php echo $this->pagination->create_links(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>