<?php
    
    /*
    =================================
    == Categories Page
    =================================
    */
   session_start();
   $navbar = 1;
   $title = "Categories";
   if(isset($_SESSION['user'])){
    include 'init.php';
    include 'connect.php';
    $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
    
        if($action == "Manage"){
        // Main Page
        $sort = "ASC";
        $sop = "";
        $sop2 = "";
        if(isset($_GET['sort'])){
            $sort = $_GET['sort'];
        }
        if($sort == "ASC"){
            $sop = "active";
        }else{
            $sop2 = "active";
        }
        $stmt = $connect->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $stmt->execute();
        $row = $stmt->fetchAll();
        echo '<section class="categories">';
        echo '<div class="container">';
        echo '<div class="cat-header"><span class="display-4 text-dark m-auto">Manage Categories</span></div>';
        echo '<div class="cat-add btn btn-success">';
            echo '<div class="cat-add-content">';
                echo '<a href="?action=Add">Add Category</a><i class="fas fa-plus-circle"></i>';
            echo '</div>';
        echo '</div>';
        echo '<div class="sorting">';
        
        echo '<a href="?sort=ASC" class="'.$sop.'">ASC</a> | ';
        echo '<a href="?sort=DESC" class="'.$sop2.'">DESC</a>';
        echo '</div>';
        echo "<div class='cat-rows'>";
        echo "<div class='row'>";
        foreach($row as $key => $value){
            $vis = $row[$key]["Visibility"] == 1 ? "Visibile" : "Hidden";
            $comm = $row[$key]["Allow_Comment"] == 1 ? "Enabled" : "Disabled";
            $ad = $row[$key]["Allow_Ads"] == 1 ? "Enabled" : "Disabled";

        
            echo "<div class='col-12 col-lg-6'>";
                echo "<div class='col-12'>";
                    echo '<div class="options-buttons">';
                    echo '<a href="?action=Edit&ID='.$row[$key]['ID'].'" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i>
                    Edit
                    </a>';
                    echo '<a href="?action=Delete&ID='.$row[$key]['ID'].'" class="btn btn-danger btn-sm">
                    <i class="fas fa-edit"></i>
                    Delete
                    </a>';
                    echo '</div>';
                    echo "<span class='cat-haed'>Categorie #".$row[$key]["Ordering"]."</span>";

                    echo "<div class='content'>";
                        echo "<h5>".$row[$key]["Name"]."</h5>";
                        echo "<p class='lead'>Description: ".$row[$key]["Description"]."</p>";
                    echo "</div>";
                echo "</div>";
                echo '<div class="op">';
                    echo '<span>' .$vis. ' | </span>';
                    echo '<span>Comments ' .$comm. ' | </span>';
                    echo '<span>Ads ' .$ad. '</span>';
                echo '</div>';
            echo "</div>";
        }
        echo "</div>";
        echo '</div>';
        echo "</div>";
        echo '</section>';         

        }elseif($action == "Add"){
?>
<div class="container">
      <form action="?action=Insert" method="POST">
          <div class="form-card form-group col-12 col-md-8 col-lg-6">
            <span class="display-4 text-dark">Add Categories</span>
            <hr style="text-dark">
            <input type="text" name="name" class="form-control" placeholder="Name" autocomplete="off" required>
            <textarea class="form-control" placeholder="Description" name="desc"></textarea>
            <input type="number" name="order" class="form-control" placeholder="Order" autocomplete="off" required>
            <div class="options">
                <div class="option1">
                <span>Visible : </span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="visible" id="visible1" value="1">
                    <label class="form-check-label" for="visible1">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="visible" id="visible2" value="0">
                    <label class="form-check-label" for="visible2">No</label>
                </div>
            </div>
            <div class="option2">
                <span>Allow Comments : </span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="comments" id="comment1" value="1">
                    <label class="form-check-label" for="comment1">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="comments" id="comment2" value="0">
                    <label class="form-check-label" for="comment2">No</label>
                </div>
            </div>
            <div class="option3">
                <span>Allow Ads : </span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="ads" id="ads1" value="1">
                    <label class="form-check-label" for="ads1">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="ads" id="ads2" value="0">
                    <label class="form-check-label" for="ads2">No</label>
                </div>
            </div>

            </div>
            <input type="Submit" value="Add Category" class="btn-success form-control" required>
        </div>
      </form>
  </div>
<?php
    }
    
        elseif($action == "Insert"){
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $name   = $_POST['name'];
                $desc   = $_POST['desc'];
                $order   = $_POST['order'];
                $visible = isset($_POST['visible']) ? $_POST['visible'] : 0;
                $comment = isset($_POST['comments']) ? $_POST['comments'] : 0;
                $ads = isset($_POST['ads']) ? $_POST['ads'] : 0;


                $ErrorsCatch = [];
    
                // Validation Cathces 
                
                // CHECK USER EXISTS
                $check_order = checkItem("Ordering","categories",$order);
                $check = checkItem("name","categories",$name);
                // echo $check_order;
                if($check > 0 || $check_order > 0){
                $ErrorsCatch[] = "You have entered an data that already exists";
                }else{
                // CATCH ERROR IN INSERT
                    if(strlen($name) < 4){
                        $ErrorsCatch[] = "The name must be grater than 4 characters";
                    }
                    if(empty($desc)){
                        $ErrorsCatch[] = "Each department must contain description";
                    }
                    if(!isset($_POST['visible']) || !isset($_POST['ads']) || !isset($_POST['comments'])){
                        $ErrorsCatch[] = "You have to check the requirements";
                    }

                }
                
                
    
                if(empty($ErrorsCatch)){
                $stmt = $connect->prepare("INSERT INTO 
                categories(Name, Description, Ordering, Visibility,Allow_Comment,Allow_Ads) 
                VALUES(:zname, :zdesc, :zorder, :zvisb,:zcomment,:zads)
                ");
                $stmt->execute(array(
                "zname" => $name,
                "zdesc" => $desc,
                "zorder" => $order,
                "zvisb" => $visible,
                "zcomment" => $comment,
                "zads" => $ads
                ));
    
                $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-2'>" .  $stmt->rowCount() . " Record Updated</div>";
                redirectPage($msg,3,"back");
                }else{
                foreach($ErrorsCatch as $error){
                    echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                }
                redirectMsg(3,"categories.php");
                }
            }else{
                $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>You don't have permission to access this page</div>";
                redirectPage($msg,3,"categories.php");
            }
        }elseif($action == "Edit"){
            $ID = isset($_GET['ID']) && is_numeric($_GET['ID']) == TRUE ? $_GET['ID'] : 0;

        
            $stmt = $connect->prepare("SELECT * FROM categories WHERE ID = ? LIMIT 1");
            $stmt->execute(array($ID));
            $count = $stmt->rowCount();
            $row = $stmt->fetch();
      
            if($count > 0){ 
                $op2 = "checked";
                $op1 = "";
                $op3 = "";
                $op4 = "checked";
                $op5 = "";
                $op6 = "checked";
                if($row['Visibility'] == 1){
                    $op1 = "checked";
                    $op2 = "";
                }
                if($row['Allow_Comment'] == 1){
                    $op3 = "checked";
                    $op4 = "";
                }
                if($row['Allow_Ads'] == 1){
                    $op5 = "checked";
                    $op6 = "";
                }
      ?>
        <div class="container">
            <form action="?action=Update" method="POST">
                <div class="form-card form-group col-sm-12 col-md-6">
                    <span class="display-4 text-dark">Edit Category</span>
                    <hr style="text-dark">
                    <input type="hidden" name="ID_CAT" value="<?php echo $row['ID']?>">
                    <input type="text"  name="name" class="form-control"   value="<?php echo $row['Name']?>" placeholder="Name" required>
                    <textarea class="form-control" placeholder="Description" name="desc"><?php echo $row['Description']?></textarea>
                    <input type="number" name="order" class="form-control" placeholder="Order" value="<?php echo $row['Ordering']?>" autocomplete="off" required>
                    <div class="options">
                <div class="option1">
                <span>Visible : </span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="visible" id="visible1" value="1" <?php echo $op1?> >
                    <label class="form-check-label" for="visible1">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="visible" id="visible2" value="0" <?php echo $op2?>>
                    <label class="form-check-label" for="visible2">No</label>
                </div>
            </div>
            <div class="option2">
                <span>Allow Comments : </span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="comments" id="comment1" value="1" <?php echo $op3?>>
                    <label class="form-check-label" for="comment1">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="comments" id="comment2" value="0" <?php echo $op4?>>
                    <label class="form-check-label" for="comment2">No</label>
                </div>
            </div>
            <div class="option3">
                <span>Allow Ads : </span>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="ads" id="ads1" value="1" <?php echo $op5?>>
                    <label class="form-check-label" for="ads1">Yes</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="ads" id="ads2" value="0" <?php echo $op6?>>
                    <label class="form-check-label" for="ads2">No</label>
                </div>
            </div>

            </div>
                    <input type="Submit" value="Save" class="btn-primary form-control" required>
              </div>
            </form>
        </div>
      <?php
        }else{
          $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>This Record Doesn't Exists</div>";
          redirectPage($msg,3,"members.php");
        }

        }elseif($action == "Update"){
            
// UPDATE ACTION

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id_cat = $_POST['ID_CAT'];
    $name   = $_POST['name'];
    $desc   = $_POST['desc'];
    $order   = $_POST['order'];
    $visible = isset($_POST['visible']) ? $_POST['visible'] : 0;
    $comment = isset($_POST['comments']) ? $_POST['comments'] : 0;
    $ads = isset($_POST['ads']) ? $_POST['ads'] : 0;

    $ErrorsCatch = [];


    // CATCH ERROR IN INSERT
    $check_order = checkItem_Edit("Ordering","categories",$order,"ID",$id_cat);
    $check = checkItem_Edit("name","categories",$name,"ID",$id_cat);
    // echo $check_order;
    echo $check;
    
    if($check > 0 || $check_order > 0){
    $ErrorsCatch[] = "You have entered an data that already exists";
    }else{
    // CATCH ERROR IN INSERT
        if(strlen($name) < 4){
            $ErrorsCatch[] = "The name must be grater than 4 characters";
        }
        if(empty($desc)){
            $ErrorsCatch[] = "Each department must contain description";
        }
        if(!isset($_POST['visible']) || !isset($_POST['ads']) || !isset($_POST['comments'])){
            $ErrorsCatch[] = "You have to check the requirements";
        }

    }
    

    if(empty($ErrorsCatch)){
      $stmt = $connect->prepare("UPDATE categories SET Name = ? , Description = ? , Ordering = ?, Visibility = ? , Allow_Comment = ? , Allow_Ads = ? WHERE ID = ?");
      $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads,$id_cat));

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
    redirectPage($msg,3,"categories.php");
  }
  
}elseif($action == "Delete"){
            $ID = isset($_GET['ID']) && is_numeric($_GET['ID']) == TRUE ? $_GET['ID'] : 0;
            $check = checkItem("ID","categories",$ID);

            if($check > 0){
            $stmt = $connect->prepare("DELETE FROM categories WHERE ID = ?");
            $stmt->execute(array($ID));
            $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-3'>".$stmt->rowCount()." Record deleted</div>";
            redirectPage($msg,2,"back");
            }else{
            $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>There's no record found</div>";
            redirectPage($msg,2,"back");
            }

        }elseif($action == "Activate"){

        }
    include $tmpl . "footer.php";
   }else{
       header("Location:index.php");
       exit();
   }

?>