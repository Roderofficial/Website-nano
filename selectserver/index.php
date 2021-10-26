<?php
@SESSION_START();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
//END SECURE
require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/api/guild.php');
if (isset($_SESSION['selected_guild'])) {
  unset($_SESSION['selected_guild']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Select server | NANO</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link href="/assets/fontawesome/css/all.css" rel="stylesheet">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="/assets/darkmode/css/mdb.dark.min.css" />

</head>

<body class="hold-transition login-page">
  <div class="container" style="height: 100vh;">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-md-5 col-sm-8">
        <!-- CARD-->
        <div class="card">
          <div class="card-body login-card-body">
            <!-- PROFILE CARD -->
            <div class="card bg-dark" style="margin-bottom:10px;">
              <div class="card-body">
                <?php
                if ($_SESSION["user"]["avatar"] != null) {
                  echo '
            <div class="text-center">
            <img src="https://cdn.discordapp.com/avatars/' . $_SESSION["user"]["id"] . '/' . $_SESSION["user"]["avatar"] . '.png" alt="Avatar użytkownika" style="border-radius: 50%;">
            </div>';
                } else {
                  echo '<img src="/dist/img/select_server.svg" style="width:75%; margin:auto; padding-bottom:20px; display:block; padding-top:10px;" />';
                }

                ?>
                <br />
                <p style="text-align:center; margin-bottom:0;">Hello <b><?php echo $_SESSION["user"]["username"] ?></b>. Choose the server you want to manage!</p>

              </div>
            </div>

            <!-- TABELA -->
            <table class="table">
              <tbody>
                <?php
                $server_count = 0;
                for ($i = 0; $i < sizeof($_SESSION['guilds']); $i++) {
                  if ($_SESSION['guilds'][$i]['owner'] == true || $_SESSION['guilds'][$i]['permissions'] == "2147483647") {
                    $server_count = $server_count + 1;
                    #generate avatar
                    if ($_SESSION['guilds'][$i]['icon'] != null) {
                      $guild_icon_url =  'https://cdn.discordapp.com/icons/' . $_SESSION['guilds'][$i]['id'] . '/' . $_SESSION['guilds'][$i]['icon'] . '.png?size=32';
                      $guild_icon = '<img src="' . $guild_icon_url . '" style="border-radius:50%; margin-right: 10px;">';
                    } else {
                      $guild_icon = null;
                    }

                    echo '<tr><td style="word-break: break-word;">';
                    echo $guild_icon;
                    echo $_SESSION['guilds'][$i]['name'];
                    #echo "<td>";

                    #echo $_SESSION['guilds'][$i]['id'];
                    echo "</td><td>";
                    if (guild_access($_SESSION['guilds'][$i]['id']) == true) {
                      echo '<a href="/selectserver/select.php?id=' . $_SESSION['guilds'][$i]['id'] . '" class="btn btn-success btn-block btn-sm" style="width:100%;">SELECT</button>';
                    } else {
                      echo '<a href="' . $config['bot_invite_url'] . '" class="btn btn-block btn-secondary btn-sm" style="width:100%;">INVITE BOT</button>';
                    }
                    echo "</td>";
                    echo "</tr></td>";
                  }
                }
                #check if no server exist and send info
                if ($server_count == 0) {
                  echo "<tr><td>";
                  echo "<center>You don't have servers that you can manage!</center>";
                  echo "</td>";
                  echo "</tr>";
                }


                ?>
                <tr>
                  <td colspan=2><a href="/login/logout.php" class="btn btn-block btn-danger" style="width:100%;">Logout</a></td>
                </tr>
              </tbody>
            </table>


            <!-- KONIEC TABELA -->


          </div>
          <!-- /.login-card-body -->
        </div>
        <!-- END CARD -->
      </div>
    </div>
  </div>
  <!-- /.login-box -->

  <!-- Bootstrap -->
  <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>