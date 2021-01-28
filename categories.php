<?php
    session_start();
    include "init.php";
?>
    <div class="container">
        
        <?php
        $pageid = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? $_GET['pageid'] : 0;
        $count = checkItem("ID","categories",$pageid);

        if($count > 0){
            // Get the name of the categorie
            $name = getCat("WHERE ID = ".$_GET['pageid']);
            echo "<h3 class='text-center display-3 mt-4 mb-3'>".$name[0]['Name']."</h3>";
            echo "<div class='row'>";
            foreach(getItems("Cat_ID",$_GET['pageid']) as $item){ 

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
        }else{
            echo "<div class='alert alert-danger col-12 text-center mt-3'>We didn't find your request</div>";
        }
            
        ?>
        </div>
    </div>
<?php
    include $tmpl . "footer.php";

?>