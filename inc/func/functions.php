<?php
  /*
    ***********
    ****** Client Functions
    ***********
  */

  // Check The Client Exists

  function userStatus($value){
    global $connect;
    $stmt = $connect->prepare("SELECT * FROM users WHERE UserID = ? AND RegStatus = ? LIMIT 1");
    $stmt->execute(array($value,1));
    $count = $stmt->rowCount();
    return $count;
   
  }



  /*
    ***********
    ****** categories Functions
    ***********
  */

  // Get Items From Categories
  function getItems($where,$value){
    global $connect;
    $stmt = $connect->prepare("SELECT * FROM items WHERE $where = ? ORDER BY Item_ID DESC");
    $stmt->execute(array($value));
    $items = $stmt->fetchAll();
    return $items;
  }


  // Get Items From Categories
  
  function getCat(){
    global $connect;
    $stmt = $connect->prepare("SELECT * FROM categories ORDER BY Ordering ASC");
    $stmt->execute();
    $cats = $stmt->fetchAll();
    return $cats;

    // Check The Categorie Exists

  }




// Old Functions May Used

  /*
    ***********
    ****** FUNCTION THE TITLE OF PAGE
    ***********
  */


  function getTitle(){
    global $title;
    $title = isset($title) ? $title : "Default";
    echo $title;
  }
  /*
    ***********
    ****** Redirect Page [MSG, SECOND, TO PAGE]
    ***********
  */
  function redirectPage($msg, $second = 2,$toPage){
    echo $msg;
    echo "<div class='alert alert-info col-sm-5 mr-auto ml-auto mt-3'>You Will Redirect After $second Second</div>";
    if(isset($_SERVER['HTTP_REFERER'])){
      if($toPage == "back"){
        $toPage = $_SERVER['HTTP_REFERER'];
      }
      echo 1;
    }else{
      if($toPage == "back"){
        $toPage = "index.php";
      }
    }
    // echo $toPage;
    header("refresh:$second; url=$toPage");
  }
  /*
    ***********
    ****** Redirect Page [!MSG , TO PAGE , SECOND]
    ***********
  */
  function redirectMsg($second = 3,$toPage){
    echo "<div class='alert alert-info col-sm-5 mr-auto ml-auto mt-3'>You Will Redirect After $second Second</div>";
    $toPage = $toPage == "back" ? $_SERVER["HTTP_REFERER"] : $toPage;
    header("refresh:$second; url=$toPage");
  }

  /*
    ***********
    ****** Check The Item Exists In DATABASE
    ***********
  */

  function checkItem($select , $from , $value){
    global $connect;
    $statment = $connect->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statment->execute(array($value));
    $count = $statment->rowCount();

    return $count;
  }


    /*
    ***********
    ****** Check The Item Exists In DATABASE TO EDIT 
    ***********
  */

  function checkItem_Edit($select , $from , $value,$select2,$value2){
    global $connect;
    $statment = $connect->prepare("SELECT $select FROM $from WHERE $select = ? && $select2 != ?");
    $statment->execute(array($value,$value2));
    $count = $statment->rowCount();

    return $count;
  }

  /*
    ***********
    ****** Get Count Elements In Coloumn
    ***********
  */


  function getCount($col,$tbl,$condition = 1){
    global $connect;
    $statment = $connect->prepare("SELECT COUNT($col) FROM $tbl WHERE $condition");
    $statment->execute();

    echo $statment->fetchColumn();

  }

  /*
    *************
    ***** GET LATEST ACTIVITY
    *************
  */

  function getLatest($select,$tbl,$order,$limit = 5){
    global $connect;
    $statment = $connect->prepare("SELECT $select FROM $tbl ORDER BY $order DESC LIMIT $limit");
    $statment->execute();
    $row = $statment->fetchAll();

    return $row;
  }


?>
