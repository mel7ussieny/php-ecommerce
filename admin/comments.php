<?php
session_start();
$navbar = 1;

/*
    =================================
    == Comments Page
    =================================
*/

if(isset($_SESSION['user'])){
    $title = "Comments";
    include 'init.php';
    $action = isset($_GET['action']) ? $_GET['action'] : "Manage";
    if($action == "Manage"){
    $stmt = $connect->prepare("SELECT comments.*,users.Username,items.Item_Name FROM comments 
    INNER JOIN items ON comments.Com_Item = items.Item_ID
    INNER JOIN users ON comments.Com_User = users.UserID
    ");
    $stmt->execute();
    $row = $stmt->fetchAll();
?>
        <div class="container">
          <div class="table-responsive mt-5">
              <table class="table table-bordered text-center table-sm">
                <thead class="thead-light">
                  <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Comment</th>
                    <th>Username</th>
                    <th>Item</th>
                    <th>Action</th>
                  </tr>  
                <thead>
                <tbody>
          <!-- START DATA OF USERS -->
      <?php
      foreach($row as $key => $value){
        echo "<tr class='text-center'>";
        echo "<td>".$row[$key]['Com_ID']."</td>";
        echo "<td>".$row[$key]['Com_Date']."</td>";
        echo "<td>".$row[$key]['Comment']."</td>";
        echo "<td>".$row[$key]['Username']."</td>";
        echo "<td>".$row[$key]['Item_Name']."</td>";

        echo "<td>
                <a href='?action=Delete&Com_ID=".$row[$key]['Com_ID']."' class='confirm btn btn-danger btn-sm'>
                <i class='fas fa-times'></i> 
                Delete
                </a>
                <a href='?action=Edit&Com_ID=".$row[$key]['Com_ID']."' class='btn btn-primary btn-sm'>
                <i class='fas fa-edit'></i>
                Edit
                </a>";
        if($row[$key]["Com_Status"] == 0){
        echo " <a href='?action=Approve&Com_ID=".$row[$key]['Com_ID']."' class='btn btn-info btn-sm'>
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
    
          </div>

<?php
    }elseif($action == "Edit"){
        $Com_ID = isset($_GET['Com_ID']) && is_numeric($_GET['Com_ID']) ? $_GET['Com_ID'] : 0;
        $stmt = $connect->prepare("SELECT * FROM comments WHERE Com_ID = ?");
        $stmt->execute(array($Com_ID));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();
        if($count > 0){
?>
        <div class="container">

            <div class="comments col-12 col-md-6">
            <h3 class="display-4">Comment</h3>
                <form action="?action=Update" method="POST">
                    <input type="hidden" name="Com_ID" value="<?php echo $row['Com_ID']?>">
                    <textarea class="form-control" name="Comment"><?php echo $row['Comment']?></textarea>
                    <input type="submit" class="form-control btn-primary">
                </form>
            </div>
        </div>
<?php 
        }else{
            $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>This Record Doesn't Exists</div>";
            redirectPage($msg,3,"comments.php");          
        }

    }elseif($action == "Update"){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $Com_ID = $_POST['Com_ID'];
            $Comment = $_POST['Comment'];
            $ErrorCatch = [];

            if(strlen($Comment) < 5){
                $ErrorCatch[] = "The length must be grater than 5";
            }

            if(empty($ErrorCatch)){
                $stmt = $connect->prepare("UPDATE comments SET Comment = ? , Com_Date = ? WHERE Com_ID = ?");
                $stmt->execute(array($Comment,date("Y-m-d"),$Com_ID));
                $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-2'>" .  $stmt->rowCount() . " Record Updated</div>";
                redirectPage($msg,3,"back");
            }else{
            foreach($ErrorCatch as $error){
                echo "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-2'>".$error."</div>";
                }
                redirectMsg(3,"back");   
            }
        }else{
            $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>You don't have permission to access this page</div>";
            redirectPage($msg,3,"members.php");
        }
    }elseif($action == "Delete"){
        $Com_ID = isset($_GET['Com_ID']) && is_numeric($_GET['Com_ID']) ? $_GET['Com_ID'] : 0;
        $check = checkItem("Com_ID","comments",$Com_ID);
        if($check > 0){
            $stmt = $connect->prepare("DELETE FROM comments WHERE Com_ID = ?");
            $stmt->execute(array($Com_ID));
            $msg = "<div class='alert alert-success col-sm-5 mr-auto ml-auto mt-3'>".$stmt->rowCount()." Record deleted</div>";
            redirectPage($msg,2,"back");
        }else{
            $msg = "<div class='alert alert-danger col-sm-5 mr-auto ml-auto mt-3'>There's no record found</div>";
            redirectPage($msg,2,"back");
        }
    }elseif($action == "Approve"){
        $Com_ID = isset($_GET['Com_ID']) && is_numeric($_GET['Com_ID']) ? $_GET['Com_ID'] : 0;
        $check = checkItem("Com_ID","comments",$Com_ID);


            if($check > 0){
                $stmt = $connect->prepare("UPDATE comments SET Com_Status = ? WHERE Com_ID = ?");
                $stmt->execute(array(1,$Com_ID));
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