<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://kit.fontawesome.com/a2f0d5a1bb.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="<?php echo base_url() ?>/MainAssets/UserAssets/img/logo1.png" type="image/x-icon">
  <link rel="stylesheet" href="<?php echo base_url() ?>/MainAssets/UserAssets/scss/style.css">
  <title><?php echo title; ?></title>
</head>

<body>
  <!-- header -->
  <section id="header" class="header">
    <div class="header-inner-main">
      <div class="column-1">
        <div class="toggle">
          <i class="fa-solid fa-bars toggle-bar"></i>
          <i class="fa-solid fa-arrow-right right-arrow"></i>
          <i class="fa-solid fa-xmark close"></i>
        </div>
      </div>
      <div class="column-2">
        <div class='user-profile'>
          <div class="li"><img src="<?php echo base_url() ?>/MainAssets/UserAssets/img/user-1.jpg">
            <div class='header-dropdown'>
              <div class='after'></div>
              <div class='dropdown-content'>
                <li>
                  <span class="dot-icon"><i class="fa-solid fa-circle-dot"></i></span>Logout
                </li>
                <li>
                  <span class="dot-icon"><i class="fa-solid fa-circle-dot"></i></span>View Profile
                </li>


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- sidebar -->
  <section id="sidebar" class="sidebar">
    <!-- <div class="logo"> -->
    <img class="logo" src="<?php echo base_url() ?>/MainAssets/UserAssets/img/logo1.png" alt="no-logo-image">
    <!-- </div> -->
    <div class="sidebar-content">
      <div class="accordion" id="accordionExample">
        <div class="accordion-item">
          <div class="accordion-header">
            <div class="accordion-button drop-btn" type="button">
              <div class="drop-icon">
                <i class="fa-solid fa-house icon"></i>
              </div>
              <div class="drop-title">
                <span class="title"><a href="<?php echo base_url('User') ?>">Dashboard</a></span>
              </div>
            </div>
          </div>

        </div>
        <div class="accordion-item">
          <div class="accordion-header" id="headingOne">
            <div class="accordion-button collapsed drop-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <div class="drop-icon">
                <i class="fa-solid fa-users icon"></i>
              </div>
              <div class="drop-title">
                <span class="title">User Details</span>
              </div>
              <span class="arrow-icon"><i class="fa-solid fa-angle-right i-right"></i></span>
            </div>
          </div>
          <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body drop-content">
              <li><a href="<?php echo base_url('activation')?>">Activate Account</a></li>
              <li><a href="/">Paid Members</a></li>
              <li><a href="/">Unpaid Members</a></li>
              <li><a href="/">View Today Joining</a></li>
              <li><a href="/">Reward Achive Histort</a></li>
              <li><a href="/">All Members</a></li>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <div class="accordion-header" id="headingTwo">
            <div class="accordion-button collapsed drop-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              <div class="drop-icon">
                <i class="fa-brands fa-codepen icon"></i>
              </div>
              <div class="drop-title">
                <span class="title">All Data</span>
              </div>
              <span class="arrow-icon"><i class="fa-solid fa-angle-right i-right"></i></span>
            </div>
          </div>
          <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body drop-content">
              <li><a href="/">All Members</a></li>
              <li><a href="/">Paid Members</a></li>
              <li><a href="/">Unpaid Members</a></li>
              <li><a href="/">View Today Joining</a></li>
              <li><a href="/">Reward Achive Histort</a></li>
              <li><a href="/">All Members</a></li>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <div class="accordion-header" id="headingThree">
            <div class="accordion-button collapsed drop-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              <div class="drop-icon">
                <i class="fa-solid fa-house icon"></i>
              </div>
              <div class="drop-title">
                <span class="title">New Tab</span>
              </div>
              <span class="arrow-icon"><i class="fa-solid fa-angle-right i-right"></i></span>
            </div>
          </div>
          <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body drop-content">
              <li><a href="/">All Members</a></li>
              <li><a href="/">Paid Members</a></li>
              <li><a href="/">Unpaid Members</a></li>
              <li><a href="/">View Today Joining</a></li>
              <li><a href="/">Reward Achive Histort</a></li>
              <li><a href="/">All Members</a></li>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" id="headingNew">
            <div class="accordion-button collapsed drop-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNew" aria-expanded="false" aria-controls="collapseNew">
              <div class="drop-icon">
                <i class="fa-solid fa-house icon"></i>
              </div>
              <div class="drop-title">
                <span class="title">Compos</span>
              </div>
              <span class="arrow-icon"><i class="fa-solid fa-angle-right i-right"></i></span>
            </div>
          </div>
          <div id="collapseNew" class="accordion-collapse collapse" aria-labelledby="headingNew" data-bs-parent="#accordionExample">
            <div class="accordion-body drop-content">

              <li><a href="card.php">Card</a></li>
              <li><a href="table.php">Table</a></li>
              <li><a href="form.php">Form</a></li>

            </div>
          </div>
        </div>


      </div>
    </div>
  </section>