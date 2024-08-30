<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>insertform</title>
    <style>
        body {
            background: url('https://img.freepik.com/free-vector/geometric-blue-background-desktop-wallpaper-vector_53876-135927.jpg?w=1380&t=st=1705469605~exp=1705470205~hmac=4f06f56792675ff1f80edd021dee26c32a95493b2c3ce3350d8e01d29edd2268');
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            position: relative;
            padding: 100px 0;
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

        .card {
            box-shadow: 0px 5px 20px 0px rgba(92, 97, 242, .2);
            padding: 25px;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .logo {
            text-align: center;
        }

        .logo img {
            max-width: 120px;
        }

        .form-control.btn-brand {
            display: inline-block;
            position: relative;
            background: linear-gradient(to right, #2b2c49, #e66239);
            color: #fff;
            font-size: 17px;
            font-weight: 600;
            border-radius: 10px;
            border: none;
            transition: all 0.3s linear;
        }

        .form-control.btn-brand:hover {
            transform: scale(1.02);
        }

        .card::after {
            position: absolute;
            content: '';
            top: -5%;
            left: -5%;
            width: 140px;
            height: 140px;
            background: #e56339;
            border-radius: 50%;
            z-index: 0;
            animation: animate 10s linear infinite alternate;
        }

        .card::before {
            position: absolute;
            content: '';
            top: -5%;
            left: -5%;
            width: 100px;
            height: 100px;
            background: #312d4d;
            border-radius: 50%;
            z-index: 1;
            animation: animate 10s linear infinite alternate;

        }
        @keyframes animate{
            0%{transform: scale(0.9);}
            50%{transform: scale(1.5);}
            100%{transform: scale(0.9);}
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="co-12">
                                <div class="logo">
                                    <img src="<?php echo base_url('uploads/logo.png') ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <?php echo form_open_multipart(base_url('site/controller/add_data')); ?>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Name</label>
                                <input type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php echo set_value('name') ?>">
                                <span class="text-danger"><?php echo form_error('name') ?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Email</label>
                                <input type="email" name="email" placeholder="Enter your email" class="form-control" value="<?php echo set_value('email') ?>">
                                <span class="text-danger"><?php echo form_error('email') ?></span>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Password</label>
                                <input type="password" name="password" placeholder="Enter your password" class="form-control" value="<?php echo set_value('password') ?>">
                                <span class="text-danger"><?php echo form_error('password') ?></span>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="form-control btn-brand">
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