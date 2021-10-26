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
   
    <title>RANDOM | NANO</title>

    <?php require($_SERVER['DOCUMENT_ROOT'].'/page/addons/header.php') ?>
    


    
    <!-- Custom styles for this template -->
    <link href="/page/global.css" rel="stylesheet">
  </head>
  <body>
    
<?php require($_SERVER['DOCUMENT_ROOT'].'/page/addons/navbar.php') ?>

<div class="container-fluid">
  <div class="row">
    <?php require($_SERVER['DOCUMENT_ROOT'].'/page/addons/sidebar.php') ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
          <i class="fas fa-dice"></i>
          Losowanie użytkowników
        </h1>
      </div>

      <!-- WINNER CARD -->
      <div class="card">
        <h5 class="card-header">Wylosowana osoba</h5>
        <div class="card-body">
          <div class="text-center">
            <img src="\dist\img\guest_avatar.png" class="rounded" alt="Avatar uzytkownika">
            <h2 style="margin-top:20px;">USERNAME</h2>
          </div>
        </div>
      </div>

      <!-- SETTINGS CARD -->
      <div class="card" style="margin-top:30px;">
        <h5 class="card-header">Konfiguracja losowania</h5>
        <div class="card-body">

          <form action="random.php" method="POST">
            <div class="row g-3">
              <div class="col">
                <label class="form-label">Zaliczone role</label>
                <br />
                <select class="selectpicker" multiple data-live-search="true" style="width:100%;" name="include[]">
                  <?php echo guild_roles_list($_SESSION['selected_guild']); ?>
                </select>
              </div>
              <div class="col">
                <label class="form-label">Wykluczone role</label>
                <br />
                <select class="selectpicker" multiple data-live-search="true" style="width:100%;" name="exclude[]">
                  <?php echo guild_roles_list($_SESSION['selected_guild']); ?>
                </select>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary">Losuj</button>
              </div>
            </div>
          </form>


        </div>
      </div>


      
    </main>
  </div>
</div>


    <?php require($_SERVER['DOCUMENT_ROOT'].'/page/addons/scripts.php') ?>
  </body>
</html>
