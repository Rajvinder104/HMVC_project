<?php require_once 'header.php';
date_default_timezone_set('Asia/Kolkata');
?>
<?php $userinfo = userinfo(); ?>
<!--**********************************
   Content body start
   ***********************************-->
<style>
    body {
        background: rgba(240 241 247) !important;
    }

    .social_icon img {
        max-width: 45px;
        background-color: #fff;
        border-radius: 5px;
        padding: 2px;
    }

    .work-image {
        display: block;
        position: relative;
    }

    .popup-btn {
        position: absolute;
        left: 0;
        top: 50%;
        text-align: center;
        right: 0;
        color: #ffffff;
        margin-top: 0;
        font-size: 24px;
        opacity: 0;
        visibility: hidden;
    }

    .work-image:hover .popup-btn {

        visibility: visible;
        margin-top: -15px;

    }

    .box_content.flex-custom {
        width: 100%;
    }

    /* .bg-color{
   background: #ecf2ff !important;
   }
   .bg1-color{
   background: #fef5e5 !important;
   }
   .bg2-color{
   background: #e8f7ff !important;
   }
   .bg3-color{
   background: #fdede8 !important;
   }
   .bg4-color{
   background: #e6fffa !important;
   }*/
</style>
<script>
    function countdown(element, seconds) {
        // Fetch the display element
        var el = document.getElementById(element).innerHTML;

        // Set the timer
        var interval = setInterval(function() {
            if (seconds <= 0) {
                //(el.innerHTML = "level lapsed");
                $('#' + element).text('Time  Lapsed')

                clearInterval(interval);
                return;
            }
            var time = secondsToHms(seconds)
            $('#' + element).text(time)

            seconds--;
        }, 1000);
    }

    function secondsToHms(d) {
        d = Number(d);
        var day = Math.floor(d / (3600 * 24));
        var h = Math.floor(d % (3600 * 24) / 3600);
        var m = Math.floor(d % 3600 / 60);
        var s = Math.floor(d % 3600 % 60);

        var dDisplay = day > 0 ? day + (day == 1 ? " day, " : "D ") : "";
        var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : "H ") : "";
        var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : "M ") : "";
        var sDisplay = s > 0 ? s + (s == 1 ? " second" : "S ") : "";
        var t = dDisplay + hDisplay + mDisplay + sDisplay;
        return t;
        // console.log(t)
    }
</script>
<!--app-content open-->


<div class="main-content app-content mt-0">
    <div class="card card-body bg-custom-gr ">
        <div class="page-header pd-bottom">
            <h1 class="page-title">Dashboard </h1>
        </div>
        <!-- <div class="page-header pd-bottom">
         <h6 class="page-title">Timer : <span></span> </h6>
      </div> -->
    </div>
    <div class="side-app box-style">
        <!-- CONTAINER -->
        <div class="main-container container-fluid ">

            <div class="content-box">
                <div class="col-md-12">

                </div>
                <div class="row">

                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background: linear-gradient(87deg,#11CDEF,#1171EF);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php if ($userinfo->booster_achiever == 1) {
                                                                echo '<span class="badge badge-success"> Achieved</span>';
                                                            } else {
                                                                if ($userinfo->paid_status == 1) {
                                                                    $diff = strtotime('+7 days', strtotime($userinfo->topup_date)) - strtotime(date('Y-m-d H:i:s'));
                                                                    if ($diff > 0) {
                                                                        echo '<p class="timer-bg" style="color: #fff;">Booster Timer <br><span id="demo" style="color:#fff;font-weight:bold;"></span></p>';
                                                                        echo '<script> countdown("demo",' . $diff . ') </script>';
                                                                    }
                                                                } else {
                                                                    echo '<span class="badge badge-info"> Pending</span>';
                                                                }
                                                            } ?> </h5>
                                    <p class="title-box">Booster</p>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background: linear-gradient(87deg,#5E72E4,#825EE4);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $user['total_package']; ?> </h5>
                                    <p class="title-box">Subscription Package</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background: linear-gradient(87deg,#11CDEF,#1171EF);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $wallet_balance['wallet_balance']; ?> </h5>
                                    <p class="title-box">E-wallet</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $incomes = $this->config->item('incomes');
                    foreach ($incomes as $incKey => $inc) :
                        $table = "tbl_income_wallet";
                        $getBalance = $this->User_model->get_single_record($table, ['user_id' => $this->session->userdata['user_id'], 'type' => $incKey], 'ifnull(sum(amount),0) as balance');
                        $getBalanceToday = $this->User_model->get_single_record($table, ['user_id' => $this->session->userdata['user_id'], 'type' => $incKey, 'date(created_at)' => date('Y-m-d')], 'ifnull(sum(amount),0) as balance');

                    ?>
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                            <div class="dashboard-item">
                                <div class="dashboard-inner" style="background: rgb(17 28 67);">
                                    <div class="box_img">
                                    </div>
                                    <div class="box_content flex-custom">
                                        <h5 class="m-0 amount">Today:- <?php echo currency; ?><?php echo round($getBalanceToday['balance'], 2); ?></h5><br>
                                        <h5 class="m-0 amount">Total:- <?php echo currency; ?><?php echo round($getBalance['balance'], 2); ?></h5>
                                        <p class="title-box"><?php echo $inc; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>

                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background: linear-gradient(87deg,#F5365C,#F56036);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?><?php echo number_format($total_income['total_income'], 2); ?></h5>
                                    <p class="title-box">Total Earning</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background:linear-gradient(316deg, #FC5286, #FBAAA2);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?> <?php echo abs($total_withdrawal['balance']); ?></h5>
                                    <p class="title-box">Withdrawal Amount</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background:linear-gradient(316deg, #FC5286, #FBAAA2);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $allamount; ?></h5>
                                    <p class="title-box">All Amount</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background:linear-gradient(316deg, #FC5286, #FBAAA2);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $totalsum; ?></h5>
                                    <p class="title-box">pending Amount</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background:linear-gradient(316deg, #FC5286, #FBAAA2);">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?> <?php echo $usageamount; ?></h5>
                                    <p class="title-box">Usage Amount</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background:linear-gradient(to bottom, #0E4CFD, #6A8EFF)">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo currency; ?><?php echo ($income_balance['income_balance'] > 0) ? round($income_balance['income_balance'], 2) : 0; ?></h5>
                                    <p class="title-box">Available Balance</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner" style="background:linear-gradient(to bottom, #0E4CFD, #6A8EFF)">
                                <div class="box_img">
                                </div>
                                <div class="box_content flex-custom">
                                    <h5 class="m-0 amount"><?php echo $Totalteam['team']; ?></h5>
                                    <p class="title-box">Total Team</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                        <div class="dashboard-item">
                            <div class="dashboard-inner bg bg-warning">
                                <div class="box_content flex-custom">
                                    <div class="add-prom">
                                        <div class="add-left">
                                            <p class="title-box">Total Team</p>
                                            <h5 class="m-0 amount"><?php echo $Paidteam['team'] + $UnPaidteam['team'] ?></h5>
                                        </div>
                                        <div class="add-left">
                                            <p class="title-box">Paid Team</p>
                                            <h5 class="m-0 amount"><?php echo $Paidteam['team'] ?></h5>
                                        </div>
                                        <div class="add-right">
                                            <p class="title-box">UnPaid Team</p>
                                            <h5 class="m-0 amount"><?php echo $UnPaidteam['team'] ?></h5>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php if (registration == 1) { ?>
                        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3 d-grid">
                            <div class="dashboard-item">
                                <div class="dashboard-inner add-exp" style="background: linear-gradient(87deg,#5E72E4,#825EE4);">
                                    <div class="box_img">
                                    </div>
                                    <div class="box_content flex-custom">
                                        <div class="add-prom">
                                            <div class="add-left">
                                                <p class="title-box">Left Business</p>
                                                <h5 class="m-0 amount"><?php echo currency; ?><?php echo ($userinfo->leftBusiness > 0) ? round($userinfo->leftBusiness, 2) : 0; ?></h5>
                                            </div>
                                            <div class="add-right">
                                                <p class="title-box">Right Business</p>
                                                <h5 class="m-0 amount"><?php echo currency; ?><?php echo ($userinfo->rightBusiness > 0) ? round($userinfo->rightBusiness, 2) : 0; ?></h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>


            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6 col-lg-6 col-xl-6  box-bottom-m ">
                <div class="card mt-0 mb-0 bg-info add-img">
                    <div class="card-header justify-content-between">
                        <h5 class="card-title mb-0">Total Direct Team</h5>
                        <h3 class="fw-normal mb-0">
                            <?php echo  $paid_directs['paid_directs'] + $free_directs['free_directs']; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0 custombx">
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3 ">
                                    <span class="badge badge-dot bg-success me-2"></span>
                                    Direct Team
                                </div>
                                <div class="display_flex gap-3">
                                    <span class="fw-semibold">Active - <?php echo $paid_directs['paid_directs']; ?></span>
                                    <span class="fw-semibold">Inactive - <?php echo $free_directs['free_directs']; ?></span>
                                </div>
                            </li>
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-danger me-2"></span>
                                    Total Direct Business
                                </div>
                                <div class="display_flex gap-3">
                                    <span class="fw-semibold">Total - <?php echo currency . $directBusiness['directBusiness']; ?></span>
                                </div>
                            </li>
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-danger me-2"></span>
                                    Direct Business
                                </div>
                                <div class="display_flex gap-3">
                                    <span class="fw-semibold">Left - <?php echo currency . $directBusinessL['directBusinessL']; ?></span>
                                    <span class="fw-semibold">Right - <?php echo currency . $directBusinessR['directBusinessR']; ?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- <div class="col-md-6 col-lg-6 col-xl-6  box-bottom-m ">
                  <div class="card mt-0 mb-0 bg-success">
                     <div class="card-header justify-content-between">
                        <h5 class="card-title mb-0">Total Downline Team </h5>
                        <h3 class="fw-normal mb-0">
                           <?php // echo ($LeftPaidteam['team'] + $RightPaidteam['team'] + $RightUnPaidteam['team'] + $LeftUnPaidteam['team']);
                            ?>
                        </h3>
                     </div>
                     <div class="card-body">
                        <ul class="p-0 m-0 custombx">

                           <li class="mb-3 display_flex justify-content-between">
                              <div class="d-flex align-items-center lh-1 me-3">
                                 <span class="badge badge-dot bg-danger me-2"></span>
                                 Downline Team
                              </div>
                              <div class="display_flex gap-3">
                                 <span class="fw-semibold"> Active - <?php // echo $LeftPaidteam['team'] + $RightPaidteam['team'];
                                                                        ?></span>
                                 <span class="fw-semibold"> Inactive - <?php // echo $LeftUnPaidteam['team'] + $RightUnPaidteam['team'];
                                                                        ?></span>
                              </div>
                           </li>

                           <li class="mb-3 display_flex justify-content-between">
                              <div class="d-flex align-items-center lh-1 me-3">
                                 <span class="badge badge-dot bg-danger me-2"></span>
                                 Total Team Business
                              </div>
                              <div class="display_flex gap-3">
                                 <span class="fw-semibold"> Total - <?php // echo currency . ($LeftBusiness['teamBusiness'] + $RightBusiness['teamBusiness']);
                                                                    ?></span>
                              </div>
                           </li>


                           <li class="mb-3 display_flex justify-content-between">
                              <div class="d-flex align-items-center lh-1 me-3">
                                 <span class="badge badge-dot bg-danger me-2"></span>
                                 Team Business
                              </div>
                              <div class="display_flex gap-3">
                                 <span class="fw-semibold">Left - <?php // echo currency . $LeftBusiness['teamBusiness'];
                                                                    ?></span>
                                 <span class="fw-semibold">Right - <?php // echo currency . $RightBusiness['teamBusiness'];
                                                                    ?></span>
                              </div>
                           </li>
                        </ul>
                     </div>
                  </div>
               </div> -->
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header pd-bottom">
                    <h1 class="page-title">Plan </h1>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body">
                            <video controls class="w-100">
                                <source src="<?php echo base_url('uploads/plan.mp4'); ?>" type="video/mp4">
                                <source src="<?php echo base_url('uploads/plan.mp4'); ?>" type="video/ogg">
                            </video>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body">
                            <a href="<?php echo base_url('uploads/b-plan.pdf'); ?>" class="btn btn-primary" download>Business Plan</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12" data-bound>
                <div class="bx">
                    <marquee behavior="" direction="left" onMouseOver="this.stop()" onMouseOut="this.start()" class="work-image">
                        <!-- <img src="<?php //echo logo;
                                        ?>" alt="">
                     <a href="<?php //echo logo;
                                ?>" class="popup-btn" target="_blank">view</a> -->
                        <?php
                        foreach ($achiever as $key => $ach) {

                        ?>
                            <img src="<?php echo base_url('uploads/' . $ach['image']); ?>" height="100px" width="100px">
                            <!-- <td><?php //echo $ach['name'];
                                        ?></td> -->
                        <?php

                        }

                        ?>
                    </marquee>

                </div>

            </div>


            <div class="col-md-6 col-lg-6 col-xl-6 box-bottom-m">
                <div class="card mt-0 mb-0 bg-success">
                    <div class="earn-thumb">
                    </div>
                    <div class="card-header">
                        <h5 class="card-title mb-2 text-center m-auto p-0">User Details</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0 custombx">
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-success me-2"></span>
                                    Name
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="fw-semibold"><?php echo $userinfo->name ?> </span>
                                </div>
                            </li>
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-success me-2"></span>
                                    User ID
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="fw-semibold"><?php echo $userinfo->user_id ?> </span>
                                </div>
                            </li>
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-success me-2"></span>
                                    Package
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="fw-semibold"><?php echo $userinfo->total_package ?> </span>
                                </div>
                            </li>
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-success me-2"></span>
                                    Activation Date
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="fw-semibold"><?php echo $userinfo->topup_date ?> </span>
                                </div>
                            </li>
                            <li class="mb-3 display_flex justify-content-between">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-danger me-2"></span>
                                    Status
                                </div>
                                <div class="d-flex gap-3">
                                    <span class="fw-semibold"><?php echo ($userinfo->paid_status > 0) ? '<span class="text-success">active</span>' : '<span class="text-danger">inactive</span>'; ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 box-bottom-m">
                <div class="card mt-0 mb-0 bg-info">
                    <div class="earn-thumb">
                    </div>
                    <div class="card-header">
                        <h5 class="card-title m-auto">Latest News</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0 custombx">
                            <li class="mb-3 w-100">
                                <div class="d-flex align-items-center lh-1 me-3">
                                    <span class="badge badge-dot bg-success me-2"></span>
                                    <marquee direction="left" scrollamount="2">
                                        <?php foreach ($news as $n) : ?>
                                            <p class="" style="color:#fff"><?php echo $n['news']; ?></p>
                                        <?php endforeach; ?>
                                    </marquee>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <?php if (registration == 1) { ?>
            <div class="col-md-6 box-bottom-m">
                <div class="earn-item bg-info add-img">

                    <h3>Left Referal Link</h3>

                    <div class="display_flex flex-direction reffral-code w-100 trans__adsd">
                        <input style="width:100%;" type="text" id="linkTxt" value="<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=L'); ?>" readonly class="form-control custom-form">
                        <button id="btnCopy" iconcls="icon-save" class="btn d-block btn-lg copy_btns">
                            Copy
                        </button>
                        <div class="social_icon mt-4 mt-md-0">
                            <a href="https://wa.me/?text=<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=L'); ?>" target="_blank">
                                <img src="<?php echo base_url('uploads/wp-icon.png'); ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 box-bottom-m">
                <div class="earn-item bg-success  add-img">

                    <h3>Right Referal Link</h3>

                    <div class="display_flex flex-direction reffral-code w-100 trans__adsd">
                        <input style="width:100%;" type="text" id="linkTxt2" value="<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=R'); ?>" readonly class="form-control custom-form">
                        <button id="btnCopy2" iconcls="icon-save" class="btn d-block btn-lg copy_btns">
                            Copy
                        </button>
                        <div class="social_icon mt-4 mt-md-0">
                            <a href="https://wa.me/?text=<?php echo base_url('register/?sponser_id=' . $userinfo->user_id . '&position=R'); ?>" target="_blank">
                                <img src="<?php echo base_url('uploads/wp-icon.png'); ?>" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-md-12 box-bottom-m">
                <div class="earn-item ">

                    <h3>Referal Link</h3>

                    <div class="display_flex flex-direction reffral-code w-100 trans__adsd">
                        <input style="width:100%;  float:left" type="text" id="linkTxt" value="<?php echo base_url('register/?sponser_id=' . $userinfo->user_id); ?>" readonly class="form-control custom-form">
                        <button id="btnCopy" iconcls="icon-save" class="btn d-block btn-lg copy_btns">
                            Copy link
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="card cstm-card card-body mt-0">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable">
                        <thead class="main_table">
                            <tr>
                                <th>#</th>
                                <th>points</th>
                                <th>Rewards</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rewards =  $this->config->item('awardsAndrewards');
                            foreach ($rewards as $key => $value) { ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $value['points']; ?></td>
                                    <td><?php echo $value['reward']; ?></td>

                                </tr>

                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="card cstm-card card-body mt-0">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dataTable">
                        <thead class="main_table">
                            <tr>
                                <th>#</th>
                                <th>match</th>
                                <th>amount</th>
                                <th>simple_match</th>
                                <th>reward</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rewards =  $this->config->item('rewardsArray');
                            foreach ($rewards as $key => $value) { ?>
                                <tr>
                                    <td><?php echo $key ?></td>
                                    <td><?php echo $value['match']; ?></td>
                                    <td><?php echo $value['amount']; ?></td>
                                    <td><?php echo $value['simple_match']; ?></td>

                                    <td><?php echo $value['reward']; ?></td>


                                </tr>

                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-12 box-bottom-m table-coins">
            <div class="card">
                <div class="invest-heading table-club mb-4 mt4">
                    <h2>My Millionaire Club</h2>
                </div>
                <div class="card-body padd-zero">
                    <div class="table-responsive">
                        <div id="advance-1_wrapper" class="dataTables_wrapper">
                            <table class="table display dataTable table-bordered table-striped" id="advance-1" role="grid" aria-describedby="advance-1_info">
                                <thead class="coins-table">
                                    <tr role="row">
                                        <th class="sorting_asc" style="width: 20px;">#</th>
                                        <th class="sorting_asc" style="width: 20px;">Designation</th>
                                        <th class="sorting_asc" style="width: 20px;">A leg</th>
                                        <th class="sorting_asc" style="width: 20px;">B leg</th>
                                        <th class="sorting_asc" style="width: 20px;">Panacea Points</th>
                                        <th class="sorting_asc" style="width: 20px;">Time Within</th>
                                        <th class="sorting_asc" style="width: 20px;">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="coins-td">
                                    <?php
                                    $team_income = $this->config->item('club_income');
                                    $timer_set = false;

                                    foreach ($team_income as $key => $teaminc) :
                                        $achieved = false;
                                        $remaining_time = 0;
                                        $is_expired = false;

                                        if (!$timer_set) {
                                            // $reinvest = $this->User_model->get_records('tbl_reinvestment_details', ['user_id' => $this->session->userdata['user_id']], '*');
                                            // $achievers = $this->User_model->get_records('tbl_activation_details', ['user_id' => $this->session->userdata['user_id']], '*');
                                            $reinvest = $this->User_model->get_records('tbl_reinvestment_details', "user_id = '" . $this->session->userdata['user_id'] . "' AND package='" . $teaminc['Panacea_Points'] . "'", '*');
                                            $achievers = $this->User_model->get_records('tbl_activation_details', "user_id = '" . $this->session->userdata['user_id'] . "'ORDER By id ASC Limit 1", '*');

                                            if (!empty($reinvest)) {
                                                foreach ($reinvest as $re) {
                                                    $dayswork = $re['days'] + $teaminc['Time_Within'];
                                                    $target_time = strtotime($re['created_at'] . ' + ' . $dayswork . ' days');
                                                    //   $target_time = strtotime($re['created_at'] . ' + ' . $teaminc['Time_Within'] . ' days') + ($re['days'] * 86400);
                                                    $remaining_time = $target_time - time();
                                                    if ($remaining_time > 0) {
                                                        $achieved = true;
                                                        $timer_set = true;
                                                        break;
                                                    } else {
                                                        $is_expired = true;
                                                    }
                                                }
                                            }

                                            if (!$achieved && !empty($achievers)) {
                                                foreach ($achievers as $r) {
                                                    $target_time = strtotime($r['created_at'] . ' + ' . $teaminc['Time_Within'] . ' days');
                                                    $remaining_time = $target_time - time();
                                                    if ($remaining_time > 0) {
                                                        $achieved = true;
                                                        $timer_set = true;
                                                        break;
                                                    } else {
                                                        $is_expired = true;
                                                    }
                                                }
                                            }
                                        }


                                    ?>
                                        <tr>
                                            <td>
                                                <div class="td-content"><?php echo $key; ?></div>
                                            </td>
                                            <td>
                                                <div class="td-content"><?php echo $teaminc['Designation']; ?></div>
                                            </td>
                                            <td>
                                                <div class="td-content"><?php echo $teaminc['A_leg']; ?></div>
                                            </td>
                                            <td>
                                                <div class="td-content"><?php echo $teaminc['B_leg']; ?></div>
                                            </td>
                                            <td>
                                                <div class="td-content"><?php echo $teaminc['Panacea_Points']; ?></div>
                                            </td>
                                            <td>
                                                <div class="td-content"><?php echo $teaminc['Time_Within']; ?></div>
                                            </td>
                                            <td>
                                                <?php if ($is_expired) : ?>
                                                    Expired
                                                <?php elseif ($achieved) : ?>
                                                    <p class="text-light" id="demo<?php echo $key; ?>"></p>
                                                    <script>
                                                        countdown("demo<?php echo $key; ?>", <?php echo $remaining_time; ?>);
                                                    </script>
                                                <?php else : ?>
                                                    Pending
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
    <!-- ROW-4 END -->
</div>
<!-- CONTAINER END -->
</div>
<!--app-content close-->
<?php if ($popup['status'] == 0) : ?>
    <div class="modal fade justify-content-center" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $popup['caption'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="mhmwvk">X</button>
                </div>
                <div class="modal-body">
                    <img src="<?php echo base_url('uploads/' . $popup['media']) ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php require_once 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#myModal').modal('show');
    });

    $(document).on('click', '#btnCopy', function() {
        var copyText = document.getElementById("linkTxt");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        toastr.success('<span class="text-success">Copied!</span>')
    })
    $(document).on('click', '#btnCopy2', function() {
        var copyText = document.getElementById("linkTxt2");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        toastr.success('<span class="text-success">Copied!</span>')
    })

    // const desktopData = () => {
    //    const url = "<?php //echo base_url('Dashboard/AjaxController/jsonData');
                        ?>"
    //    fetch(url, {
    //          method: "GET",
    //          headers: {
    //             "X-Requested-With": "XMLHttpRequest"
    //          }
    //       })
    //       .then(response => response.json())
    //       .then(response => {
    //          console.log(response)
    //          document.getElementById('paidDirects').innerHTML = 'Active: ' + response.paidDirects['paidDirects']
    //          document.getElementById('freeDirects').innerHTML = 'Inactive: ' + response.freeDirects['freeDirects']
    //          document.getElementById('paidTeam').innerHTML = 'Free Team: ' + response.freeTeam['team']
    //          document.getElementById('freeTeam').innerHTML = 'Paid Team: ' + response.paidTeam['team']
    //          document.getElementById('leftPaidTeam').innerHTML = 'Paid L Team: ' + response.leftPaidTeam['team']
    //          document.getElementById('leftTeam').innerHTML = 'Free L Team: ' + response.leftfreeTeam['team']
    //          document.getElementById('rightPaidTeam').innerHTML = 'Paid R Team: ' + response.rightPaidTeam['team']
    //          document.getElementById('rightTeam').innerHTML = 'Free R Team: ' + response.rightfreeTeam['team']
    //       })
    // }

    // desktopData()
</script>
