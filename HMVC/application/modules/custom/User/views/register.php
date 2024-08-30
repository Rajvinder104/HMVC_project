<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a2f0d5a1bb.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url() ?>/MainAssets/UserAssets/img/logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo base_url() ?>/MainAssets/UserAssets/scss/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <title>Dashboard</title>
</head>
<style>
    .btn_success {
        background: cornflowerblue;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-family: 'Lato';
        margin: 5px;
        text-transform: uppercase;
        cursor: pointer;
        outline: none;
    }

    .btn_success:hover {
        background: orange;
    }
</style>

<body>


    <section id="main_hide" class="register-login">
        <div class="container">
            <div class="reg-form">
                <div class="logo">
                    <img src="<?php echo base_url() ?>/MainAssets/UserAssets/img/logo1.png" alt="no-logo-image">
                </div>
                <div class="main-form" id="">
                    <?php echo form_open('register?sponsor_id=', array('id' => 'registerForm')); ?>
                    <span id="registrationStatus"></span>
                    <div class="form-group">
                        <label for="">Sponsor ID</label>
                        <input type="text" class="form-control" id="sponsor_id" placeholder="Sponsor ID" value="<?php echo $sponsor_id; ?>" name="sponsor_id" required />
                        <span class="text-danger"><?php echo form_error('sponsor_id'); ?></span>
                    </div>
                    <div class="form-group mt-5 text-center">
                        <button id="btn" type="submit" class="btn form-btn w-50 btn_success">Submit</button>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="form-footre">
                        <p>Already a member? <a href=" <?php echo base_url('login') ?>">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                        swal("Registration Successfully", response.message, "success")
                        // $('#main_hide').hide();
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