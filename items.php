<?php
    session_start();
    include 'init.php';
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $itemid = isset($_GET['item_id']) && is_numeric($_GET['item_id']) ? $_GET['item_id'] : 0;
            $stmt = $connect->prepare("SELECT items.*,categories.Name,users.Username FROM items 
            INNER JOIN categories ON items.Cat_ID = categories.ID
            INNER JOIN users ON items.User_ID = users.UserID
            WHERE items.Item_ID = ?
            ");
            $stmt->execute(array($itemid));
            $count  = $stmt->rowCount();
            $row    = $stmt->fetch();
            if($count > 0){
?>
    <div class="item-display">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="item-pic">
                        <img src="image-default-news.jpg" alt="Image" class="img-fluid">
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="item-details">
                        <h3 class="item_name"><?php echo $row['Item_Name']?></h3>
                        <ul class="item-list">
                            <li><i class="fas fa-calendar-alt"></i><span class="item-detail"> Added date : <?php echo $row["Item_Date"]?></span></li>
                            <li><i class="fas fa-tags"></i><span class="item-detail"> Price :  <?php echo $row["Item_Price"]?>$</span></li>
                            <li><i class="fas fa-map-marker-alt"></i><span class="item-detail">Made in : <?php echo $row["Item_Country"]?></span></li>
                            <li><i class="fas fa-shopping-bag"></i><span class="item-detail"> Categorie : <?php echo $row["Name"]?></span> </li>
                            <li><i class="fas fa-user-cog"></i><span class="item-detail"> Added By : <?php echo $row["Username"]?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
            }else{
                echo "Sorry There's No Item Exists";
            }
        }
    include $tmpl . 'footer.php';

?>