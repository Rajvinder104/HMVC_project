<?php require_once('header.php') ?>
<style>

</style>
<section id="main" class="main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 page-title">
                <h3>Form</h3>
            </div>
        </div>
    </div>
    <!-- Form -->
    <div class="page-main-div">
        <div class="container-fluid">
            <div class="row">
                <!-- form-start -->
                <div class="col-md-6">
                    <div class="form-title">
                        <h4>Activation</h4>
                    </div>
                    <div class="form-div">
                        <?php echo form_open('activation', array('id' => 'activationForm')); ?>
                        <span id="accountStatus"></span>
                        <div class="form-group">
                            <div class="form-group">
                                <label>User ID</label>
                                <input type="text" name="user_id" class="form-control">
                            </div>
                            <label for="amount">Choose Package</label>
                            <select id="amount" type="text" name="package_id" class="form-control">
                                <?php foreach ($package as $key => $value) {
                                    echo '<option value="' . $value['id'] . '">' . $value['description'] . ' ' . $value['price'] . '</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="form-group mt-4 text-center">
                            <button type="submit" class="form-control form-btn w-50">Activate</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!-- form-end -->
            </div>
        </div>
    </div>
</section>
<?php require_once('footer.php') ?>
<script>
    $(document).ready(function () {
        $('#activationForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('User/Activation/ActivationAjax'); ?>',
                data: $('#activationForm').serialize(),
                dataType: 'json',

                success: function (response) {
                    if (response.status === 'success') {
                        $('#accountStatus').text(response.message).css('color', 'green');
                    } else {
                        $('#accountStatus').text(response.message).css('color', 'red');
                    }
                },
                error: function () {
                    $('#accountStatus').text('An error occurred while processing the activation.').css('color', 'red');
                }
            });
        });
    });
</script>