<?php
    session_start();
    include "init.php";
?>
    <div class="container">
        <h3 class='text-center display-3 mt-4 mb-3'><?php echo str_replace("-"," ",$_GET['pagename']) ?></h3>
        <div class="row">
        <?php
            foreach(getItems("Cat_ID",$_GET['pageid']) as $item){   
                echo "<div class='col-12 col-md-6 col-lg-3'>";
                    echo "<div class='item'>";
                        echo "<div class='item-img d-flex justify-content-center'><img src='img.jpg' class='item-img img-responsive m-auto'></div>";
                        echo "<div class='item-details'>";
                            echo "<span class='item-price'>".$item['Item_Price']."</span>";
                            echo "<h4><a href='items.php?item_id=".$item['Item_ID']."'>".$item['Item_Name']."</a></h4>";
                            echo "<p>".$item['Item_Description']."</p>";
                        echo "</div>";
                        echo "</div>";
                echo "</div>";
            }
        ?>
        </div>
    </div>
<?php
    include $tmpl . "footer.php";

?>