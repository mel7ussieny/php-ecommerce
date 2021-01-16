<?php
session_start();
$navbar = 1;
  if(isset($_SESSION['user'])){
    $title = "Dashboard";
    include 'init.php';

  ?>
  <div class="container">
    <div class="row mt-5">
      <div class="col-12 col-lg-3 mb-3 mb-lg-0">
      <div class="stats-content p-4 text-center st-total">
          <div class="left-icon">
            <i class="fas fa-users dash-icons"></i>
          </div>
          <div class="right-text">
            <span class="d-block font-weight-bold text-light">Total Members</span>
            <span class="display-4 font-weight-bold text-light"><a href="members.php"><?php getCount("UserID","users")?></a></span>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 mb-3 mb-lg-0">
      <div class="stats-content p-4 text-center st-pending">
        <div class="left-icon">
        <i class="fas fa-star-half-alt dash-icons"></i>
        </div>
          <div class="right-text">
            <span class="d-block font-weight-bold text-light">Pending Members</span>
            <span class="display-4 font-weight-bold text-light"><a href="members.php?action=Manage&page=pending"><?php getCount("UserID","users","RegStatus = 0")?></a></span>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 mb-3 mb-lg-0">
      <div class="stats-content p-4 text-center st-items">
          <div class="left-icon">
            <i class="fas fa-tag dash-icons"></i>
          </div>
          <div class="right-text">
            <span class="d-block font-weight-bold text-light">Total Items</span>
            <span class="display-4 font-weight-bold text-light"><a href="items.php"><?php getCount("Item_ID","items")?></a></span>
           </div>
        </div>
      </div>
      <div class="col-12 col-lg-3 mb-3 mb-lg-0">
      <div class="stats-content p-4 text-center st-comments">
          <div class="left-icon">
            <i class="fas fa-comments dash-icons"></i>
          </div>
          <div class="right-text">
            <span class="d-block font-weight-bold text-light">Total Comments</span>
            <span class="display-4 font-weight-bold text-light"><a href="comments.php"><?php getCount("Com_ID","comments")?></a></span>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-4">
        <div class="card">
          <div class="card-header font-weight-bold">
          <i class="fas fa-users"></i> Latest Registred Users
          </div>
          <div class="card-body latest-users">
            <ul class="list-unstyled">
            <?php

            $data = getLatest("FullName,UserID,RegStatus","users","UserId");

            foreach($data as $row){
              $fullName = empty($row["FullName"]) == TRUE ? "Root" : $row["FullName"];
              echo "<li class='d-flex align-items-center' style='position:relative'>".$fullName."<div class='latest-div'><a href='members.php?action=Edit&UserID=".$row['UserID']."' class='btn btn-primary btn-sm'>
              <i class='fas fa-edit'></i>
              Edit
              </a>";
              if($row["RegStatus"] == 0){
              echo "<a href='members.php?action=Activate&UserID=".$row['UserID']."' class='btn btn-info btn-sm ml-2'>
                      <i class='fas fa-check-square'></i>
                      Active
                    </a>";
              }

              echo "</div></li>";
            }
            ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6 mt-4">
        <div class="card">
          <div class="card-header font-weight-bold">
          <i class="fas fa-tag"></i> Latest Registred Users
          </div>
          <div class="card-body latest-items">
            <ul class="list-unstyled">
            <?php

    $data = getLatest("Item_ID,Item_Name,Approve","items","Item_ID");

    foreach($data as $row){
      echo "<li class='d-flex align-items-center' style='position:relative'>" .  $row["Item_Name"] .
      "<div class='latest-div'><a href='items.php?action=Edit&Item_ID=".$row['Item_ID']."' class='btn btn-primary btn-sm'>
      <i class='fas fa-edit'></i>
      Edit
      </a>";
      if($row["Approve"] == 0){
      echo "<a href='items.php?action=Approve&Item_ID=".$row['Item_ID']."' class='btn btn-info btn-sm ml-2'>
              <i class='fas fa-check-square'></i>
              Active
            </a>";
      }

      echo "</div></li>";
    }
    ?>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php
    include $tmpl . "footer.php";

  }else{
    header("Location:index.php");
  }

?>
