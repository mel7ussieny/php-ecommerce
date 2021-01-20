<?php

session_start();
$navbar = 1;
    /*
      =================================
      == Members Page
      =================================
    */

    if(isset($_SESSION['user'])){
      $title = "Dashboard";
      include 'init.php';
      $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';

      $condition = '';
      if(isset($_GET['page']) && $_GET['page'] == "pending"){
        $condition = "AND RegStatus = 0";
      }
      if($action == 'Manage'){      
      $stmt = $connect->prepare("SELECT * FROM users WHERE Permission != 1 $condition");
      $stmt->execute();
      $row = $stmt->fetchAll();
?>
    <div class="container">
    <div class="table-responsive mt-5">
        <table class="table table-bordered text-center table-sm">
          <thead class="thead-light">
            <tr>
              <th>ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Name</th>
              <th>Registered Date</th>
              <th>Action</th>
            </tr>  
          <thead>
          <tbody>
    <!-- START DATA OF USERS -->
<?php
foreach($row as $key => $value){
  echo "<tr class='text-center'>";
  echo "<td>".$row[$key]['UserID']."</td>";
  echo "<td>".$row[$key]['Username']."</td>";
  echo "<td>".$row[$key]['Email']."</td>";
  echo "<td>".$row[$key]['FullName']."</td>";
  echo "<td>".$row[$key]['date']."</td>";
  echo "<td>
          <a href='?action=Delete&UserID=".$row[$key]['UserID']."' class='confirm btn btn-danger btn-sm'>
            <i class='fas fa-user-times'></i>  
            Delete
          </a>
          <a href='?action=Edit&UserID=".$row[$key]['UserID']."' class='btn btn-primary btn-sm'>
            <i class='fas fa-edit'></i>
            Edit
          </a>";
  if($row[$key]["RegStatus"] == 0){
  echo " <a href='?action=Activate&UserID=".$row[$key]['UserID']."' class='btn btn-info btn-sm'>
        <i class='fas fa-check-square'></i>
          Activate
        </a>";
  }
  echo "</td>";
  echo "</tr>";

?>
    <!-- END DATA OF USERS -->

            
<?php } // END THE FOREACH LOOP OF EXECUTE DATA


?>
          </tbody>
        </table>
      </div>
      
      <a href='?action=Add' class='btn btn-info btn-sm'>
        <i class="fas fa-user-plus"></i>
        Add Member
      </a>
    </div>
<?php
      }elseif($action == 'Edit'){
      // EDIT PAGE
      $UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) == TRUE ? $_GET['UserID'] : 0;

        
      $stmt = $connect->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
      $stmt->execute(array($UserID));
      $count = $stmt->rowCount();
      $row = $stmt->fetch();

      if($count > 0){ 
?>
  <div class="container">
      <form action="?action=Update" method="POST">
          <div class="form-card form-group col-sm-12 col-md-6">
              <span class="display-4 text-dark">Edit Member</span>
              <hr style="text-dark">
              <input type="hidden" name="usrid" value="<?php echo $row['UserID']?>">
              <input type="text"  name="user" class="form-control"   value="<?php echo $row['Username']?>" placeholder="Username" required>
              <input type="hidden" name="oldpass" value="<?php echo $row['Password']?>">
              <input type="password"  name="newpass" class="form-control" placeholder="Password">
              <input type="email" name="email" class="form-control"  value="<?php echo $row['Email']?>"  placeholder="Email" required>
              <input type="text"  name="full" class="form-control"   value="<?php echo $row['FullName']?>"  placeholder="Full Name" required>
              <input type="Submit" value="Save" class="btn-primary form-control" required>
        </div>
      </form>
  </div>
<?php
  }else{
    $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>This Record Doesn't Exists</div>";
    redirectPage($msg,3,"members.php");
  }

      }elseif($action == "Update"){
          // UPDATE ACTION

        if($_SERVER['REQUEST_METHOD'] == "POST"){
          $id     = $_POST['usrid'];
          $user   = $_POST['user'];
          $email  = $_POST['email'];
          $full   = $_POST['full'];
          $pass = empty($_POST['newpass']) ? $_POST['oldpass'] : $_POST['newpass'];
          $hashedpass = sha1($pass);
          
          $ErrorsCatch = [];

          // Validation Cathces
          if(strlen($user) < 4){
            $ErrorsCatch[] = "Your username must be grater than 4 characters";
          }
          if(strlen($pass) < 5){
            $ErrorsCatch[] = "Your password must be grater than 5 characters";
          }
          if(strlen($full) < 7){
            $ErrorsCatch[] = "Your Name must be grater than 7 characters";
          }

          if(empty($ErrorsCatch)){
            $stmt = $connect->prepare("UPDATE users SET Username = ? , Email = ? , FullName = ? , Password = ? WHERE UserId = ?");
            $stmt->execute(array($user,$email,$full,$hashedpass,$id));
  
            $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-2'>" .  $stmt->rowCount() . " Record Updated</div>";
            redirectPage($msg,3,"back");
          }else{
            foreach($ErrorsCatch as $error){
              echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
            }
            redirectMsg(3,"back");
            
          }

        }else{
          // UPDATE NOT WITH POST REQUEST
          $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>You don't have permission to access this page</div>";
          redirectPage($msg,3,"members.php");
        }
        
      }elseif($action == "Add"){
        // Insert Action
?>
<div class="container">
      <form action="?action=Insert" method="POST" enctype="multipart/form-data">
          <div class="form-card form-group col-sm-12 col-md-6">
              <span class="display-4 text-dark">Add Member</span>
              <hr style="text-dark">
              <input type="text" name="user" class="form-control" placeholder="Username" autocomplete="off" required>
              <input type="password" name="newpass" class="form-control" placeholder="Password" autocomplete="new-password">
              <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required>
              <input type="text" name="full" class="form-control" placeholder="Full Name" autocomplete="off" required>
              <input type="file" name="file" class="form-control" autocomplete="off" required>
              <input type="Submit" value="Add Member" class="btn-success form-control">
        </div>
      </form>
  </div>
<?php
      }elseif($action == "Insert"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
          $user   = $_POST['user'];
          $email  = $_POST['email'];
          $full   = $_POST['full'];
          $pass   = $_POST['newpass'];
          // $file   = $_FILES['file'];

          // Pic Infos
          $file_name = $_FILES['file']['name'];
          $file_type = $_FILES['file']['type'];
          $file_tmp  = $_FILES['file']['tmp_name'];
          $file_size = $_FILES['file']['size'];


          // Picture Security 



          $hashedpass = sha1($pass);
          $ErrorsCatch = [];

          // Validation Cathces 
          
          // CHECK USER EXISTS
          $check = checkItem("Username","users",$user);
          if($check > 0){
            $ErrorsCatch[] = "You have entered an username that already exists";
          }else{
            // CATCH ERROR IN INSERT
            if(strlen($user) < 4){
              $ErrorsCatch[] = "Your username must be grater than 4 characters";
            }
            if(strlen($pass) < 5){
              $ErrorsCatch[] = "Your password must be grater than 5 characters";
            }
            if(strlen($full) < 7){
              $ErrorsCatch[] = "Your name must be grater than 7 characters";
            }            
            if(!empty($file_name) && !in_array($ext,$allowed_ext)){
              $ErrorsCatch[] = "This file is not allowed";
            }
            if(empty($file_name)){
              $ErrorsCatch[] = "Avatart is required";
            }
            if($file_size > 4194304){
              $ErrorsCatch[] = "This file must be less than 4MB";
            }
          }
          
          

          if(empty($ErrorsCatch)){
            $avatar_name = rand(0,9999999) . "_" . $file_name;

            $stmt = $connect->prepare("INSERT INTO 
            users(Username, Password, Email, FullName,RegStatus,date,user_avatar) 
            VALUES(:zuser, :zpass, :zmail, :zfull,1,:zdate, :zavatar) ");
            $stmt->execute(array(
            "zuser" => $user,
            "zpass" => $hashedpass,
            "zmail" => $email,
            "zfull" => $full,
            "zdate" => date("Y-m-d"),
            "zavatar" => $avatar_name
            ));
            move_uploaded_file($file_tmp,"upload\imgs\\".$avatar_name);

            $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-2'>" .  $stmt->rowCount() . " Record Updated</div>";
            redirectPage($msg,3,"back");
          }else{
            foreach($ErrorsCatch as $error){
              echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
            }
            redirectMsg(3,"members.php");
          }
        }else{
          $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>You don't have permission to access this page</div>";
          redirectPage($msg,3,"members.php");
        }
      }elseif($action == "Delete"){
        $UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) == TRUE ? $_GET['UserID'] : 0;
        $check = checkItem("UserId","users",$UserID);

        if($check > 0){
          $stmt = $connect->prepare("DELETE FROM users WHERE UserID = ?");
          $stmt->execute(array($UserID));
          $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-3'>".$stmt->rowCount()." Record deleted</div>";
          redirectPage($msg,2,"back");
        }else{
          $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>There's no record found</div>";
          redirectPage($msg,2,"back");
        }

      }elseif($action == "Activate"){
        $UserID = isset($_GET['UserID']) && is_numeric($_GET['UserID']) == TRUE ? $_GET['UserID'] : 0;
        $check = checkItem("UserId","users",$UserID);

        if($check > 0){
          $stmt = $connect->prepare("UPDATE users SET RegStatus = ? WHERE UserID = ?");
          $stmt->execute(array(1,$UserID));
          $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-3'>".$stmt->rowCount()." Record Activated</div>";
          redirectPage($msg,3,"back");
        }else{
          $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>There's no record found</div>";
          redirectPage($msg,3,"back");
        }

      }


      include $tmpl . "footer.php";

    }else{
      header("Location:index.php");
    }


?>
