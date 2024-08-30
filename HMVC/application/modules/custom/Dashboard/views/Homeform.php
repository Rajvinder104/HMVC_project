<?php defined('BASEPATH') OR exit ('No direct script access allowed');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Homeform</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <?php echo form_open_multipart(base_url('Dashboard/Homecontroller/add_data')); ?>
                        <div class="row mt-3">
                            <div class="col-3">
                                <label for="">Name :</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" placeholder="Enter your Name" name="name" value="<?php echo set_value('name') ?>">
                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <label for="">Email :</label>
                            </div>
                            <div class="col-9">
                                <input type="email" class="form-control" placeholder="Enter your email" name="email" value="<?php echo set_value('email') ?>">
                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3">
                                <label for="">Password :</label>
                            </div>
                            <div class="col-9">
                                <input type="Password" class="form-control" placeholder="Enter your Password" name="password" value="<?php echo set_value('password') ?>">
                                <span class="text-danger"><?php echo form_error('password'); ?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <input type="submit" class="form-control bg bg-primary text-light" value="Submit">
                            </div>
                        </div>
                        <?php echo  form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
