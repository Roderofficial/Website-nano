<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-dark">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <div class="nav-link" style="word-break: break-word;">
          <center>
            <h6>MANAGE THE SERVER</h6>
            <hr />
            <?php
            #generate avatar
            if ($guild_info['icon'] != null) {
              $guild_icon_url =  'https://cdn.discordapp.com/icons/' . $guild_info['id'] . '/' . $guild_info['icon'] . '.png?size=64';
              $guild_icon = '<img src="' . $guild_icon_url . '" style="border-radius:50%; display: list-item; margin:10px;">';
            } else {
              $guild_icon = null;
            }
            echo $guild_icon;
            ?>
            <?php echo $guild_info['name']; ?>

          </center>

          <!-- BUTTONS CONTROL -->
          <center>
            <div class="d-grid gap-2 d-md-block" style="margin-top:10px;">
              <a class="btn btn-sm btn-primary" href="/selectserver">Change server</a>
              <a class="btn btn-sm btn-danger" href="/login/logout.php">Logout</a>
            </div>
          </center>
          <hr />
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/page/dashboard/">
          <i class="fas fa-tachometer-alt"></i>
          Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/page/settings">
          <i class="fas fa-cog"></i>
          Settings
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>CHANNELS LOGS AND SETTINGS</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="/page/voice-channels/">
          <i class="fas fa-microphone-alt"></i>
          Voice channels
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/page/text-channels/">
          <i class="fas fa-hashtag"></i>
          Text channels
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>MODERATION</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="/page/randomgenerator/">
          <i class="fas fa-dice"></i>
          Kick members
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/page/jlmessages/">
          <i class="fas fa-cog"></i>
          Ban members
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Mute members
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="file-text"></span>
          Warning system
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>FUN</span>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="/page/welcome-message/">
          <i class="fas fa-comment"></i>
          Welcome messages
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/page/randomgenerator/">
          <i class="fas fa-dice"></i>
          User drawing
        </a>
      </li>
    </ul>
  </div>
</nav>