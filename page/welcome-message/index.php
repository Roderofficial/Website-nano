<?php
@session_start();
//SECURE 
require($_SERVER['DOCUMENT_ROOT'] . '/api/secure.php');
require_login();
require_guild();
//END SECURE
require($_SERVER['DOCUMENT_ROOT'] . '/api/guild.php');
require('functions.php');
$data = get_guild($_SESSION['selected_guild']);
$guild_info = json_decode($data['body'], true);
$module_info = data_preview();
//var_dump($guild_info);

?>
<!doctype html>
<html lang="en">

<head>

  <title>Wiadomości powitalne | NANO</title>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/header.php') ?>






  <!-- Custom styles for this template -->
  <link href="/page/global.css" rel="stylesheet">

  <!-- EMBED -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.4.1/highlight.min.js"></script>
  <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/codemirror.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/codemirror.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/mode/javascript/javascript.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/theme/material-darker.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/scroll/simplescrollbars.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/scroll/simplescrollbars.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/edit/matchbrackets.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/fold/brace-fold.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/fold/foldgutter.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/fold/foldgutter.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/fold/foldcode.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/lint/json-lint.min.js"></script>
  <script src="https://unpkg.com/jsonlint@1.6.3/web/jsonlint.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/lint/lint.min.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/lint/lint.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.58.3/addon/lint/lint.min.js"></script>
  <link rel="stylesheet" href="/assets/embed/css/index.css" />
  <script src="/assets/embed/libs/color-picker/color-picker.min.js"></script>
  <link rel="stylesheet" href="/assets/embed/libs/color-picker/color-picker.min.css">
  <script src="/assets/embed/js/components.js"></script>
  <script src="/assets/embed/js/script.js"></script>

</head>

<body>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/navbar.php') ?>

  <div class="container-fluid">
    <div class="row">
      <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/sidebar.php') ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2"><i class="fas fa-comment"></i> Wiadomości powitalne</h1>
        </div>

        <!-- CHANNEL WELCOME MESSAGE CARD -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Wiadomości powitalne na kanale</h5>
            <hr />

            <!-- BUTTON SETTINGS -->
            <div class="row">
              <div class="col-md-6">
                <label>Stan modułu</label><br />
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-success active">
                    <input type="radio" name="remove_logs_enable" id="option1" autocomplete="off" value="1" <?php echo checked($module_info['remove_logs_enable'], 1); ?>> Włączony
                  </label>
                  <label class="btn btn-danger">
                    <input type="radio" name="remove_logs_enable" id="option2" value="0" autocomplete="off" <?php echo checked($module_info['remove_logs_enable'], 0) ?>> Wyłączony
                  </label>
                </div>
              </div>
              <div class="col-md-6">
                <label>Wybierz kanał tekstowy</label>
                <select class="custom-select form-control" name="remove_logs_channel" id="remove_logs_channel">
                  <option value="">Open this select menu</option>
                  <?php echo guild_text_channels_list($_SESSION['selected_guild'], $module_info['remove_logs_channel']); ?>
                </select>
              </div>
              <div class="col-12" style="margin-top:30px;">
                <h5>Edytor wiadomości </h5>
                <hr />

                <!-- EMBED EDITOR -->
                <?php require($_SERVER['DOCUMENT_ROOT']."/page/addons/embed.php") ?>

                  <!-- END EMBED EDITOR -->
                </div>
                <div class="col-12">
                  <hr />
                  <button type="submit" class="btn btn-primary" style="float:right; ">Zatwierdź ustawienia</button>
                </div>
              </div>
            </div>

            <!-- EMBED EDITOR -->

          </div>
        </div>



      </main>
    </div>
  </div>


  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/scripts.php') ?>
  <script src="text-channel.js"></script>


</body>

</html>