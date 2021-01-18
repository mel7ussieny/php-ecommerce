<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo getTitle()?></title>
    <link rel="stylesheet" href="<?php echo $css ?>bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link rel="stylesheet" href="<?php echo $css ?>main.css">
    <link rel="stylesheet" href="<?php echo $css?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $css?>jquery.selectBoxIt.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&family=Open+Sans&display=swap" rel="stylesheet">    </head>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

    <body>
      <div class="container">
        <div class="d-flex justify-content-start align-items-center upper-bar">
          <?php
          // View The User Name
            if(!isset($_SESSION['Client'])){
              echo '<a href="login.php" style="margin-left:auto">Login/Sign Up</a>';
            }else{
            echo' 
            <div class="user-profile">
              <img src="model.jpg" alt="Img">
            </div>';
            echo '<div class="dropdown">';
            echo  '<button class="btn dropdown-toggle btn-dropdown" style="box-shadow:none" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  '.$_SESSION['Client'].'
                  </button>';
            echo '<div class="dropdown-menu" aria-labelledby="dropdownMenu2">';
            echo '<a href="profile.php"><button class="dropdown-item" type="button">View Profile</button></a>';
            echo '<a href="newads.php"><button class="dropdown-item" type="button">New ads</button></a>';
            echo '<a href="logout.php"><button class="dropdown-item" type="button">Logout</button></a>';
            echo '</div>';
            echo '</div>';
            }

          ?>


        </div>

      </div>
      
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-2">
        <div class="container">
          <a class="navbar-brand" href="index.php">Shop</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">

              <?php
                foreach(getCat() as $cat){
                  echo "<li class='nav-item'><a class='nav-link' href='categories.php?pageid=".$cat["ID"]."'>".  $cat['Name']."</a></li>";
                }
              ?>
            </ul>

          </div>
        </div>
      </nav>
