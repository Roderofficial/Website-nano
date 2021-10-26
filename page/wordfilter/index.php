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
   
    <title>Word Filter | NANO</title>

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
        <h1 class="h2">word filter</h1>
      </div>

      
    </main>
  </div>
</div>


    <?php require($_SERVER['DOCUMENT_ROOT'].'/page/addons/scripts.php') ?>
  </body>
</html>
