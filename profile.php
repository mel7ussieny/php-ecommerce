<?php
    session_start();
    if(isset($_SESSION['Client'])){
        $title = "Profile";
        include 'init.php';
        $stmt = $connect->prepare("SELECT * FROM users WHERE UserId = ?");
        $stmt->execute(array($_SESSION['User_ID']));
        $row = $stmt->fetch();
        $name = $row['FullName'];
        $fname = substr($name,0,strpos($name," "));
        $lname = substr($name,strpos($name, " ")); 
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
                        <img src="model.jpg" alt="Model" class="img-fluid">
                        </div> 
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="user-infos">
                        <form>
                            <div class="user-personal">
                                <span class="title-column">Personal Information :</span>
                                <div class="input-field">
                                    <label for="name">Full Name</label>
                                    <input type="text" value="<?php echo $row['FullName']?>" class="form-control" id="name">
                                </div>
                                <div class="input-field">
                                    <label for="user">Username</label>
                                    <input type="text" value="<?php echo $row['Username']?>" id="user" class="form-control">
                                </div>
                            </div>
                            <div class="user-contact">
                                <span class="title-column">Contact Information : </span>
                                <div class="input-field">
                                    <label for="email">Email</label>
                                    <input type="email" value="<?php echo $row['Email']?>" id="email" class="form-control">
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary mt-2">
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
                                echo "<div class='col-12 col-md-6 col-lg-3'>";
                                echo "<div class='item'>";
                                    echo "<div class='item-img d-flex justify-content-center'><img src='img.jpg' class='item-img img-responsive m-auto'></div>";
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
    }else{
        header("Location:login.php");
        exit();
    }
    include $tmpl . 'footer.php';
?>