<?php
    session_start();
    $title = "Login";
    include "init.php";
    if(isset($_SESSION['Client'])){ header("Location:index.php"); exit; }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['signin'])){
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $hahsedpass = sha1($pass);
    
            $stmt = $connect->prepare("SELECT * FROM users WHERE Username = ? AND Password = ? LIMIT 1");
            $stmt->execute(array($user,$hahsedpass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if($count > 0){
                $_SESSION['User_ID'] = $row['UserID'];
                $_SESSION['Client'] = $user;
                header("Location: index.php");
                exit();
            }
        }else{
            $username   = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
            $email      = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $pass1      = sha1($_POST['pass']);
            $pass2      = sha1($_POST['pass2']);

            $errors = [];
            $check = checkItem("Username","users",$username);
            if($check > 0){
                $errors[] = "You have entered an username that already exists";
            }
            if(strlen($username) < 4){
                $errors[] = "Your username must be grater than 4 characters";
              }
            if($pass1 != $pass2){
                $errors[] = "The passwords doesn't match";
            }
            
            if(empty($errors)){
                $stmt = $connect->prepare("INSERT INTO 
                users(Username, Password, Email,RegStatus,date) 
                VALUES(:zuser, :zpass, :zmail, 0,:zdate)
                ");
                $stmt->execute(array(
                "zuser" => $username,
                "zpass" => $pass1,
                "zmail" => $email,
                "zdate" => date("Y-m-d")
                ));
                
            ?>
                <div class="alert alert-success col-sm-5 mr-auto ml-auto mt-2">The user has been added</div>
            <?php
            }else{
                foreach($errors as $error){
                    echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                  }
            }
        }

    }

?>
    <div class="container">
        <div class="login">
            <h3 class="display-4 text-center"><span class="signin">Login</span> | <span class="signup">Sign up</span></h3>
            <form class="form-login signin" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input type="text" placeholder="Username" name="user" class="form-control" autocomplete="off" required>
                <input type="password" placeholder="Password" name="pass" class="form-control" autocomplete="new-password" required>
                <input type="submit" value="Sign in" name="signin" class="form-control btn-primary">
            </form>

            <form class="form-login signup" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input type="text" name="user" placeholder="Username" class="form-control" autocomplete="off" required>
                <input type="email" name="email" placeholder="Email" class="form-control" autocomplete="off" required>
                <input type="password" name="pass" placeholder="Password" class="form-control" autocomplete="new-password" required>
                <input type="password" name="pass2" placeholder="Confirm Password" class="form-control" autocomplete="new-password" required>
                <input type="submit" value="Sign up" name="signup" class="form-control btn-success">
            </form>
        </div>
        
    </div>
<?php
    include $tmpl . "footer.php";
?>