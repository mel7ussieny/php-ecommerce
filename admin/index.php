<?php
    session_start();
    // Redirect to dashboard if there's record in session
    $navbar = 0;
    $title = "Login";
    if(isset($_SESSION['user'])){ header("Location:dashboard.php"); exit; }

    include 'init.php';
    include 'connect.php';

    // Check Request Method
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['user'];
        $password = sha1($_POST['pass']);
        $stmt = $connect->prepare("SELECT
          Username,Password,UserID
           FROM
           users
           WHERE
           Username = ?
           AND
           Password = ?
           AND
           permission = 1
           LIMIT 1");
        $stmt->execute(array($username,$password));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();

        print_r($row);
        if($count > 0){
          $_SESSION['user'] = $username;
          $_SESSION['ID']   = $row['UserID'];
          header("Location:dashboard.php");
          exit;
        }else{
            $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>Invalid username or password</div>";
            echo $msg;
        }

    }
?>

      <form class='login-form' action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
          <h3 class="text-center text-dark mb-3" style="font-size:20px">Control Panel</h3>
          <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off">
          <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
          <input class="btn btn-primary btn-block" type="submit" value="Login">
      </form>

<?php
    include $tmpl . 'footer.php';
?>
