<?php
@session_start();
if (isset($_SESSION["access_token"])) {
  header("Location: /");
  exit();
}

/* Home Page
* The home page of the working demo of oauth2 script.
* @author : MarkisDev
* @copyright : https://markis.dev
*/

# Enabling error display
error_reporting(E_ALL);
ini_set('display_errors', 1);


# Including all the required scripts for demo
require __DIR__ . "/includes/functions.php";
require __DIR__ . "/includes/discord.php";
require __DIR__ . "/config.php";

# ALL VALUES ARE STORED IN SESSION!
# RUN `echo var_export([$_SESSION]);` TO DISPLAY ALL THE VARIABLE NAMES AND VALUES.
# FEEL FREE TO JOIN MY SERVER FORa ANY QUERIES - https://join.markis.dev
$auth_url = url($client_id, $redirect_url, $scopes);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NANO | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link href="/assets/fontawesome/css/all.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="/assets/darkmode/css/mdb.dark.min.css" />
  <!-- BOOTSTRAP SELECT -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="hold-transition login-page">

  <!-- /.login-box -->
  <div class="container" style="height: 100vh;">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-md-5 col-sm-8">
        <div class="card border-primary" style=" margin:auto;">
          <div class="card-body">
            <img src="/dist/img/auth.svg" style="width:100%;" />
            <h3 class="card-title" style="text-align:center;"><b>NANO</b> Control panel</h3>
            <a href="<?= $auth_url ?>" class="btn btn-block btn-primary btn-lg" style="width:100%;">
              <i class="fab fa-discord mr-2"></i> Log In with Discord
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <!-- Bootstrap -->
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>