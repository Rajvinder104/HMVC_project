<?php include_once 'header.php'; ?>
<style>
  button {
    margin: 0;
    padding: 0;
    width: 5em;
    height: 2.5em;
    border: 2px solid black;
    display: inline-block;
    vertical-align: middle;
    text-align: center;
    border-radius: 1.2em;
    position: relative;
    transition: background .15s ease-in-out;
  }

  button:after {
    content: "";
    position: absolute;
    height: 1.8em;
    width: 1.8em;
    border-radius: 50%;
    top: .075em;
    border: 1px solid #777;
    transition: left .15s ease-in-out;
    will-change: left;
  }

  label {
    display: block;
    margin-bottom: .25em;
  }

  button[aria-pressed="false"] {
    background: #ccc;
  }

  button[aria-pressed="false"]:after {
    background: #eee;
    left: 2.5em;
  }

  button[aria-pressed="true"] {
    background: #8BC34A;
  }

  button[aria-pressed="true"]:after {
    background: #fff;
    left: .1em;
  }

  .toggle {
    width: 135px;
  }
</style>
<div class="main-content app-content mt-4">
  <div class="page-content">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <section class="content-header">
            <span class="">
              <?php echo $header; ?>
            </span>
          </section>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">
              <?php echo $header; ?>
            </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div>

        <!-- switch ------------------------------------------------------------------->
        <div class="row mb-2">
          <div class="col-sm-3">
            <div class="toggle">
              <!-- <label for="switch" class="switch">Now Withdarw is <?php echo ($admin['withdraw_status'] == 1 ? 'OFF' : 'ON') ?></label> -->
              <button role="switch" value="test val"
                aria-pressed="<?php echo ($admin['withdraw_status'] == 1 ? 'false' : 'true') ?>" aria-checked="true"
                id="switch" aria-describedby="state"></button>
              <span id="state" aria-live="assertive" aria-atomic="true">
                <?php echo ($admin['withdraw_status'] == 1 ? 'OFF' : 'ON') ?>
              </span>
              <input type="hidden" aria-hidden="true" value="ON">
            </div>
          </div>
        </div>
        <!-- switch ------------------------------------------------------------------->

      </div>
      <input class="form-control" type="hidden" id="statusValue" style="width: 100px;">
    </div>
  </div>
</div>
</div>
<?php include_once 'footer1.php'; ?>
<script>
  async function ceheckstatus() {
    var url = "<?php echo base_url('Auth/Settings/getStatus/'); ?>";
    $.get(url, function (res) {
      document.getElementById("statusValue").value = res.data.withdraw_status;
    }, 'json');
  }
</script>
<script>

  var toggles = document.querySelectorAll(".toggle");

  for (i = 0, l = toggles.length; i < l; i++) {
    var tog = toggles[i];
    tog.addEventListener("click", async function (e) {
      await ceheckstatus();

      alert('Are you sure for this action')
      var dataName = document.getElementById('statusValue').value;
      if (dataName == 0) {
        var sendCode = "true";
      } else {
        var sendCode = "false";
      }

      var el = this.querySelector("button"),
        state = el.getAttribute("aria-pressed") == sendCode,
        val = state ? "OFF" : "ON",
        realInput = this.querySelector("input")
      if (state == true) {
        var status = 1;
      } else {
        var status = 0;
      }
      var url = "<?php echo base_url('Auth/Settings/WithdrawStatus/'); ?>" + status;
      $.get(url, function (res) {
      }, 'json')

      el.setAttribute("aria-pressed", state ? "false" : "true");
      el.setAttribute("aria-checked", state ? "false" : "true");

      el.nextElementSibling.innerHTML = val;
      realInput.value = val;
    });
  }
</script>