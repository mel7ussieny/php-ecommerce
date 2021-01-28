<?php
    session_start();
    include 'init.php';
    if(isset($_SESSION['Client']) && !isset($_GET['view'])){
        $title = "Profile";
        $stmt = $connect->prepare("SELECT * FROM users WHERE UserId = ?");
        $stmt->execute(array($_SESSION['User_ID']));
        $row = $stmt->fetch();
        $name = $row['FullName'];
        $fname = substr($name,0,strpos($name," "));
        $lname = substr($name,strpos($name, " ")); 
        $img = empty($row['user_avatar']) ? "default-user.jpg" : $row['user_avatar'];

        // Edit the information

        if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_SESSION['Client'])){

            if(isset($_POST['updateinfos'])){
                // For Uplaod The Infos

                $userid = $_SESSION['User_ID'];
                $full   = filter_var($_POST['full'],FILTER_SANITIZE_STRING);
                $user   = filter_var($_POST['user'],FILTER_SANITIZE_STRING);
                $email  = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
    
                $errors = [];
                if(strlen($full) < 5){
                    $erros[] = "Your name must be grater than 5 characters";
                }
                if(strlen($user) < 5){
                    $erros[] = "Your username must be grater than 5 characters";
                }
                if(strlen($email) < 5){
                    $erros[] = "Please enter valid email address";
                }
    
                if(empty($erros)){
                    $stmt = $connect->prepare("UPDATE users SET FullName = ?, Email = ?, Username = ? WHERE UserID = ?");
                    $stmt->execute(array($full,$email,$user,$userid));
                    if($stmt){
                        $msg = "<div class='alert alert-success'>".$stmt->rowCount()." Record Updated</div>";
                    }else{
                        $msg = "<div class='alert alert-danger'>Somthing went wrong</div>";
                    }
    
                }
            }elseif(isset($_POST['uploadimg'])){
                // For upload the image


                // client picture details
                $file_name = $_FILES['clientimg']['name'];
                $file_type = $_FILES['clientimg']['type'];
                $file_tmp  = $_FILES['clientimg']['tmp_name'];
                $file_size = $_FILES['clientimg']['size'];
                
                $image_info = getimagesize($file_tmp);
                $image_height = $image_info[1];

                // Precutaions
                $allowed_ext = array("jpeg","jpg","png","gif");
                $file_ext = explode(".",$file_name);
                $ext = strtolower($file_ext[count($file_ext) -1]);

                $ErrorsCatch = [];

                if(!empty($file_name) && !in_array($ext,$allowed_ext)){
                    $ErrorsCatch[] = "This file is not allowed";
                }
                if($file_size > 4194304){
                    $ErrorsCatch[] = "This file must be less than 4MB";
                }
                if(empty($file_name)){
                    $ErrorsCatch[] = "You can't upload empty file";
                }
                if($image_height < 300){
                    $ErrorsCatch[] = "Height must be grater than 300";
                }
                                
                
                if(empty($ErrorsCatch)){
                    // User have image or not
                    $stmt = $connect->prepare("SELECT user_avatar FROM users WHERE UserID = ?");
                    $stmt->execute(array($_SESSION['User_ID']));
                    $get_img = $stmt->fetch();

                    $img_name = rand(0,9999999) . "_" . $file_name;
                    if(!empty($get_img['user_avatar'])){
                        // The img exists before
                        if(is_file("admin/upload/imgs/".$get_img['user_avatar'])){
                            unlink("admin/upload/imgs/".$get_img['user_avatar']);
                        } 
                    }



                    move_uploaded_file($file_tmp,"admin\upload\imgs\\".$img_name);
                    $stmt = $connect->prepare("UPDATE users SET user_avatar = ? WHERE UserID = ?");
                    $stmt->execute(array($img_name, $_SESSION['User_ID']));
                    if($stmt){
                        $msg_img = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-2'> Image has been Updated</div>";

                        redirectPage($msg_img,0,"back");
                    }
                }else{
                    foreach($ErrorsCatch as $error){
                        echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                    }
                }
            
            }
            
    }
?>
    <div class="infos">
        <div class="container">
            <div class="row">
                <!-- Start 1St Row  Personal Infos -->
                <div class="col-12 col-lg-6">
                    <div class="user-left">
                        <span class="user-img-upper"><a href="profile.php"><?php echo $fname?> Profile</a></span>
                        <span><a href="index.php"><i class="fas fa-undo-alt"></i> Back Shopping</a></span>
                        <div class="user-img">
                            <div class="file">
                                 <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="clientimg" class="form-control input-upload">
                                    <input type="submit" name="uploadimg" class="btn btn-success mt-3">
                                 </form>
                            </div>
                            <img src="admin/upload/imgs/<?php echo $img?>" alt="Model" class="img-fluid">
                        </div> 
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="user-infos">
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                            <?php
                                if(isset($msg)){
                                    echo $msg;
                                }
                            ?>
                            <div class="user-personal">
                                <input type="hidden" name="userid" value="<?php echo $row["UserID"]?>">
                                <span class="title-column">Personal Information :</span>
                                <div class="input-field">
                                    <label for="name">Full Name</label>
                                    <input name="full" type="text" value="<?php echo $row['FullName']?>" class="form-control" id="name">
                                </div>
                                <div class="input-field">
                                    <label for="user">Username</label>
                                    <input name="user" type="text" value="<?php echo $row['Username']?>" id="user" class="form-control">
                                </div>
                            </div>
                            <div class="user-contact">
                                <span class="title-column">Contact Information : </span>
                                <div class="input-field">
                                    <label for="email">Email</label>
                                    <input name="email" type="email" value="<?php echo $row['Email']?>" id="email" class="form-control">
                                </div>
                            </div>
                            <input type="submit" name="updateinfos" class="btn btn-primary mt-2">
                        </form>
                        <span class="static-data">Register Date : <?php echo $row['date']?></span>
                        <span class="static-data">Favourite Categories : Handmade, Electronics</span>
                    </div>
                </div>
                <!-- 1st Row End Personal Infos-->

                <div class="col-12">
                    <div class="user-ads">
                        <h3>Advertisements</h3>
                        <div class="row">
                        <?php
                            foreach(getItems("User_ID",$row['UserID']) as $item){
                                echo "<div class='col-4 col-lg-2'>";
                                echo "<div class='item'>";
                                $img = empty($item['Item_Avatar']) ? "default-item.jpg" : $item['Item_Avatar'];
                                    echo "<div class='item-img d-flex justify-content-center'><img src='admin/upload/imgs/".$img."' class='item-img img-responsive m-auto'></div>";
                                    echo "<div class='item-details'>";
                                        echo "<h4><a href='items.php?item_id=".$item['Item_ID']."'>".$item['Item_Name']."</a></h4>";
                                        echo "<div class='stars'>";
                                        for($i = 1 ; $i <= $item['Item_Rating'] ; $i++){
                                            echo "<i class='fas fa-star'></i>";
                                        }
                                        echo "</div>";
                                        echo "<span class='price'>".$item['Item_Price']."</span>";
                                        echo "<div class='item_added'> ".$item['Item_Date']."</div>";
                                    echo "</div>";
                                    echo "</div>";
                            echo "</div>";
                            }
                        ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<?php
    }elseif(isset($_GET['view'])){
        $client_user = str_replace("","",filter_var($_GET['view'], FILTER_SANITIZE_STRING));
        $count = checkItem("Username","users",$client_user);

        if($count > 0){
            // Get Information of user
            $stmt_info = $connect->prepare("SELECT Username,user_avatar,UserID,Email,FullName FROM users WHERE Username = $client_user LIMIT 1");
            // Statment To Get All The Information For User
        
        }else{
            echo "Use Doesn't Exists";
        }
        // header("Location:login.php");
        // exit();
    }
    include $tmpl . 'footer.php';
?>