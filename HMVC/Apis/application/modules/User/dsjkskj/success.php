<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a2f0d5a1bb.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url() ?>/MainAssets/UserAssets/scss/style.css">
    <title>Dashboard</title>
</head>

<body>
    <section class="register-login">
        <div class="container">
            <div class="reg-form">
                <div class="logo">
                    <img src="<?php echo base_url() ?>/MainAssets/UserAssets/img/logo1.png" alt="no-logo-image">
                </div>
                <div class="title">
                    <h3>Registeration Successfull</h3>
                </div>
                <div class="main-form">
                    <span class="text-dark"><?php echo $register_msg; ?></span>
                </div>
                <div class="form-footre">
                    <p>Already a member? <a href="login.php">Login here</a></p>
                </div>
            </div>
        </div>
        <section>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>