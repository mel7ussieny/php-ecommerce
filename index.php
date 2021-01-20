<?php
session_start();
    $title = "Homepage";
    include 'init.php';
    if(getItemsCount("categories") > 0){
    ?>
    <div class="homepage-items">
        <div class="container">
            
            <?php
                // Get the name of the categorie
                echo "<div class='row'>";
                foreach(getAllItems("items") as $item){ 
                    $img = empty($item['Item_Avatar']) ? "default-item.jpg" : $item['Item_Avatar'];

                    echo "<div class='col-12 col-md-6 col-lg-3'>";
                        echo "<div class='item'>";
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
    <?php
    }else{
          echo "<div class='alert alert-danger mt-4 text-center col-6 ml-auto mr-auto'>No items found to show</div>";  
    }
    include $tmpl . 'footer.php';
?>