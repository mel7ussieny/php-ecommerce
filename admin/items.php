<?php
session_start();
$navbar = 1;

    /*
      =================================
      == Items Page
      =================================
    */

    if(isset($_SESSION['user'])){
        $title = "Items";
        include 'init.php';
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';

        if($action == "Manage"){
            $stmt = $connect->prepare("SELECT items.* , users.Username, categories.Name FROM items 
            INNER JOIN users ON items.User_ID = users.UserID
            INNER JOIN categories ON items.Cat_ID = categories.ID");
            $stmt->execute();
            $row = $stmt->fetchAll();
      ?>
          <div class="container">
          <div class="table-responsive mt-5">
              <table class="table table-bordered text-center table-sm">
                <thead class="thead-light">
                  <tr>
                    <th>ID</th>
                    <th>Registered date</th>
                    <th>Item name</th>
                    <th>Price</th>
                    <th>Country</th>
                    <th>Description</th>
                    <th>Categorie</th>
                    <th>Username</th>
                    <th>Action</th>
                  </tr>  
                <thead>
                <tbody>
          <!-- START DATA OF USERS -->
      <?php
      foreach($row as $key => $value){
        echo "<tr class='text-center'>";
        echo "<td>".$row[$key]['Item_ID']."</td>";
        echo "<td>".$row[$key]['Item_Date']."</td>";
        echo "<td>".$row[$key]['Item_Name']."</td>";
        echo "<td>".$row[$key]['Item_Price']."</td>";
        echo "<td>".$row[$key]['Item_Country']."</td>";
        echo "<td>".$row[$key]['Item_Description']."</td>";
        echo "<td>".$row[$key]['Name']."</td>";
        echo "<td>".$row[$key]['Username']."</td>";

        echo "<td>
                <a href='?action=Delete&Item_ID=".$row[$key]['Item_ID']."' class='confirm btn btn-danger btn-sm'>
                <i class='fas fa-times'></i> 
                Delete
                </a>
                <a href='?action=Edit&Item_ID=".$row[$key]['Item_ID']."' class='btn btn-primary btn-sm'>
                <i class='fas fa-edit'></i>
                Edit
                </a>";
        if($row[$key]["Approve"] == 0){
        echo " <a href='?action=Approve&Item_ID=".$row[$key]['Item_ID']."' class='btn btn-info btn-sm'>
                <i class='fas fa-check-square'></i>
                Approve
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
            <i class="fas fa-tag"></i>
              Add Item
            </a>
          </div>
      <?php
      
        }elseif($action == "Edit"){
            $Item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) == TRUE ? $_GET['Item_ID'] : 0;
            $stmt = $connect->prepare("SELECT items.* , users.Username, categories.Name FROM items 
                                        INNER JOIN users ON items.User_ID = users.UserID
                                        INNER JOIN categories ON items.Cat_ID = categories.ID WHERE items.Item_ID = ? LIMIT 1
                                    ");
            $stmt->execute(array($Item_ID));
            $count = $stmt->rowCount();
            $row = $stmt->fetch();
            if($count > 0){
?>
<div class="container">
    <div class="items">
      <form action="?action=Update" method="POST">
          <div class="form-card form-group col-12 col-md-8 col-lg-6">
            <span class="display-4 text-dark">Edit Items</span>
            <hr style="text-dark">
            <input type="hidden" name="Item_ID" value="<?php echo $row['Item_ID'];?>">
            <input type="text" name="name" value="<?php echo $row['Item_Name'];?>" class="form-control" placeholder="Name" autocomplete="off" required>
            <textarea class="form-control" placeholder="Description" name="desc"><?php echo $row['Item_Description']?></textarea>
            <input type="number" name="price" value="<?php echo $row['Item_Price'];?>" class="form-control" placeholder="Price" autocomplete="off" required>
            <input type="text" name="country" value="<?php echo $row['Item_Country'];?>" class="form-control" placeholder="Country" autocomplete="off" required>
            <select name="item_status" class="item_status">

                <option value="4" <?php if($row['Item_Status'] == 4){echo "selected";}?>>New</option>
                <option value="3" <?php if($row['Item_Rating'] == 3){echo "selected";}?>>Like New</option>
                <option value="2" <?php if($row['Item_Rating'] == 2){echo "selected";}?>>Used</option>
                <option value="1" <?php if($row['Item_Rating'] == 1){echo "selected";}?>>Bad</option>
            </select>

            <select name="rating" class="rating">
                <option value="5" <?php if($row['Item_Rating'] == 5){echo "selected";}?> >5 Stars</option>
                <option value="4" <?php if($row['Item_Rating'] == 4){echo "selected";}?>>4 Stars</option>
                <option value="3" <?php if($row['Item_Rating'] == 3){echo "selected";}?>>3 Stars</option>
                <option value="2" <?php if($row['Item_Rating'] == 2){echo "selected";}?>>2 Stars</option>
                <option value="1" <?php if($row['Item_Rating'] == 1){echo "selected";}?>>1 Stars</option>
            </select>

            <select name="members" class="members">
                <?php
                    $stmt = $connect->prepare("SELECT * FROM users");
                    $stmt->execute();
                    $members = $stmt->fetchAll();

                    foreach($members as $member){
                        $select = "";
                        if($member['UserID'] == $row['User_ID']){
                            $select = "selected";
                        }
                        echo "<option value='".$member['UserID']."'$select>".$member['Username']."</option>";
                    }
                
                ?>
            </select>


            <select name="categories" class="categories">
                <?php
                    $stmt = $connect->prepare("SELECT * FROM categories");
                    $stmt->execute();
                    $categories = $stmt->fetchAll();

                    foreach($categories as $categorie){
                        $select = "";
                        if($categorie['ID'] == $row['Cat_ID']){
                            $select = "selected";
                        }
                        echo "<option value='".$categorie['ID']."'$select>".$categorie['Name']."</option>";
                    }
                
                ?>
            </select>
            
            

            <input type="Submit" value="Edit Item" class="btn-primary form-control" required>
        </div>
      </form>
    </div>
  </div>
<?php
            }else{
                $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>This Record Doesn't Exists</div>";
                redirectPage($msg,3,"items.php");            
            }
        }elseif($action == "Update"){
            // UPDATE ITEM
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $item_ID    = $_POST['Item_ID'];
                $name       = $_POST['name'];
                $desc       = $_POST['desc'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['item_status'];
                $rating     = $_POST['rating'];
                $member     = $_POST['members'];
                $cat        = $_POST['categories'];
                $ErrorsCatch = [];

                if(strlen($name) < 4){
                    $ErrorsCatch[] = "Your username must be grater than 4 characters";
                }
                if($rating == "status"){
                    $ErrorsCatch[] = "Check the status of the item";
                }         
                if(empty($country)){
                    $ErrorsCatch[] = "There's an problem with item country";
                }
                if(empty($price)){
                    $ErrorsCatch[] = "The price can't be empty";

                }

                if(empty($ErrorsCatch)){
                    $stmt = $connect->prepare("UPDATE items SET Item_Name = ?, Item_Description = ?, Item_Price = ?, Item_Country = ?, Item_Status = ?, Item_Rating = ?, User_ID = ?, Cat_ID = ? WHERE Item_ID = ?");
                    $stmt->execute(array($name,$desc,$price,$country,$status,$rating,$member,$cat,$item_ID));
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
?>
<div class="container">
    <div class="items">
      <form action="?action=Insert" method="POST">
          <div class="form-card form-group col-12 col-md-8 col-lg-6">
            <span class="display-4 text-dark">Add Items</span>
            <hr style="text-dark">
            <input type="text" name="name" class="form-control" placeholder="Name" autocomplete="off" required>
            <textarea class="form-control" placeholder="Description" name="desc"></textarea>
            <input type="number" name="price" class="form-control" placeholder="Price" autocomplete="off" required>
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
        </div>
      </form>
    </div>
  </div>
<?php       
        }elseif($action == "Insert"){
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $name       = $_POST['name'];
                $desc       = $_POST['desc'];
                $price      = $_POST['price'];
                $country    = $_POST['country'];
                $status     = $_POST['item_status'];
                $rating     = $_POST['rating'];
                $member     = $_POST['members'];
                $cat        = $_POST['categories'];
                $ErrorsCatch = [];
      
                // Validation Cathces 
                
                // CHECK USER EXISTS

                  // CATCH ERROR IN INSERT
                if(strlen($name) < 4){
                    $ErrorsCatch[] = "Your username must be grater than 4 characters";
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
                  redirectPage($msg,3,"back");
                }else{
                  foreach($ErrorsCatch as $error){
                    echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                  }
                  redirectMsg(3,"items.php");
                }
              }else{
                $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>You don't have permission to access this page</div>";
                redirectPage($msg,3,"items.php");
              }

        }elseif($action == "Delete"){
            $item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) == TRUE ? $_GET['Item_ID'] : 0;
            $check = checkItem("Item_ID","items",$item_ID);
            if($check > 0){
                $stmt = $connect->prepare("DELETE FROM items WHERE Item_ID = ?");
                $stmt->execute(array($item_ID));
                $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-3'>".$stmt->rowCount()." Record deleted</div>";
                redirectPage($msg,2,"back");
            }else{
                $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>There's no record found</div>";
                redirectPage($msg,2,"back");
            }
        }elseif($action == "Approve"){
            $item_ID = isset($_GET['Item_ID']) && is_numeric($_GET['Item_ID']) == TRUE ? $_GET['Item_ID'] : 0;
            $check = checkItem("Item_ID","items",$item_ID);


            if($check > 0){
                $stmt = $connect->prepare("UPDATE items SET Approve = ? WHERE Item_ID = ?");
                $stmt->execute(array(1,$item_ID));
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