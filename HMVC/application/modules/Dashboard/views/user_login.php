<?php
if (http == 0) {
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Login</title>
    <style>
        body {
            background: url('uploads/bg.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;

        }

        .card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0) 73.86%);
            backdrop-filter: blur(36px);
        }

        .logo img {
            max-width: 120px;
        }

        .form-control {

            padding: 5px 12px;
            border-radius: 6px !important;
            background: #fff !important;
            border: 0;
            color: black;
            box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.12);
            transition: all .3s linear;
            border: 1px solid transparent;
        }

        *,
        *:before,
        *:after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        .blob-btn {
            z-index: 1;
            position: relative;
            padding: 10px 130px;
            margin-bottom: 30px;
            text-align: center;
            text-transform: uppercase;
            font-size: 16px;
            font-weight: bold;
            background-color: transparent;
            outline: none;
            border: none;
            transition: color 0.5s;
            cursor: pointer;
            border-radius: 30px;
        }

        .blob-btn:before {
            content: "";
            z-index: 1;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border: 2px solid #94d43b;
            border-radius: 30px;
        }

        .blob-btn:after {
            content: "";
            z-index: -2;
            position: absolute;
            left: 3px;
            top: 3px;
            width: 100%;
            height: 100%;
            transition: all 0.3s 0.2s;
            border-radius: 30px;
        }

        .blob-btn:hover {
            color: #fff;
            border-radius: 30px;
        }

        .blob-btn:hover:after {
            transition: all 0.3s;
            left: 0;
            top: 0;
            border-radius: 30px;
        }

        .blob-btn__inner {
            z-index: -1;
            overflow: hidden;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border-radius: 30px;
            background: #fff;
        }

        .blob-btn__blobs {
            position: relative;
            display: block;
            height: 100%;
            filter: url('#goo');
        }

        .blob-btn__blob {
            position: absolute;
            top: 2px;
            width: 25%;
            height: 100%;
            background: #94d43b;
            border-radius: 100%;
            transform: translate3d(0, 150%, 0) scale(1.7);
            transition: transform 0.45s;
        }

        @supports (filter: url('#goo')) {
            transform: translate3d(0, 150%, 0) scale(1.4);
        }

        .blob-btn__blob:nth-child(1) {
            left: 0%;
            transition-delay: 0s;
        }

        .blob-btn__blob:nth-child(2) {
            left: 30%;
            transition-delay: 0.08s;
        }

        .blob-btn__blob:nth-child(3) {
            left: 60%;
            transition-delay: 0.16s;
        }

        .blob-btn__blob:nth-child(4) {
            left: 90%;
            transition-delay: 0.24s;
        }

        .blob-btn:hover .blob-btn__blob {
            transform: translateZ(0) scale(1.7);
        }

        @supports (filter: url('#goo')) {
            transform: translateZ(0) scale(1.4);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-7">
                <div class="card">
                    <div class="card-body">
                        <div class="mainbox">
                            <div class="logo">
                                <img src="<?php echo  base_url('uploads/logo.png') ?>" alt="">
                            </div>
                            <div class="heading">
                                <h4>Login</h4>
                            </div>
                            <?php echo $this->session->flashdata('message');?>
                            <?php echo form_open(base_url('Mainlogin')); ?>
                            <div class="form-group">
                                <!-- <label for="">User Id</label> -->
                                <input type="text" placeholder="Enter User ID" name="user_id" class="form-control">
                                <span class="text-danger"><?php echo form_error('user_id') ? 'error' : ''; ?></span>
                            </div>
                            <div class="form-group mt-3">
                                <!-- <label for="">Password</label> -->
                                <input type="text" class="form-control " placeholder="Enter Password" name="password">
                                <span class="text-danger"><?php echo form_error('password') ? 'error' : ''; ?></span>
                            </div>
                            <div class="form-group mt-3">
                                <div class="buttons">
                                    <button class="blob-btn" type="submit">
                                        SUBMIT
                                        <span class="blob-btn__inner">
                                            <span class="blob-btn__blobs">
                                                <span class="blob-btn__blob"></span>
                                                <span class="blob-btn__blob"></span>
                                                <span class="blob-btn__blob"></span>
                                                <span class="blob-btn__blob"></span>
                                            </span>
                                        </span>
                                    </button>
                                    <br />
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>
