<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>Userform</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logo {
            width: 100%;
            text-align: center;

        }

        .logo img {
            max-width: 150px;

        }

        .card {
            box-shadow: 0px 5px 20px 0px rgba(92, 97, 242, .2);
            padding: 30px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="logo">
                                <img src="<?php echo base_url('uploads/raj.png') ?>" alt="">
                            </div>
                        </div>
                        <?php echo form_open_multipart(base_url('Backend/Usercontroller/add_data')); ?>

                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Name :</label>
                            </div>
                            <div class="col-12">
                                <input type="text" name="name" value="<?php echo set_value('name'); ?>" placeholder="Enter your Name" class="form-control">
                                <span class="text-danger"><?php echo form_error('name'); ?></span>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Email :</label>
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Enter email" class="form-control">
                                <span class="text-danger"><?php echo form_error('email'); ?></span>
                            </div>
                        </div>


                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Password :</label>
                            </div>
                            <div class="col-12">
                                <input type="password" name="password" value="<?php echo set_value('password'); ?>" placeholder="Enter password" class="form-control">
                                <span class="text-danger"><?php echo form_error('password'); ?></span>
                            </div>
                        </div>


                        <div class="row mt-3 ">
                            <div class="col-12">
                                <input type="submit" name="" value="submit" class="btn btn-info form-control">
                            </div>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>