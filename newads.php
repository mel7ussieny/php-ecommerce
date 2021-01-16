<?php
    session_start();
    if(isset($_SESSION['Client'])){
        $title = "New advertisement";
        include 'init.php';
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $name       = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $desc       = filter_var($_POST['desc'],FILTER_SANITIZE_STRING);
            $price      = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $country    = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $status     = filter_var($_POST['item_status'],FILTER_SANITIZE_NUMBER_INT);
            $rating     = filter_var($_POST['rating'],FILTER_SANITIZE_NUMBER_INT);
            $member     = $_SESSION['User_ID'];
            $cat        = filter_var($_POST['categories'],FILTER_SANITIZE_STRING);
            $ErrorsCatch = [];
  
            // Validation Cathces 
            
            // CHECK USER EXISTS

              // CATCH ERROR IN INSERT
            if(strlen($name) < 4){
                $ErrorsCatch[] = "The name must be grater than 4 characters";
            }
            if($rating == "status"){
                $ErrorsCatch[] = "Check the status of the item";
            }
            if($rating == "null"){
                $ErrorsCatch[] = "Check the rating of the item";
            }
            if($member == "null"){
                $ErrorsCatch[] = "Check the the member name";
            }
            if($cat == "null"){
                $ErrorsCatch[] = "Check the categorie of the item";
            }
            if(strlen($desc) > 70){
                $ErrorsCatch[] = "The description my be less than 70 letter";
            }            
            if(empty($country)){
                $ErrorsCatch[] = "There's an problem with item country";
            }
            if(empty($price)){
                $ErrorsCatch[] = "The price can't be empty";

            }

            if(empty($ErrorsCatch)){
                $stmt = $connect->prepare("INSERT INTO 
                items(Item_Name, Item_Description, Item_Price, Item_Country, Item_Status, Item_Rating, User_ID, Cat_ID, Item_Date) 
                VALUES(:it_name, :it_desc, :it_price, :it_conutry, :it_status, :it_rating, :it_user, :it_cat, :it_date  )
                ");
                $stmt->execute(array(
                "it_name" => $name,
                "it_desc" => $desc,
                "it_price" => $price,
                "it_conutry" => $country,
                "it_status" => $status,
                "it_rating" => $rating,
                "it_user" => $member,
                "it_cat" => $cat,
                "it_date" => date("Y-m-d")
                ));
                $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-2'>" .  $stmt->rowCount() . " Record Updated</div>";
                redirectPage($msg,3,"items.php");

            }else{
                foreach($ErrorsCatch as $error){
                  echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                }
              }
        }
        ?>
        <div class="adver">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <div class="item-add">
                            <form action="<?php echo $_SERVER['PHP_SELF']?>" style="text-align:center" method="POST">
                                <span class="display-4 text-dark mr-auto ml-auto">Add Items</span>
                                <hr style="text-dark">
                                <input type="text" data-live="item_name" name="name" class="form-control preview" placeholder="Name" autocomplete="off" required>
                                <textarea class="form-control preview" data-live="item_desc" placeholder="Description" name="desc"></textarea>
                                <input type="number" name="price" data-live="item_price" class="form-control preview" placeholder="Price" autocomplete="off" required>
                                <input type="text" name="country" class="form-control" placeholder="Country" autocomplete="off" required>
                                <select name="item_status" class="item_status">
                                    <option value="null">Status</option>
                                    <option value="4" selected>New</option>
                                    <option value="3">Like New</option>
                                    <option value="2">Used</option>
                                    <option value="1">Bad</option>
                                </select>

                                <select name="rating" class="rating">
                                    <option value="null">Rating</option>
                                    <option value="5" selected>5 Stars</option>
                                    <option value="4">4 Stars</option>
                                    <option value="3">3 Stars</option>
                                    <option value="2">2 Stars</option>
                                    <option value="1">1 Stars</option>
                                </select>

                                <select name="members" class="members">
                                    <option value="null">Select Member</option>
                                    <?php
                                        $stmt = $connect->prepare("SELECT * FROM users");
                                        $stmt->execute();
                                        $members = $stmt->fetchAll();

                                        foreach($members as $member){
                                            echo "<option value='".$member['UserID']."'>".$member['Username']."</option>";
                                        }
                                    ?>
                                </select>
                                <select name="categories" class="categories">
                                    <option value="null">Select Categorie</option>
                                    <?php
                                        $stmt = $connect->prepare("SELECT * FROM categories");
                                        $stmt->execute();
                                        $categories = $stmt->fetchAll();

                                        foreach($categories as $categorie){
                                            echo "<option value='".$categorie['ID']."'>".$categorie['Name']."</option>";
                                        }
                                    ?>
                                </select>
                                <input type="Submit" value="Add Item" class="btn-success form-control" required>
                            </form>
                        </div>                    
                    </div>
                    <div class="col-12 offset-md-1 col-md-5">
                        <div class="live-preview">
                        <?php
                            echo "<div class='item'>";
                            echo "<div class='item-img d-flex justify-content-center'><img src='img.jpg' class='item-img img-responsive m-auto'></div>";
                            echo "<div class='item-details'>";
                                echo "<span class='item-price'>$<span class='item_price'></span></span>";
                                echo "<h4 class='item_name'></h4>";
                                echo "<p class='item_desc'></p>";
                            echo "</div>";
                            echo "</div>";
                        
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include $tmpl . "footer.php";

    }else{
        header("Location:login.php");
    }
?>