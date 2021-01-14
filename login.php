<?php
    session_start();
    $title = "Login";
    include "init.php";
    if(isset($_SESSION['client'])){ header("Location:index.php"); exit; }

?>
    <div class="container">
        <div class="login">
            <h3 class="display-4 text-center"><span class="login">Login</span> | <span class="signup">Sign up</span></h3>
            <form class="form-login signin">
                <input type="email" placeholder="Email" class="form-control" autocomplete="off" required>
                <input type="password" placeholder="Password" class="form-control" autocomplete="new-password" required>
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