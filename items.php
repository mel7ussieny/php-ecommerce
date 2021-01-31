<?php
    session_start();
    $title = "Show item";
    include 'init.php';
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $itemid = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? $_GET['item_id'] : 0;
            $stmt = $connect->prepare("SELECT items.*,categories.Name,users.Username,categories.ID,users.user_avatar FROM items 
            INNER JOIN categories ON items.Cat_ID = categories.ID
            INNER JOIN users ON items.User_ID = users.UserID
            WHERE items.Item_ID = ?
            ");
            $stmt->execute(array($itemid));
            $count  = $stmt->rowCount();
            $row    = $stmt->fetch();
            if($count > 0){
            $img = empty($row['Item_Avatar']) ? "default-item.jpg" : $row['Item_Avatar'];

?>
    <div class="item-display">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="item-pic">
                        <img src="admin/upload/imgs/<?php echo $img?>" alt="Image" class="img-fluid">
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="item-details">
                        <h3 class="item_name"><?php echo $row['Item_Name']?></h3>
                        <ul class="item-list">
                            <li><i class="fas fa-calendar-alt"></i><span class="item-detail"> Added date : <?php echo $row["Item_Date"]?></span></li>
                            <li><i class="fas fa-tags"></i><span class="item-detail"> Price :  <?php echo $row["Item_Price"]?>$</span></li>
                            <li><i class="fas fa-map-marker-alt"></i><span class="item-detail">Made in : <?php echo $row["Item_Country"]?></span></li>
                            <li><i class="fas fa-shopping-bag"></i><span class="item-detail"> Categorie : <a href="categories.php?pageid=<?php echo $row['ID']?>"><?php echo $row["Name"]?></a></span> </li>
                            <li><i class="fas fa-user-cog"></i><span class="item-detail"> Added By : <a href="profile.php?view=<?php echo $row['Username']?>"><?php echo $row["Username"]?></a></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 desc">
                    <span>• Description : </span>
                    <p><?php echo $row['Item_Description']?></p>
                </div>

                <!-- Start Comments -->
                <div class="col-12">
                    <div class="comments">
                        <hr>
                        <h3>Customer questions & answers</h3>
                    <?php
                        $stmt = $connect->prepare("SELECT comments.*,users.Username,users.FullName,users.user_avatar FROM comments
                        INNER JOIN users ON comments.Com_User = users.UserID 
                        WHERE comments.Com_Item = $itemid && Com_Status = 1
                        ");
                        $stmt->execute();
                        $rows = $stmt->fetchAll();
      
                    ?>
<!-- Show The Comments -->
                    <?php
                        foreach($rows as $row){
                        $userimg = empty($row['user_avatar']) ? "default-user.jpg" : $row['user_avatar'];

                    ?>
                    <div class="user-comments">
                        <div class="row">
                            <div class="col-4 col-md-2 d-flex justify-content-center">
                                <div class="left-user">
                                    <div class="user-img">
                                        <img src="admin/upload/imgs/<?php echo $userimg?>" alt="Image" class="img-fluid">
                                    </div>
                                    <div style="text-align:center"><span class="user-name"><a href="profile.php?view=<?php echo $row['Username']?>"><?php echo $row['Username']?></a></span></div>
                                </div>
                            </div>
                            <div class="col-8  offset-md-1 col-md-9 offset-lg-0 col-lg-10 d-flex align-items-center right-user">
                                <div class="comment-text">
                                    <p><?php echo $row['Comment']?></p>
                                    <span class="comment-date">Added : <?php echo $row['Com_Date']?></span>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <?php
                        }
                    ?>
<!-- Show The Comments -->

                                        

                    </div>
                </div>
<?php
if(isset($_SESSION['User_ID'])){
    // View Add Comment Only For Registerd Users
?>
           <div class="col-12">
                    <div class="add-comment">
                        <h4>Please feel free to relay your comments</h4>
                        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $itemid?>">
                            <textarea placeholder="Comment" name="comment" class="form-control"></textarea>
                            <input type="submit" class="btn btn-primary">
                        </form>
                    </div>
                </div>
<?php
}

?>
            </div>
        </div>
    </div>
<?php
            }else{
                echo "Sorry There's No Item Exists";
            }
        }else{
            // Add The Comment To Database
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                if(isset($_SESSION['User_ID'])){
                    $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                    $it_id = $_POST['item_id'];

                    $count = checkItem("Item_ID","items",$it_id);
                    $errors = [];
                    if($count == 0){
                        $erros[] = "Sorry we missed the item";
                    }
                    if(strlen($comment) > 200){
                        $erros[] = "The comment must be less than 200 character";
                    }

                    if(empty($erros)){
                        // Add The Comment To Database
                        $user_id = $_SESSION['User_ID'];
                        $date = date("Y-m-d");
                        $stmt = $connect->prepare("INSERT INTO comments(Comment, Com_Date, Com_Status, Com_User, Com_Item) 
                        VALUES(:zcom,:zdate,0,:zuser,:zitem)");
                        $stmt->execute(array(
                            "zcom" => $comment,
                            "zdate" => $date,
                            "zuser" => $user_id,
                            "zitem" => $it_id
                        ));
                        if($stmt){
                            echo '<div class="alert alert-success col-sm-5 mr-auto ml-auto mt-2">Comment has been added</div>';
                        }

                    }else{
                        foreach($erros as $error){
                            echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                        }        
                    }
                
                }
            }
        }
    include $tmpl . 'footer.php';

?>