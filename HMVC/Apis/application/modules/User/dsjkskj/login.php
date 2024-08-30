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


    <section id="" class="register-login">
        <div class="container">
            <div class="reg-form">
                <div class="logo">
                    <img src="<?php echo base_url() ?>/MainAssets/UserAssets/img/logo1.png" alt="no-logo-image">
                </div>
                <div class="main-form" id="">
                    <!-- <div class="title">
                        <h3>Login</h3>
                    </div> -->
                    <!-- Hidden div for the popup -->
                    <?php echo form_open('login', array('id' => 'loginForm')); ?>

                    <span id="loginStatus"></span>
                    <div class="form-group">
                        <label for="">User ID</label>
                        <input type="text" class="form-control" id="user_id" placeholder="User ID" name="user_id" required />
                        <span class="text-danger"><?php echo form_error('user_id'); ?></span>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="text" class="form-control" id="password" placeholder="Password" name="password" required />
                        <span class="text-danger"><?php echo form_error('password'); ?></span>
                    </div>
                    <div class="form-group mt-5 text-center">
                        <button type="submit" class="btn form-btn w-50">Login</button>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="form-footre">
                        <p>Still no account? <a href=" <?php echo base_url('register') ?>">Create new account</a></p>
                    </div>
                </div>
            </div>
        </div>
        <section>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('User/LoginAjax'); ?>',
                data: $('#loginForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#loginStatus').text(response.message).css('color', 'green');
                        window.location.href = '<?php echo base_url('User/index'); ?>';
                        // $('#loginStatus').text(response.message).css('color', 'green');
                    } else {
                        $('#loginStatus').text(response.message).css('color', 'red');
                    }
                },
                error: function() {
                    $('#loginStatus').text('An error occurred while processing the login.').css('color', 'red');
                }
            });
        });
    });
</script>