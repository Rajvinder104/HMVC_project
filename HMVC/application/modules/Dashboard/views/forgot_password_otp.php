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
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo title; ?> </title>
    <meta name="application-name" content="<?php echo title; ?> ">
    <meta name="author" content="<?php echo title; ?>">
    <meta name="keywords" content="<?php echo title; ?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/');?>images/logo.png" type="image/x-icon">
    <meta name="description" content="World's 1st DFT Protocol">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('uploads/favicon.png'); ?>">
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/register.css" rel="stylesheet" type="text/css" />


    <!-- App Css-->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="https://fonts.cdnfonts.com/css/koho-2" rel="stylesheet">

    <!-- font-awesome-cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


</head>
<style>
    li.active a::after {
        width: 25px;
        opacity: 1;
        transition: all 0.3s ease-in-out;
    }

    .form-wrap {
        position: relative;
    }

    .form-wrap i {
        position: absolute;
        top: 10px;
        left: 11px;
    }
    li.form-link a {
    color: #9f8040 !important;
    margin-left: 12px;
}
</style>

<body>
    <div id="space">


        <div class="">

            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-md-9 col-12">

                        <div class="card">
                            <div id="" style="display:block" class="">



                                <div id="forgetDiv" class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-primary">
                                        <div class="sub_title">
                                    <a href="<?php echo base_url(); ?>">
                                        <img src="<?php echo base_url('site-assets/images/img/logo-drak.png'); ?>" class="header-brand-img desktop-logo" alt="logo" />
                                    </a>
                                    <h6 class="account1 forgot-title">Forgot Password</h6>
                                </div>
                                            <p style="color:red;text-align: center;"><?php echo $this->session->flashdata('message'); ?></p>
                                            <div class="panel-body">
                                                <div class="details password-form">
                                                    <fieldset>
                                                        <div class="form-field form-wrap">
                                                            <label for="User_id">User_id</label>
                                                            <input type="text" class="form-control" id="user_id" name="user_id" required value="<?php echo set_value('user_id'); ?>" style="margin-top: 17px;" autocomplete="off">
                                                            <span class="ion ion-locked form-control-feedback "></span>
                                                        </div>
                                                        <div class="form-group has-feedback">
                                                            <button id="signupBtn" type="button" class="button-three tab-button-login" name='Submit' value='Login'>Submit</button>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="VerifyDiv" style="display:none" class="row justify-content-center">
                                    <div class="panel panel-primary">
                                        <?php echo form_open(base_url('dashboard/forget-password2'), array('method' => 'POST')); ?>
                                        <p style="color:red;text-align: center;"><?php echo $this->session->flashdata('message'); ?></p>
                                        <div class="panel-body">
                                            <div class="details password-form">
                                                <fieldset>
                                                    <!-- <div class="form-group ">
                                                        <div class="label-area">
                                                        </div>
                                                        <div class="row-holder form-wrap">
                                                            <label for="Email_id">Email_id</label>
                                                            <input id="SiteURL" type='text' name='email' value="<?php //echo set_value('email');
                                                                                                                ?>" maxlength='50' class="form-control" readonly />
                                                        </div>

                                                    </div> -->
                                                    <!-- <div class="form-field form-wrap">
                                                        <label for="User_id">User_id</label>
                                                        <input type="text" class="form-control" name="user_id" value="<?php //echo set_value('user_id');
                                                                                                                        ?>" style="margin-top: 17px;">
                                                        <span class="ion ion-locked form-control-feedback "></span>
                                                    </div> -->

                                                    <?php
                                                    ?>
                                                    <div class="form-field form-wrap position-relative">
                                                    <input type="hidden" class="form-control" id ="get_user" name="user_id" >

                                                        <input type="text" class="form-control" name="otp" placeholder="Enter OTP">
                                                    </div>

                                                    <div class="text-start ">

                                                        <p>Still no account? <a href="<?php echo base_url(); ?>register" class="tgreen">Create new account</a></p>

                                                    </div>

                                                    <div class="form-group has-feedback">
                                                        <button id="" type="submit" class="button-three" name='Submit' value='Login'>Forgot Password</button>
                                                    </div>



                                                </fieldset>
                                            </div>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                                <!-- <div id="VerifyDiv" style="display:none" class="row justify-content-center">
                                    <div class="col-lg-10 col-md-6 col-sm-12 col-12">
                                        <div class="panel panel-primary">
                                            <span><?php //echo $this->session->flashdata('forget_message');
                                                    ?></span>
                                            <div class="panel-body">
                                                <div class="details password-form">
                                                    <fieldset>
                                                        <?php //echo form_open(base_url('dashboard/forget-passwords'), array('id' => 'forgetPassword'));
                                                        ?>
                                                        <div class="form-field form-wrap position-relative">
                                                            <input id="get_user" type="hidden" class="form-control" name="user_id" placeholder="Enter New Password">
                                                        </div>
                                                        <div class="form-field form-wrap position-relative">
                                                            <input id="password-field1" type="password" class="form-control" name="npassword" placeholder="Enter New Password">
                                                            <span id="second" toggle="#password-field1" class="fa-solid fa-eye-slash field-icon toggle-password"></span>
                                                            <div id="passwordStrength"></div>
                                                        </div>
                                                        <div class="form-field form-wrap position-relative">
                                                            <input id="password-field2" type="password" class="form-control" name="vpassword" placeholder="Enter Confirm Password">
                                                            <span id="third" toggle="#password-field2" class="fa-solid fa-eye-slash field-icon toggle-password"></span>
                                                        </div>
                                                        <div class="form-field form-wrap position-relative">
                                                            <input type="text" class="form-control" name="otp" placeholder="Enter OTP">
                                                        </div>
                                                        <div class="mt-3 form-group has-feedback">
                                                            <button type="button" onclick="submit_form(this, 'forgetPassword')" class="button-three tab-button-login">Update</button>
                                                        </div>
                                                        <?php //form_close();
                                                        ?>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row  pt-2">
                                    <div class="col-md-8 col-12">
                                        <div>
                                            <ul class="nav login-tab flex-nowrap">
                                                <li><a href="<?php echo base_url('register'); ?>">Create Account? </a></li>
                                                <li class="active form-link"><a href="<?php echo base_url('/login'); ?>">Enter Account </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="<?php echo base_url('NewDashboard/') ?>assets/js/app.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- <script>
        // Assume you have an input field with id 'password' and a feedback element with id 'passwordStrengthMessage'
        document.getElementById('password-field1').addEventListener('input', function() {
            let password = this.value;
            // AJAX request to server for password strength check
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/checkPasswordStrength', true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    // Display the password strength feedback
                    console.log(response.message);
                    document.getElementById('passwordStrength').innerText = response.message;
                }
            };
            // Send the password to the server for strength check
            xhr.send(JSON.stringify({
                password
            }));
        });
    </script> -->

    <script>
        $(document).on('click', '#signupBtn', function() {
            var user_id = $('#user_id').val();
            console.log(user_id);
            if (user_id != '') {
                var url = '<?php echo base_url("Dashboard/UserInfo/get_user2/") ?>' + user_id;
                // alert('here')
                fetch(url, {
                        method: "GET",
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log('res', response);
                        toastr.options.newestOnTop = true;
                        toastr.options.progressBar = true;
                        toastr.options.closeButton = true;
                        toastr.options.preventDuplicates = true;
                        if (response.success == 1) {
                            var url2 = '<?php echo base_url('Dashboard/SecureWithdraw/getOtpMail2/'); ?>' + user_id;
                            $.get(url2, function(res) {
                                if (res.status == 1) {
                                    toastr.success('OTP is sent to your registered E-mail');
                                    // alert('OTP send to registered E-mail');
                                    $("#forgetDiv").css("display", "none");
                                    $("#VerifyDiv").css("display", "block");
                                    document.getElementById('get_user').value = user_id;
                                } else {
                                    toastr.error('Network error,please try later')
                                }
                            }, 'JSON')
                        } else {
                            toastr.error(response.message)
                            $("#forgetDiv").css("display", "block");
                            $("#VerifyDiv").css("display", "none");
                        }
                    });
            }
        })
    </script>
    <script>
        async function submit_form(evt, id) {
            // alert('jhdfghjd');
            var url = document.getElementById(id).action;
            var element = document.getElementById(id);
            fetch(url, {
                    method: "POST",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: new FormData(element),
                })
                .then(response => response.json())
                .then(result => {
                    toastr.options.newestOnTop = true;
                    toastr.options.progressBar = true;
                    toastr.options.closeButton = true;
                    toastr.options.preventDuplicates = true;

                    if (result.status == '1') {
                        toastr.success(result.message);
                        setTimeout(function() {
                            window.location.href = result.url;
                        }, 1500);
                    } else if (result.status == '0') {
                        toastr.info(result.message)
                    } else {
                        toastr.error(result.message)
                    };
                });
        }
    </script>
    <script>
        const maxWidth = window.screen.width;
        const maxHeight = window.screen.height;

        function Random(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min) + min);
        }

        function Shadows(amount) {
            let shadow = "";
            for (let i = 0; i < amount; i++) {
                shadow += Random(0, maxWidth) + "px " + Random(0, maxHeight) + "px " + "rgb(255," + Random(0, 256) + "," + Random(0, 256) + "), ";
            }
            shadow += Random(0, maxWidth) + "px " + Random(0, maxHeight) + "px " + "rgb(255," + Random(0, 256) + "," + Random(0, 256) + ")";
            return (shadow);
        }

        for (let i = 1; i <= 3; i++) {
            document.documentElement.style.setProperty('--shadows' + i, Shadows(100));
        }
    </script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    <script>
        $("#first").click(function() {

            $(this).toggleClass("fa-solid fa fa-eye");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $("#second").click(function() {

            $(this).toggleClass("fa-solid fa fa-eye");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $("#third").click(function() {

            $(this).toggleClass("fa-solid fa fa-eye");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
    <!-- <script>
        document.getElementById('password-field1').addEventListener('input', function(event) {
            // Get the input value
            let inputValue = event.target.value;

            // Remove white spaces and non-alphanumeric characters
            let sanitizedValue = inputValue.replace(/[^a-zA-Z0-9]/g, '');
            if (sanitizedValue !== inputValue) {
                document.getElementById('errorMessage').innerHTML = '<span class="text-danger">Only alphanumeric characters are allowed.</span>';

            } else {
                document.getElementById('errorMessage').innerHTML = '';

            }
            // Update the input field value
            event.target.value = sanitizedValue;
        });
    </script> -->
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
