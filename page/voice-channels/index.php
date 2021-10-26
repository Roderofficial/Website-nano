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

  <title>Voice channels | NANO</title>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/header.php') ?>
  <!-- TABLE -->
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">






  <!-- Custom styles for this template -->
  <link href="/page/global.css" rel="stylesheet">
  <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.css" rel="stylesheet">
</head>

<body>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/navbar.php') ?>

  <div class="container-fluid">
    <div class="row">
      <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/sidebar.php') ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2"><i class="fas fa-cog"></i> Voice channel activity logs</h1>
        </div>
        <form id="join_messages">
          <!-- JOIN CARD -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="far fa-bell"></i> Message about joining the voice channel</h5>
              <p class="card-text">When the module is enabled, the text channel of your choice will receive information about who has joined, when, and on what voice channel.</p>
              <!-- FORM FIELDS -->
              <div class="row">
                <div class="col-md-6">
                  <label>Module status:</label><br />
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-success active">
                      <input type="radio" name="join_enable" id="option1" autocomplete="off" value="1" <?php echo checked($module_info['join_enable'], 1); ?>> ENABLED
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="join_enable" id="option2" value="0" autocomplete="off" <?php echo checked($module_info['join_enable'], 0) ?>> DISABLED
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Select text channel</label>
                  <select class="custom-select form-control" name="join_channel" id="join_channel">
                    <option value="">Open this select menu</option>
                    <?php echo guild_text_channels_list($_SESSION['selected_guild'], $module_info['join_channel']); ?>
                  </select>
                </div>
                <div class="col-12">
                  <hr />
                  <button type="submit" class="btn btn-primary" style="float:right;">SAVE</button>
                </div>
              </div>
              <!-- END FORM FIELDS -->
            </div>
          </div>
          <!-- END JOIN CARD -->
        </form>
        <form id="leave_messages">
          <!-- LEAVE CARD -->
          <div class="card" style="margin-top:20px;">
            <div class="card-body">
              <h5 class="card-title"><i class="far fa-bell"></i> Message when leaving the voice channel</h5>
              <p class="card-text">When you turn on the module, the text channel of your choice will receive information about who left, when, and what voice channel.</p>
              <!-- FORM FIELDS -->
              <div class="row">
                <div class="col-md-6">
                  <label>Module status:</label><br />
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-success active">
                      <input type="radio" name="leave_enable" id="option1" autocomplete="off" value="1" <?php echo checked($module_info['leave_enable'], 1) ?>> ENABLED
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="leave_enable" id="option2" value="0" autocomplete="off" <?php echo checked($module_info['leave_enable'], 0) ?>> DISABLED
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Select text channel</label>
                  <select class="custom-select form-control" name="leave_channel" id="leave_channel">
                    <option value="">Open this select menu</option>
                    <?php echo guild_text_channels_list($_SESSION['selected_guild'], $module_info['leave_channel']); ?>
                  </select>
                </div>
                <div class="col-12">
                  <hr />
                  <button type="submit" class="btn btn-primary" style="float:right;">SAVE</button>
                </div>
              </div>
              <!-- END FORM FIELDS -->
            </div>
          </div>
          <!-- END LEAVE CARD -->
        </form>

        <!-- LOGS -->
        <div class="card" style="margin-top: 20px;">
          <div class="card-header">Voice channels logs</div>
          <div class="card-body">
            <table id="table" data-toggle="table" data-show-pagination-switch="true" data-show-toggle="true" data-show-refresh="true" data-show-export="true" data-show-jump-to="true" data-filter-control="true" data-show-search-clear-button="true" data-url="logs.php" data-sortable="true" data-pagination="true" data-mobile-responsive="true" data-row-style="rowStyle" data-show-columns="true">
              <thead>
                <tr>
                  <th data-field="client_name" data-filter-control="input">Client name</th>
                  <th data-field="channel_name" data-formatter="channelstyle" data-filter-control="input">Channel name</th>
                  <th data-field="client_id" data-filter-control="input" data-visible="false">Client id</th>
                  <th data-field="channel_id" data-filter-control="input" data-visible="false">Channel id</th>
                  <th data-field="action" data-formatter="actionformat" data-filter-control="input">Action</th>
                  <th data-field="timestamp" data-formatter="timecontrol" data-sortable="true">Time</th>
                </tr>
              </thead>
            </table>

          </div>
        </div>


      </main>
    </div>
  </div>


  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/scripts.php') ?>
  <!-- TABLE -->
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>

  <!-- EXPORT -->
  <script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/export/bootstrap-table-export.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/page-jump-to/bootstrap-table-page-jump-to.min.js"></script>


  <script src="jlmessages.js"></script>
  <script src="logs.js"></script>
  <script>
    $(function() {
      $('#table').bootstrapTable()
    })
  </script>

</body>

</html>