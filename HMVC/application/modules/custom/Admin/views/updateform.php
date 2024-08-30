<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <title>updateform</title>
    <style>
        body {
            background: url('https://img.freepik.com/free-vector/geometric-blue-background-desktop-wallpaper-vector_53876-135927.jpg?w=1380&t=st=1705469605~exp=1705470205~hmac=4f06f56792675ff1f80edd021dee26c32a95493b2c3ce3350d8e01d29edd2268');
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

        .card {
            box-shadow: 0px 5px 20px 0px rgba(92, 97, 242, .2);
            padding: 25px;
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
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                    <div class="row">
                            <div class="co-12">
                                <div class="logo">
                                    <img src="<?php echo base_url('uploads/logo.png') ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <?php echo form_open_multipart(base_url('Admin/Newcontroller/update_data/' . $user['id'])); ?>
                        <div class="row">
                            <div class="col-12">
                                <label for="">Name</label>
                                <input type="text" name="name" placeholder="Enter your name" class="form-control" value="<?php echo $user['name']; ?>">
                                <span class="text-danger"><?php echo form_error('name') ?></span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Email</label>
                                <input type="email" name="email" placeholder="Enter your email" class="form-control" value="<?php echo $user['email']; ?>">
                                <span class="text-danger"><?php echo form_error('email') ?></span>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <label for="">Password</label>
                                <input type="password" name="password" placeholder="Enter your password" class="form-control" value="<?php echo $user['password']; ?>">
                                <span class="text-danger"><?php echo form_error('password') ?></span>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <input type="submit" value="Submit" class="form-control btn btn-outline-info">
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