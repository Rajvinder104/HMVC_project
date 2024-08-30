<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>All_data</title>
</head>

<body>
    <?php // print_r($users); 
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered">
                            <form action="<?php echo base_url('site/controller/fetch_data/') ?>" method="get">
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
                                <thead class="bg-info text-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>password</th>
                                        <th colspan="2" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $key => $value) { ?>
                                        <tr>
                                            <td><?php echo $value['id'] ?></td>
                                            <td><?php echo $value['name'] ?></td>
                                            <td><?php echo $value['email'] ?></td>
                                            <td><?php echo $value['password'] ?></td>
                                            <td><a href="<?php echo base_url('site/Controller/update_data/'). $value['id']; ?>" class="btn btn-outline-info btn-sm">update</a></td>
                                            <td><a href="<?php echo base_url('site/Controller/delete_data/'). $value['id']; ?>" class="btn btn-outline-danger btn-sm">Delete</a></td>
                                        </tr>
                                    <?php } ?>

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