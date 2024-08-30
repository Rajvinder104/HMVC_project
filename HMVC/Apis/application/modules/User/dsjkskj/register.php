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
                <div id="popupContainer" style="display: none;">
                    <span style="color:green">Registration Successfull</span>
                    <p> <span id="popupName"></span></p>
                    <a class="btn btn-success" href=" <?php echo base_url('login') ?>">Login </a>
                </div>

                <div class="main-form" id="main_hide">

                    <?php echo form_open('register?sponsor_id=', array('id' => 'registerForm')); ?>

                    <span id="registrationStatus"></span>
                    <div class="form-group">
                        <label for="">Sponsor ID</label>
                        <input type="text" class="form-control" id="sponsor_id" placeholder="Sponsor ID" name="sponsor_id" required />
                        <span class="text-danger"><?php echo form_error('sponsor_id'); ?></span>
                    </div>
                    <div class="form-group mt-5 text-center">
                        <button id="btn" type="submit" class="btn form-btn w-50">Submit</button>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="form-footre">
                        <p>Already a member? <a href=" <?php echo base_url('login') ?>">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var myModalEl = document.getElementById('myModal')
    myModalEl.addEventListener('hidden.bs.modal', function(event) {
        // do something...
    })
</script>
<script>
    $(document).ready(function() {
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('User/Register/indexAjax'); ?>',
                data: $('#registerForm').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#popupName').text(response.message);
                        $('#popupContainer').show();
                        $('#main_hide').hide();

                    } else {
                        $('#registrationStatus').text(response.message).css('color', 'red');
                    }
                },
                error: function() {
                    $('#registrationStatus').text('An error occurred while processing the registration.').css('color', 'red');
                }
            });
        });
    });
</script>