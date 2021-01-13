      <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0">
        <div class="container">
          <a class="navbar-brand" href="dashboard.php"><i class="fas fa-home mr-2"></i>Home</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="categories.php"><?php echo lang('Nav-Cat')?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="items.php"><?php echo lang('Nav-Itm')?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="members.php"><?php echo lang('Nav-Mem')?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="comments.php"><?php echo lang('Nav-Com')?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="stat.php"><?php echo lang('Nav-Stat')?></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="log.php"><?php echo lang('Nav-Log')?></a>
              </li>
            </ul>
            <ul class="list-unstyled m-0">
              <li class="nav-item dropdown pt-2 pb-2">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo strtoupper($_SESSION['user']) ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="members.php?action=Edit&UserID=<?php echo $_SESSION['ID']?>"><?php echo lang('Drop-Ed')?></a>
                  <a class="dropdown-item" href="#"><?php echo lang('Drop-Set')?></a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="logout.php"><?php echo lang('Drop-Log')?></a>
                </div>
              </li>
            </ul>

          </div>
        </div>
      </nav>
