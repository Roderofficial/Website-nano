<?php
@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
require($_SERVER['DOCUMENT_ROOT'] . '/api/guild.php');
$data = get_guild($_SESSION['selected_guild']);
$guild_info = json_decode($data['body'], true);
//var_dump($guild_info);
?>
<!doctype html>
<html lang="en">

<head>

  <title>Dashboard | NANO</title>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/header.php') ?>





  <!-- Custom styles for this template -->
  <link href="/page/global.css" rel="stylesheet">
</head>

<body>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/navbar.php') ?>

  <div class="container-fluid">
    <div class="row">
      <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/sidebar.php') ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>(Updated hourly)
        </div>

        <!--CARD HEAD -->
        <div class="row">
          <div class="col-md-4 mt-2">
            <div class="card text-white bg-primary">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-users"></i> Members:</h5>
                <p class="card-text h1" id="users_label"><i class="fas fa-cog fa-spin"></i> loading...</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mt-2">
            <div class="card text-white bg-success">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-plug"></i> Members online:</h5>
                <p class="card-text h1" id="online_users_label"><i class="fas fa-cog fa-spin"></i> loading...</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mt-2">
            <div class="card text-white bg-dark">
              <div class="card-body">
                <h5 class="card-title"><i class="fas fa-clock"></i> Time:</h5>
                <p class="card-text h1" id="time_label"><i class="fas fa-cog fa-spin"></i> loading...</p>
              </div>
            </div>
          </div>



        </div>
        <!-- END CARD HEAD -->
        <!-- STATS -->
        <div class="card" style="margin-top:20px;">
          <div class="card-header"><b>Statistics</b> (Last 24 hours)</div>
          <div class="card-body">
            <div id="mainchart">
              <div class="text-center">
                <div class="spinner-border" role="status"></div>
                <p style="margin-bottom:0px;">Loading...</p>
              </div>
            </div>

          </div>
        </div>

        <!-- END STATS -->


      </main>
    </div>
  </div>


  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/scripts.php') ?>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
  <script src="index.js"></script>
</body>

</html>