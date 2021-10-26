<?php
@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
require($_SERVER['DOCUMENT_ROOT'] . '/api/guild.php');
require("functions.php");
$data = get_guild($_SESSION['selected_guild']);
$guild_info = json_decode($data['body'], true);
//var_dump($guild_info);
?>
<!doctype html>
<html lang="en">

<head>

  <title>Settings | NANO</title>

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
          <h1 class="h2"><i class="fas fa-cog"></i> Settings</h1>
        </div>
        <form id="settings">
          <!-- PREFIX CARD -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="fas fa-bell"></i> Prefix</h5>
              <p class="card-text">You can select a string before giving the command to the bot. Default: #</p>
              <input class="form-control" name="prefix" type="text" placeholder="Prefix" min="1" value="<?php echo get_prefix($_SESSION['selected_guild']); ?>" required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary" style="float:right; margin-top:20px;">SAVE</button>
        </form>
      </main>
    </div>
  </div>


  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/scripts.php') ?>
  <script src="settings.js"></script>
</body>

</html>