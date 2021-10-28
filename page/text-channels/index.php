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

  <title>Text channels | NANO</title>

  <?php require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/header.php') ?>
  <!-- TABLE -->
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">



  <style>
    tbody,
    td,
    tfoot,
    th,
    thead,
    tr {
      border: 0 solid;
      border-color: #ccc;
    }
  </style>


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
          <h1 class="h2"><i class="fas fa-hashtag"></i> Text channels</h1>
        </div>
        <form id="remove_logs">
          <!-- DELETE CARD -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"><i class="far fa-trash-alt"></i> Deleted message information</h5>
              <p class="card-text">Information about deleted messages will be sent to the channel you specified.</p>
              <!-- FORM FIELDS -->
              <div class="row">
                <div class="col-md-6">
                  <label>Stan modułu</label><br />
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-success active">
                      <input type="radio" name="remove_logs_enable" id="option1" autocomplete="off" value="1" <?php echo checked($module_info['remove_logs_enable'], 1); ?>> Enabled
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="remove_logs_enable" id="option2" value="0" autocomplete="off" <?php echo checked($module_info['remove_logs_enable'], 0) ?>> Disabled
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Select text channel</label>
                  <select class="custom-select form-control" name="remove_logs_channel" id="remove_logs_channel">
                    <option value="">Open this select menu</option>
                    <?php echo guild_text_channels_list($_SESSION['selected_guild'], $module_info['remove_logs_channel']); ?>
                  </select>
                </div>
                <div class="col-12">
                  <hr />
                  <button type="submit" class="btn btn-primary" style="float:right; ">SAVE</button>
                </div>
              </div>
              <!-- END FORM FIELDS -->
            </div>
          </div>
          <!-- END JOIN CARD -->
        </form>
        <form id="edit_logs">
          <!-- LEAVE CARD -->
          <div class="card" style="margin-top:20px;">
            <div class="card-body">
              <h5 class="card-title"><i class="far fa-edit"></i> Edited message information</h5>
              <p class="card-text">When the module is enabled, the text channel of your choice will receive information about who left, when, and what voice channel.</p>
              <!-- FORM FIELDS -->
              <div class="row">
                <div class="col-md-6">
                  <label>Module status:</label><br />
                  <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-success active">
                      <input type="radio" name="edit_logs_enable" id="option1" autocomplete="off" value="1" <?php echo checked($module_info['edit_logs_enable'], 1) ?>> Enabled
                    </label>
                    <label class="btn btn-danger">
                      <input type="radio" name="edit_logs_enable" id="option2" value="0" autocomplete="off" <?php echo checked($module_info['edit_logs_enable'], 0) ?>> Disabled
                    </label>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Select text channel</label>
                  <select class="custom-select form-control" name="edit_logs_channel" id="edit_logs_channel">
                    <option value="">Open this select menu</option>
                    <?php echo guild_text_channels_list($_SESSION['selected_guild'], $module_info['edit_logs_channel']); ?>
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

        <!-- REMOVE MESSAGE CARD -->
        <div class="card" style="margin-top:20px;">
          <div class="card-header"><i class="far fa-edit" style="color: #ffc800;"></i> Edit logs</div>
          <div class="card-body">
            <table id="table" style="max-width:100%;" data-toggle="table" data-show-pagination-switch="true" data-show-toggle="true" data-show-refresh="true" data-show-export="true" data-show-jump-to="true" data-detail-view="true" data-filter-control="true" data-show-search-clear-button="true" data-sortable="true" data-pagination="true" data-mobile-responsive="true" data-row-style="rowStyle">
              <thead>
                <tr>
                  <th data-filter-control="input" data-formatter="actionFormatter">Action</th>
                  <th data-field="author_name" data-filter-control="input">Author</th>
                  <th data-formatter="channel_formatter" data-field="channel" data-filter-control="input">Channel</th>
                  <th data-formatter="contentFormatter" data-filter-control="input">Content</th>
                  <th data-field="client_id" data-filter-control="input" data-visible="false">Client id</th>
                  <th data-field="channel_id" data-filter-control="input" data-visible="false">Channel id</th>
                  <th data-field="action_time" data-formatter="timecontrol">Time</th>
                </tr>
              </thead>
            </table>

          </div>
          <div class="card-footer">The system displays the last 100 results from database (dont actions). To get more of them use the generate function.</div>
        </div>


      </main>
      <?php require('attachment_modal.php'); ?>
    </div>

  </div>


  <?php

  require($_SERVER['DOCUMENT_ROOT'] . '/page/addons/scripts.php') ?>
  <!-- TABLE -->
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
  <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
  <script src="/assets/timeconvert.js"></script>
  <script src="text-channel.js"></script>
  <script src="logs.js"></script>

</body>

</html>