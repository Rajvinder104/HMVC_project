<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>CrudeForm</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-body">
                    <?php echo form_open_multipart(base_url('Backend/Crudecontroller/add-data' . $user['id']));?>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                        <label for="">Name : </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="name" class="form-control" placeholder="Enter your username" value="<?php echo $user['name']; ?>">
                                        <span class="text-danger"><?php echo form_error('name'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <label for="">Email : </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="email" class="form-control" placeholder="Enter your email" value="<?php echo $user['email']; ?>">
                                        <span class="text-danger"><?php echo form_error('email');  ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row mt-3">
                                    <div class="col-4">
                                        <label for="">Password : </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="password" class="form-control" placeholder="Enter Password" value="<?php echo $user['password']; ?>">
                                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <input type="submit" name="" value="submit" class="bg bg-primary">
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>