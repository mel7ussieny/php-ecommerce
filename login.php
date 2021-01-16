<?php
    session_start();
    $title = "Login";
    include "init.php";
    if(isset($_SESSION['Client'])){ header("Location:index.php"); exit; }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
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
    }

?>
    <div class="container">
        <div class="login">
            <h3 class="display-4 text-center"><span class="signin">Login</span> | <span class="signup">Sign up</span></h3>
            <form class="form-login signin" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                <input type="text" placeholder="Username" name="user" class="form-control" autocomplete="off" required>
                <input type="password" placeholder="Password" name="pass" class="form-control" autocomplete="new-password" required>
                <input type="submit" value="Sign in" class="form-control btn-primary">
            </form>

            <form class="form-login signup">
                <input type="text" name="user" placeholder="Username" class="form-control" autocomplete="off" required>
                <input type="email" name="email" placeholder="Email" class="form-control" autocomplete="off" required>
                <input type="password" name="pass" placeholder="Password" class="form-control" autocomplete="new-password" required>
                <input type="password" name="pass2" placeholder="Confirm Password" class="form-control" autocomplete="new-password" required>
                <input type="submit" value="Sign up" class="form-control btn-success">
            </form>
        </div>
        
    </div>
<?php
    include $tmpl . "footer.php";
?>